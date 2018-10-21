<?php

namespace Krizalys\Onedrive;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7;
use Krizalys\Onedrive\Proxy\DriveItemProxy;
use Krizalys\Onedrive\Proxy\DriveProxy;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @class Client
 *
 * A Client instance allows communication with the OneDrive API and perform
 * operations programmatically.
 *
 * For an overview of the OneDrive protocol flow, see here:
 * http://msdn.microsoft.com/en-us/library/live/hh243647.aspx
 *
 * To manage your Live Connect applications, see here:
 * https://account.live.com/developers/applications/index
 * Or here:
 * https://manage.dev.live.com/ (not working?)
 *
 * For an example implementation, see here:
 * https://github.com/drumaddict/skydrive-api-yii/blob/master/SkyDriveAPI.php
 */
class Client
{
    /**
     * @var string
     *      The base URL for API requests.
     */
    const API_URL = 'https://apis.live.net/v5.0/';

    /**
     * @var string
     *      The base URL for authorization requests.
     */
    const AUTH_URL = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';

    /**
     * @var string
     *      The base URL for token requests.
     */
    const TOKEN_URL = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';

    /**
     * @var GuzzleHttp\ClientInterface The Guzzle HTTP client.
     */
    private $httpClient;

    /**
     * @var Microsoft\Graph\Graph The Microsoft Graph.
     */
    public $graph;

    /**
     * @var string
     *      The client ID.
     */
    private $_clientId;

    /**
     * @var object
     *      The OAuth state (token, etc...).
     */
    private $_state;

    /**
     * @var Logger
     *      The logger.
     */
    private $_logger;

    /**
     * @var int
     *      The last HTTP status received.
     */
    private $_httpStatus;

    /**
     * @var string
     *      The last Content-Type received.
     */
    private $_contentType;

    /**
     * @var bool
     *      Whether to verify SSL hosts and peers.
     */
    private $_sslVerify;

    /**
     * @var null|string
     *      Override SSL CA path for verification (only relevant when
     *      verifying).
     */
    private $_sslCaPath;

    /**
     * @var int
     *      The name conflict behavior.
     */
    private $_nameConflictBehavior;

    /**
     * @var int
     *      The stream back end.
     */
    private $_streamBackEnd;

    /**
     * @var NameConflictBehaviorParameterizer
     *      The name conflict behavior parameterizer.
     */
    private $_nameConflictBehaviorParameterizer;

    /**
     * @var StreamOpener
     *      The stream opener.
     */
    private $_streamOpener;

    /**
     * Creates a base cURL object which is compatible with the OneDrive API.
     *
     * @param string $path
     *        The path of the API call (eg. me/skydrive).
     * @param array $options
     *        Extra cURL options to apply.
     *
     * @return resource
     *         A compatible cURL object.
     */
    private function _createCurl($path, array $options = [])
    {
        $curl = curl_init();

        $defaultOptions = [
            // General options.
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER    => true,

            // SSL options.
            // The value 2 checks the existence of a common name and also
            // verifies that it matches the hostname provided.
            CURLOPT_SSL_VERIFYHOST => ($this->_sslVerify ? 2 : false),

            CURLOPT_SSL_VERIFYPEER => $this->_sslVerify,
        ];

        if ($this->_sslVerify && $this->_sslCaPath) {
            $defaultOptions[CURLOPT_CAINFO] = $this->_sslCaPath;
        }

        // See http://php.net/manual/en/function.array-merge.php for a
        // description of the + operator (and why array_merge() would be wrong).
        $finalOptions = $options + $defaultOptions;

        curl_setopt_array($curl, $finalOptions);
        return $curl;
    }

    /**
     * Processes a result returned by the OneDrive API call using a cURL object.
     *
     * @param resource $curl
     *        The cURL object used to perform the call.
     *
     * @return object|string
     *         The content returned, as an object instance if served a JSON, or
     *         as a string if served as anything else.
     *
     * @throws \Exception
     *         Thrown if curl_exec() fails.
     */
    private function _processResult($curl)
    {
        $result = curl_exec($curl);

        if (false === $result) {
            throw new \Exception('curl_exec() failed: ' . curl_error($curl));
        }

        $info = curl_getinfo($curl);

        $this->_httpStatus = array_key_exists('http_code', $info) ?
            (int) $info['http_code'] : null;

        $this->_contentType = array_key_exists('content_type', $info) ?
            (string) $info['content_type'] : null;

        // Parse nothing but JSON.
        if (1 !== preg_match('|^application/json|', $this->_contentType)) {
            return $result;
        }

        // Empty JSON string is returned as an empty object.
        if ('' == $result) {
            return (object) [];
        }

        $decoded = json_decode($result);
        $vars    = get_object_vars($decoded);

        if (array_key_exists('error', $vars)) {
            throw new \Exception($decoded->error->message,
                (int) $decoded->error->code);
        }

        return $decoded;
    }

    /**
     * Constructor.
     *
     * @param array $options
     *        The options to use while creating this object.
     *        Valid supported keys are:
     *          - 'state' (object) When defined, it should contain a valid
     *            OneDrive client state, as returned by getState(). Default: [].
     *          - 'logger' (Logger) A LoggerInterface instance. Default:
     *            new Logger('Krizalys\Onedrive\Client') which logs every
     *            message to 'php://stderr'.
     *          - 'ssl_verify' (bool) Whether to verify SSL hosts and peers.
     *            Default: false.
     *          - 'ssl_capath' (bool|string) CA path to use for verifying SSL
     *            certificate chain. Default: false.
     *          - 'name_conflict_behavior' (int) Default name conflict behavior.
     *            Either: NameConflictBehavior::FAIL,
     *            NameConflictBehavior::RENAME or NameConflictBehavior::REPLACE.
     *            Default: NameConflictBehavior::REPLACE.
     *          - 'stream_back_end' (int) Default stream back end.
     *            Either StreamBackEnd::MEMORY or StreamBackEnd::TEMP. Default:
     *            StreamBackEnd::MEMORY.
     *            Using temporary files is recommended when uploading big files.
     *            Default: StreamBackEnd::MEMORY.
     */
    public function __construct(array $options = [])
    {
        $this->httpClient = new GuzzleHttpClient([
            'base_uri' => 'https://graph.microsoft.com/v1.0/',
        ]);

        $this->graph = new Graph();

        $this->_clientId = array_key_exists('client_id', $options)
            ? (string) $options['client_id'] : null;

        $this->_state = array_key_exists('state', $options)
            ? $options['state'] : (object) [
                'redirect_uri' => null,
                'token'        => null,
            ];

        if (array_key_exists('logger', $options)) {
            $logger = $options['logger'];
        } else {
            $logger = new Logger('Krizalys\Onedrive\Client');
            $logger->pushHandler(new StreamHandler('php://stderr'));
        }

        $this->_logger = $logger;

        $this->_sslVerify = array_key_exists('ssl_verify', $options)
            ? $options['ssl_verify'] : false;

        $this->_sslCaPath = array_key_exists('ssl_capath', $options)
            ? $options['ssl_capath'] : false;

        $this->_nameConflictBehavior =
            array_key_exists('name_conflict_behavior', $options) ?
            $options['name_conflict_behavior']
            : NameConflictBehavior::REPLACE;

        $this->_streamBackEnd = array_key_exists('stream_back_end', $options)
            ? $options['stream_back_end'] : StreamBackEnd::MEMORY;

        $this->_nameConflictBehaviorParameterizer =
            new NameConflictBehaviorParameterizer();

        $this->_streamOpener = new StreamOpener();
    }

    /**
     * Gets the name conflict behavior of this client instance.
     *
     * @return int
     *         The name conflict behavior.
     */
    public function getNameConflictBehavior()
    {
        return $this->_nameConflictBehavior;
    }

    /**
     * Gets the stream back end of this client instance.
     *
     * @return int
     *         The stream back end.
     */
    public function getStreamBackEnd()
    {
        return $this->_streamBackEnd;
    }

    /**
     * Gets the current state of this Client instance. Typically saved in the
     * session and passed back to the Client constructor for further requests.
     *
     * @return object
     *         The state of this Client instance.
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Gets the URL of the log in form. After login, the browser is redirected
     * to the redirect URI, and a code is passed as a query string parameter to
     * this URI.
     *
     * The browser is also redirected to the redirect URI if the user is already
     * logged in.
     *
     * @param array $scopes
     *        The OneDrive scopes requested by the application. Supported
     *        values:
     *          - 'offline_access'
     *          - 'files.read'
     *          - 'files.read.all'
     *          - 'files.readwrite'
     *          - 'files.readwrite.all'
     * @param string $redirectUri
     *        The URI to which to redirect to upon successful log in.
     *
     * @return string
     *         The log in URL.
     *
     * @throws \Exception
     *         Thrown if this Client instance's clientId is not set.
     */
    public function getLogInUrl(array $scopes, $redirectUri)
    {
        if (null === $this->_clientId) {
            throw new \Exception(
                'The client ID must be set to call getLogInUrl()'
            );
        }

        $redirectUri                = (string) $redirectUri;
        $this->_state->redirect_uri = $redirectUri;

        $values = [
            'client_id'     => $this->_clientId,
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'scope'         => implode(' ', $scopes),
            'response_mode' => 'query',
        ];

        $query = http_build_query($values, '', '&', PHP_QUERY_RFC3986);

        // When visiting this URL and authenticating successfully, the agent is
        // redirected to the redirect URI, with a code passed in the query
        // string (the name of the variable is "code"). This is suitable for
        // PHP.
        return self::AUTH_URL . "?$query";
    }

    /**
     * Gets the access token expiration delay.
     *
     * @return int
     *         The token expiration delay, in seconds.
     */
    public function getTokenExpire()
    {
        return $this->_state->token->obtained
            + $this->_state->token->data->expires_in - time();
    }

    /**
     * Gets the status of the current access token.
     *
     * @return int
     *         The status of the current access token:
     *           -  0 No access token.
     *           - -1 Access token will expire soon (1 minute or less).
     *           - -2 Access token is expired.
     *           -  1 Access token is valid.
     */
    public function getAccessTokenStatus()
    {
        if (null === $this->_state->token) {
            return 0;
        }

        $remaining = $this->getTokenExpire();

        if (0 >= $remaining) {
            return -2;
        }

        if (60 >= $remaining) {
            return -1;
        }

        return 1;
    }

    /**
     * Obtains a new access token from OAuth. This token is valid for one hour.
     *
     * @param string $clientSecret
     *        The OneDrive client secret.
     * @param string $code
     *        The code returned by OneDrive after successful log in.
     * @param string $redirectUri
     *        Must be the same as the redirect URI passed to getLogInUrl().
     *
     * @throws \Exception
     *         Thrown if this Client instance's clientId is not set.
     * @throws \Exception
     *         Thrown if the redirect URI of this Client instance's state is not
     *         set.
     */
    public function obtainAccessToken($clientSecret, $code)
    {
        if (null === $this->_clientId) {
            throw new \Exception(
                'The client ID must be set to call obtainAccessToken()'
            );
        }

        if (null === $this->_state->redirect_uri) {
            throw new \Exception(
                'The state\'s redirect URI must be set to call'
                    . ' obtainAccessToken()'
            );
        }

        $values = [
            'client_id'     => $this->_clientId,
            'redirect_uri'  => $this->_state->redirect_uri,
            'client_secret' => (string) $clientSecret,
            'code'          => (string) $code,
            'grant_type'    => 'authorization_code',
        ];

        $response = $this->httpClient->post(
            self::TOKEN_URL,
            ['form_params' => $values]
        );

        $body = $response->getBody();
        $data = json_decode($body);

        if (null === $data) {
            throw new \Exception('json_decode() failed');
        }

        $this->_state->redirect_uri = null;

        $this->_state->token = (object) [
            'obtained' => time(),
            'data'     => $data,
        ];

        $this->graph->setAccessToken($this->_state->token->data->access_token);
    }

    /**
     * Renews the access token from OAuth. This token is valid for one hour.
     *
     * @param string $clientSecret
     *        The client secret.
     */
    public function renewAccessToken($clientSecret)
    {
        if (null === $this->_clientId) {
            throw new \Exception(
                'The client ID must be set to call renewAccessToken()'
            );
        }

        if (null === $this->_state->token->data->refresh_token) {
            throw new \Exception(
                'The refresh token is not set or no permission for'
                    . ' \'wl.offline_access\' was given to renew the token'
            );
        }

        $url = self::TOKEN_URL;

        $curl = curl_init();

        curl_setopt_array($curl, [
            // General options.
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_POST           => 1, // i am sending post data

            CURLOPT_POSTFIELDS =>
                'client_id=' . urlencode($this->_clientId)
                    . '&client_secret=' . urlencode($clientSecret)
                    . '&grant_type=refresh_token'
                    . '&refresh_token=' . urlencode(
                        $this->_state->token->data->refresh_token
                    ),

            // SSL options.
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL            => $url,
        ]);

        $result = curl_exec($curl);

        if (false === $result) {
            if (curl_errno($curl)) {
                throw new \Exception(
                    'curl_setopt_array() failed: ' . curl_error($curl)
                );
            } else {
                throw new \Exception('curl_setopt_array(): empty response');
            }
        }

        $decoded = json_decode($result);

        if (null === $decoded) {
            throw new \Exception('json_decode() failed');
        }

        $this->_state->token = (object) [
            'obtained' => time(),
            'data'     => $decoded,
        ];
    }

    /**
     * Performs a call to the OneDrive API using the GET method.
     *
     * @param string $path
     *        The path of the API call (eg. me/skydrive).
     * @param array $options
     *        Further curl options to set.
     *
     * @return object|string
     *         The response body, if any.
     */
    public function apiGet($path, array $options = [])
    {
        $url =
            self::API_URL
                . $path
                . '?access_token=' . urlencode(
                    $this->_state->token->data->access_token
                );

        $curl = self::_createCurl($path, $options);
        curl_setopt($curl, CURLOPT_URL, $url);
        return $this->_processResult($curl);
    }

    /**
     * Performs a call to the OneDrive API using the PUT method.
     *
     * @param string $path
     *        The path of the API call (eg. me/skydrive).
     * @param resource $stream
     *        The data stream to upload.
     * @param string $contentType
     *        The MIME type of the data stream, or null if unknown. Default:
     *        null.
     *
     * @return object|string
     *         The response body, if any.
     */
    public function apiPut($path, $stream, $contentType = null)
    {
        $url   = self::API_URL . $path;
        $curl  = self::_createCurl($path);
        $stats = fstat($stream);

        $headers = [
            'Authorization: Bearer ' . $this->_state->token->data->access_token,
        ];

        if (null !== $contentType) {
            $headers[] = 'Content-Type: ' . $contentType;
        }

        $options = [
            CURLOPT_URL        => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_PUT        => true,
            CURLOPT_INFILE     => $stream,
            CURLOPT_INFILESIZE => $stats[7], // Size
        ];

        curl_setopt_array($curl, $options);
        return $this->_processResult($curl);
    }

    /**
     * Performs a call to the OneDrive API using the MOVE method.
     *
     * @param string $path
     *        The path of the API call (eg. me/skydrive).
     * @param array|object $data
     *        The data to pass in the body of the request.
     *
     * @return object|string
     *         The response body, if any.
     */
    public function apiMove($path, $data)
    {
        $url  = self::API_URL . $path;
        $data = (object) $data;
        $curl = self::_createCurl($path);

        curl_setopt_array($curl, [
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => 'MOVE',

            CURLOPT_HTTPHEADER    => [
                // The data is sent as JSON as per OneDrive documentation.
                'Content-Type: application/json',

                'Authorization: Bearer '
                    . $this->_state->token->data->access_token,
            ],

            CURLOPT_POSTFIELDS    => json_encode($data),
        ]);

        return $this->_processResult($curl);
    }

    /**
     * Performs a call to the OneDrive API using the COPY method.
     *
     * @param string $path
     *        The path of the API call (eg. me/skydrive).
     * @param array|object $data
     *        The data to pass in the body of the request.
     *
     * @return object|string
     *         The response body, if any.
     */
    public function apiCopy($path, $data)
    {
        $url  = self::API_URL . $path;
        $data = (object) $data;
        $curl = self::_createCurl($path);

        curl_setopt_array($curl, [
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => 'COPY',

            CURLOPT_HTTPHEADER    => [
                // The data is sent as JSON as per OneDrive documentation.
                'Content-Type: application/json',

                'Authorization: Bearer '
                    . $this->_state->token->data->access_token,
            ],

            CURLOPT_POSTFIELDS    => json_encode($data),
        ]);

        return $this->_processResult($curl);
    }

    /**
     * @return array
     *
     */
    public function getDrives()
    {
        $endpoint = '/me/drives';

        $response = $this
            ->graph
            ->createCollectionRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception("Unexpected status code produced by 'GET $endpoint': $status");
        }

        $drives = $response->getResponseAsObject(Model\Drive::class);

        return array_map(function (Model\Drive $drive) {
            return new DriveProxy($this->graph, $drive);
        }, $drives);
    }

    /**
     * @param string $driveId
     *
     *
     * @return DriveProxy
     *
     */
    public function getDriveById($driveId)
    {
        $endpoint = "/drives/$driveId";

        $response = $this
            ->graph
            ->createRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception();
        }

        $drive = $response->getResponseAsObject(Model\Drive::class);
        return new DriveProxy($this->graph, $drive);
    }

    /**
     * @param string $driveId
     *
     * @param string $itemId
     *
     *
     * @return DriveProxy
     *
     */
    public function getDriveItemById($driveId, $itemId)
    {
        $locator  = "items/$itemId";
        $endpoint = "/drives/$driveId/$locator";

        $response = $this
            ->graph
            ->createRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception();
        }

        $driveItem = $response->getResponseAsObject(Model\DriveItem::class);
        return new DriveItemProxy($this->graph, $driveItem);
    }

    /**
     * @return DriveItemProxy
     *         The root drive item.
     */
    public function getRoot()
    {
        $locator  = 'root';
        $endpoint = "/me/drive/$locator";

        $response = $this
            ->graph
            ->createRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception("Unexpected status code produced by 'GET $endpoint': $status");
        }

        $driveItem = $response->getResponseAsObject(Model\DriveItem::class);
        return new DriveItemProxy($this->graph, $driveItem);
    }

    ////////////////////////////////////////////////////////////////////////////
    /**
     * Creates a folder in the current OneDrive account.
     *
     * @param string $name
     *        The name of the OneDrive folder to be created.
     * @param null|string $parentId
     *        The ID of the OneDrive folder into which to create the OneDrive
     *        folder, or null to create it in the OneDrive root folder. Default:
     *        null.
     * @param null|string $description
     *        The description of the OneDrive folder to be created, or null to
     *        create it without a description. Default: null.
     *
     * @return Folder
     *         The folder created, as a Folder instance referencing to the
     *         OneDrive folder created.
     */
    public function createFolder($name, $parentId = null, $description = null)
    {
        $parent = $parentId !== null ? "items/" . rawurlencode($parentId) : 'root';

        $driveItem = [
            /*"audio" => [ "@odata.type" => "microsoft.graph.audio" ],
            "content" => [ "@odata.type" => "Edm.Stream" ],
            "cTag" => "string (etag)",
            "deleted" => [ "@odata.type" => "microsoft.graph.deleted" ],
            "description" => "string",
            "file" => [ "@odata.type" => "microsoft.graph.file" ],
            "fileSystemInfo" => [ "@odata.type" => "microsoft.graph.fileSystemInfo" ],*/
            "folder" => [ "@odata.type" => "microsoft.graph.folder" ],
/*            "image" => [ "@odata.type" => "microsoft.graph.image" ],
            "location" => [ "@odata.type" => "microsoft.graph.geoCoordinates" ],
            "malware" => [ "@odata.type" => "microsoft.graph.malware" ],
            "package" => [ "@odata.type" => "microsoft.graph.package" ],
            "photo" => [ "@odata.type" => "microsoft.graph.photo" ],
            "publication" => [ "@odata.type" => "microsoft.graph.publicationFacet" ],
            "remoteItem" => [ "@odata.type" => "microsoft.graph.remoteItem" ],
            "root" => [ "@odata.type" => "microsoft.graph.root" ],
            "searchResult" => [ "@odata.type" => "microsoft.graph.searchResult" ],
            "shared" => [ "@odata.type" => "microsoft.graph.shared" ],
            "sharepointIds" => [ "@odata.type" => "microsoft.graph.sharepointIds" ],
            "size" => 1024,
            "specialFolder" => [ "@odata.type" => "microsoft.graph.specialFolder" ],
            "video" => [ "@odata.type" => "microsoft.graph.video" ],
            "webDavUrl" => "string",*/

            /* relationships */
            /*"activities" => [[ "@odata.type" => "microsoft.graph.itemActivity" ]],
            "children" => [[ "@odata.type" => "microsoft.graph.driveItem" ]],
            "permissions" => [[ "@odata.type" => "microsoft.graph.permission" ]],
            "thumbnails" => [[ "@odata.type" => "microsoft.graph.thumbnailSet" ]],
            "versions" => [[ "@odata.type" => "microsoft.graph.driveItemVersion" ]],*/

            /* inherited from baseItem */
            /*"id" => "string (identifier)",
            "createdBy" => [ "@odata.type" => "microsoft.graph.identitySet" ],
            "createdDateTime" => "String (timestamp)",
            "eTag" => "string",
            "lastModifiedBy" => [ "@odata.type" => "microsoft.graph.identitySet" ],
            "lastModifiedDateTime" => "String (timestamp)",*/
            "name" => (string) $name,
/*            "parentReference" => [ "@odata.type" => "microsoft.graph.itemReference" ],
            "webUrl" => "string",*/

            /* instance annotations */
/*            "@microsoft.graph.conflictBehavior" => "string",
            "@microsoft.graph.downloadUrl" => "url",
            "@microsoft.graph.sourceUrl" => "url"*/
        ];

        if (null !== $description) {
            $driveItem['description'] = (string) $description;
        }

        $driveItem = $this
            ->graph
            ->createRequest('POST', "/me/drive/$parent/children")
            ->attachBody($driveItem)
            ->setReturnType(Model\DriveItem::class)
            ->execute();

        return new Folder($this, $driveItem->getId(), $driveItem);
    }

    /**
     * Creates a file in the current OneDrive account.
     *
     * @param string $name
     *        The name of the OneDrive file to be created.
     * @param null|string $parentId
     *        The ID of the OneDrive folder into which to create the OneDrive
     *        file, or null to create it in the OneDrive root folder. Default:
     *        null.
     * @param string|resource $content
     *        The content of the OneDrive file to be created, as a string or as
     *        a resource to an already opened file. In the latter case, the
     *        responsibility to close the handle is left to the calling
     *        function. Default: ''.
     * @param array $options
     *        The options.
     *
     * @return File
     *         The file created, as File instance referencing to the OneDrive
     *         file created.
     *
     * @throws \Exception
     *         Thrown on I/O errors.
     */
    public function _createFile(
        $name,
        $parentId = null,
        $content = '',
        array $options = []
    ) {
        if (null === $parentId) {
            $parentId = 'me/skydrive';
        }

        if (is_resource($content)) {
            $stream = $content;
        } else {
            $options = array_merge([
                'stream_back_end' => $this->_streamBackEnd,
            ], $options);

            $stream = $this
                ->_streamOpener
                ->open($options['stream_back_end']);

            if (false === $stream) {
                throw new \Exception('fopen() failed');
            }

            if (false === fwrite($stream, $content)) {
                fclose($stream);
                throw new \Exception('fwrite() failed');
            }

            if (!rewind($stream)) {
                fclose($stream);
                throw new \Exception('rewind() failed');
            }
        }

        $options = array_merge([
            'name_conflict_behavior' => $this->_nameConflictBehavior,
        ], $options);

        $params = $this
            ->_nameConflictBehaviorParameterizer
            ->parameterize([], $options['name_conflict_behavior']);

        $query = http_build_query($params);

        /**
         * @todo some versions of cURL cannot PUT memory streams? See here for a
         * workaround: https://bugs.php.net/bug.php?id=43468
         */
        $file = $this->apiPut(
            $parentId . '/files/' . urlencode($name) . "?$query",
            $stream
        );

        // Close the handle only if we opened it within this function.
        if (!is_resource($content)) {
            fclose($stream);
        }

        return new File($this, $file->id, $file);
    }

    public function createFile(
        $name,
        $parentId = null,
        $content = '',
        array $options = []
    ) {
        $name   = rawurlencode($name);
        $parent = $parentId !== null ? "items/" . rawurlencode($parentId) : 'root';

        // $options = array_merge([
        //     'name_conflict_behavior' => $this->_nameConflictBehavior,
        // ], $options);

        // $params = $this
        //     ->_nameConflictBehaviorParameterizer
        //     ->parameterize([], $options['name_conflict_behavior']);

        // $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        $driveItem = $this
            ->graph
            ->createRequest('PUT', "/me/drive/$parent:/$name:/content")
            ->attachBody(is_resource($content) ? $content : Psr7\stream_for($content))
            ->setReturnType(Model\DriveItem::class)
            ->execute();

        return new File($this, $driveItem->getId(), $driveItem);
    }

    /**
     * Fetches a drive item from the current OneDrive account.
     *
     * @param null|string $driveItemId
     *        The unique ID of the OneDrive drive item to fetch, or null to
     *        fetch the OneDrive root folder. Default: null.
     *
     * @return Microsoft\Graph\Model\DriveItem
     *         The drive item fetched, as a DriveItem instance referencing to
     *         the OneDrive drive item fetched.
     */
    public function fetchDriveItem($driveItemId = null)
    {
        $driveItemId = null !== $driveItemId ? 'items/' . rawurlencode($driveItemId) : 'root';

        $driveItem = $this
            ->graph
            ->createRequest('GET', "/me/drive/$driveItemId")
            ->setReturnType(Model\DriveItem::class)
            ->execute();

        return $this->isFolder($driveItem) ?
             new Folder($this, $driveItem->getId(), $driveItem)
             : new File($this, $driveItem->getId(), $driveItem);
    }

    /**
     * Fetches the root folder from the current OneDrive account.
     *
     * @return Folder
     *         The root folder, as a Folder instance referencing to the OneDrive
     *         root folder.
     */
    public function fetchRoot()
    {
        return $this->fetchDriveItem();
    }

    /**
     * Fetches the "Camera Roll" folder from the current OneDrive account.
     *
     * @return Folder
     *         The "Camera Roll" folder, as a Folder instance referencing to the
     *         OneDrive "Camera Roll" folder.
     *
     * @todo Convert to Graph.
     */
    public function fetchCameraRoll()
    {
        return $this->fetchDriveItem('me/skydrive/camera_roll');
    }

    /**
     * Fetches the "Documents" folder from the current OneDrive account.
     *
     * @return Folder
     *         The "Documents" folder, as a Folder instance referencing to the
     *         OneDrive "Documents" folder.
     *
     * @todo Convert to Graph.
     */
    public function fetchDocs()
    {
        return $this->fetchDriveItem('me/skydrive/my_documents');
    }

    /**
     * Fetches the "Pictures" folder from the current OneDrive account.
     *
     * @return Folder
     *         The "Pictures" folder, as a Folder instance referencing to the
     *         OneDrive "Pictures" folder.
     *
     * @todo Convert to Graph.
     */
    public function fetchPics()
    {
        return $this->fetchDriveItem('me/skydrive/my_photos');
    }

    /**
     * Fetches the "Public" folder from the current OneDrive account.
     *
     * @return Folder
     *         The "Public" folder, as a Folder instance referencing to the
     *         OneDrive "Public" folder.
     *
     * @todo Convert to Graph.
     */
    public function fetchPublicDocs()
    {
        return $this->fetchDriveItem('me/skydrive/public_documents');
    }

    /**
     * Fetches the properties of a drive item in the current OneDrive account.
     *
     * @param null|string $driveItemId
     *        The drive item ID, or null to fetch the OneDrive root folder.
     *        Default: null.
     *
     * @return Microsoft\Graph\Model\DriveItem
     *         The properties of the drive item fetched.
     */
    public function fetchProperties($driveItemId = null)
    {
        $driveItemId = null !== $driveItemId ? 'items/' . rawurlencode($driveItemId) : 'root';

        return $this
            ->graph
            ->createRequest('GET', "/me/drive/$driveItemId")
            ->setReturnType(Model\DriveItem::class)
            ->execute();
    }

    /**
     * Fetches the drive items in a folder in the current OneDrive account.
     *
     * @param null|string $driveItemId
     *        The drive item ID, or null to fetch the OneDrive root folder.
     *        Default: null.
     *
     * @return array
     *         The drive items in the folder fetched, as DriveItem instances
     *         referencing OneDrive drive items.
     */
    public function _fetchDriveItems($driveItemId = null)
    {
        if (null === $driveItemId) {
            $driveItemId = 'me/skydrive';
        }

        $result     = $this->apiGet($driveItemId . '/files');
        $driveItems = [];

        foreach ($result->data as $data) {
            $driveItem = in_array($data->type, ['folder', 'album']) ?
                new Folder($this, $data->id, $data)
                : new File($this, $data->id, $data);

            $driveItems[] = $driveItem;
        }

        return $driveItems;
    }

    public function fetchDriveItems($driveItemId = null)
    {
        $driveItemId = null !== $driveItemId ? 'items/' . rawurlencode($driveItemId) : 'root';

        $driveItems = $this
            ->graph
            ->createCollectionRequest('GET', "/me/drive/$driveItemId/children")
            ->setReturnType(Model\DriveItem::class)
            ->execute();

        $self = $this;

        return array_map(function (Model\DriveItem $driveItem) use ($self) {
            return $self->isFolder($driveItem) ?
                new Folder($this, $driveItem->getId(), $driveItem)
                : new File($this, $driveItem->getId(), $driveItem);
        }, $driveItems);
    }

    /**
     * Updates the properties of a drive item in the current OneDrive account.
     *
     * @param string $driveItemId
     *        The unique ID of the drive item to update.
     * @param array|object $properties
     *        The properties to update. Default: [].
     * @param bool $temp
     *        Option to allow save to a temporary file in case of large files.
     *
     * @throws \Exception
     *         Thrown on I/O errors.
     *
     * @todo Convert to Graph.
     */
    public function updateDriveItem($driveItemId, $properties = [], $temp = false)
    {
        $properties = (object) $properties;
        $encoded    = json_encode($properties);
        $stream     = fopen('php://' . ($temp ? 'temp' : 'memory'), 'rw+b');

        if (false === $stream) {
            throw new \Exception('fopen() failed');
        }

        if (false === fwrite($stream, $encoded)) {
            throw new \Exception('fwrite() failed');
        }

        if (!rewind($stream)) {
            throw new \Exception('rewind() failed');
        }

        $this->apiPut($driveItemId, $stream, 'application/json');
    }

    /**
     * Moves a drive item into another folder.
     *
     * @param string $driveItemId
     *        The unique ID of the drive item to move.
     * @param null|string $destinationId
     *        The unique ID of the folder into which to move the drive item, or
     *        null to move it to the OneDrive root folder. Default: null.
     *
     * @todo Convert to Graph.
     */
    public function _moveDriveItem($driveItemId, $destinationId = null)
    {
        if (null === $destinationId) {
            $destinationId = 'me/skydrive';
        }

        $this->apiMove($driveItemId, [
            'destination' => $destinationId,
        ]);
    }

    public function moveDriveItem($driveItemId, $destinationId = null)
    {
        $payload = [
            'parentReference' => [
                'id' => $destinationId,
            ],
        ];

        $this
            ->graph
            ->createRequest('PATCH', "/me/drive/items/$driveItemId")
            ->attachBody($payload)
            ->setReturnType(Model\DriveItem::class)
            ->execute();
    }

    /**
     * Copies a file into another folder. OneDrive does not support copying
     * folders.
     *
     * @param string $driveItemId
     *        The unique ID of the file to copy.
     * @param null|string $destinationId
     *        The unique ID of the folder into which to copy the file, or null
     *        to copy it to the OneDrive root folder. Default: null.
     *
     * @todo Convert to Graph.
     */
    public function _copyFile($driveItemId, $destinationId = null)
    {
        if (null === $destinationId) {
            $destinationId = 'me/skydrive';
        }

        $this->apiCopy($driveItemId, [
            'destination' => $destinationId,
        ]);
    }

    public function copyFile($driveItemId, $destinationId = null)
    {
//        $destinationId = null !== $destinationId ? 'root';

        $payload = [
            'parentReference' => [
                'id' => $destinationId,
            ],
        ];

        $this
            ->graph
            ->createRequest('POST', "/me/drive/items/$driveItemId/copy")
            ->attachBody($payload)
            ->setReturnType(Model\DriveItem::class)
            ->execute();
    }

    /**
     * Deletes a drive item in the current OneDrive account.
     *
     * @param string $driveItemId
     *        The unique ID of the drive item to delete.
     */
    public function deleteDriveItem($driveItemId)
    {
        $this
            ->graph
            ->createRequest('DELETE', "/me/drive/items/$driveItemId")
            ->execute();
    }

    /**
     * Fetches the quota of the current OneDrive account.
     *
     * @return object
     *         An object with the following properties:
     *           - 'quota' (int) The total space, in bytes.
     *           - 'available' (int) The available space, in bytes.
     *
     * @todo Convert to Graph.
     */
    public function fetchQuota()
    {
        return $this->apiGet('me/skydrive/quota');
    }

    /**
     * Fetches the account info of the current OneDrive account.
     *
     * @return object
     *         An object with the following properties:
     *           - 'id' (string) OneDrive account ID.
     *           - 'first_name' (string) Account owner's first name.
     *           - 'last_name' (string) Account owner's last name.
     *           - 'name' (string) Account owner's full name.
     *           - 'gender' (string) Account owner's gender.
     *           - 'locale' (string) Account owner's locale.
     *
     * @todo Convert to Graph.
     */
    public function fetchAccountInfo()
    {
        return $this->apiGet('me');
    }

    /**
     * Fetches the recent documents uploaded to the current OneDrive account.
     *
     * @return object
     *         An object with the following properties:
     *           - 'data' (array) The list of the recent documents uploaded.
     *
     * @todo Convert to Graph.
     */
    public function fetchRecentDocs()
    {
        return $this->apiGet('me/skydrive/recent_docs');
    }

    /**
     * Fetches the drive items shared with the current OneDrive account.
     *
     * @return object
     *         An object with the following properties:
     *           - 'data' (array) The list of the shared drive items.
     *
     * @todo Convert to Graph.
     */
    public function fetchShared()
    {
        return $this->apiGet('me/skydrive/shared');
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     *        The level.
     * @param string $message
     *        The message.
     * @param array $context
     *        The context.
     */
    public function log($level, $message, array $context = [])
    {
        $this->_logger->log($level, $message, $context);
    }

    /**
     * Checks whether a given drive item is a folder.
     *
     * @param object $driveItem
     *        The drive item.
     *
     * @return bool
     *         Whether the drive item is a folder.
     */
    private function isFolder(Model\DriveItem $driveItem)
    {
        return null !== $driveItem->getFolder() || null !== $driveItem->getSpecialFolder();
    }
}
