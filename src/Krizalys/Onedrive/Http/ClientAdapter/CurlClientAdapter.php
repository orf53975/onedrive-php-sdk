<?php

namespace Krizalys\Onedrive\Http\ClientAdapter;

use Krizalys\Onedrive\Http\Exception;
use Krizalys\Onedrive\Http\Request\RequestInterface;
use Krizalys\Onedrive\Http\Resource\ResourceFactory;
use Krizalys\Onedrive\Http\Resource\ResourceInterface;
use Krizalys\Onedrive\Http\Response\ResponseBuilder;

interface CurlOptionFactoryInterface
{
    /**
     * @param RequestInterface $request
     *        The request.
     *
     * @return array
     *         The curl options.
     */
    function create(RequestInterface $request);
}

class CurlOptionFactory implements CurlOptionFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(RequestInterface $request)
    {
        return array();
    }
}

class HeaderCurlOptionFactory implements CurlOptionFactoryInterface
{
    public function __construct(CurlOptionFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(RequestInterface $request)
    {
        $options = $this->factory->create($request);
        $headers = $request->getHeaders();

        $headers = array_map(function ($header) {
            /** @todo Header class and stringify. */
            return $header;
        }, $headers);

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        return $options;
    }
}

/**
 * @class CurlClientAdapter
 */
class CurlClientAdapter implements ClientAdapterInterface
{
    /**
     * @var CurlOptionFactoryInterface
     *      The header curl option factory.
     */
    private $headerCurlOptionFactory;

    /**
     * @var ResourceFactory
     *      The resource factory.
     */
    private $resourceFactory;

    /**
     * @var array $options
     *      The curl options.
     */
    private $options;

    /**
     * @var bool
     *      Verify SSL hosts and peers.
     */
    private $__sslVerify;

    /**
     * @var null|string
     *      Override SSL CA path for verification (only relevant when
     *      verifying).
     */
    private $__sslCaPath;

    /**
     * @param array $options
     *        The curl options.
     */
    public function __construct(array $options = array())
    {
        $curlOptionFactory             = new CurlOptionFactory();                         /** @todo DI. */
        $this->headerCurlOptionFactory = new HeaderCurlOptionFactory($curlOptionFactory); /** @todo DI. */
        $this->resourceFactory         = new ResourceFactory();                           /** @todo DI. */

        $defaultOptions = array(
            // General options.
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, /** @todo Pass it from caller. */
            CURLOPT_AUTOREFERER    => true, /** @todo Pass it from caller. */

            /** @todo SSL_VERIFYHOST support. */ /** @todo Pass it from caller. */
            /** @todo SSL_VERIFYPEER support. */ /** @todo Pass it from caller. */
            /** @todo CAINFO support. */ /** @todo Pass it from caller. */
        );

        $this->options = $options + $defaultOptions;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function send($host, RequestInterface $request)
    {
        $curl = curl_init();

        if (false === $curl) {
            $error   = curl_error($curl);
            $message = sprintf('curl_init() failed with error: "%s"', $error);
            throw new Exception($message);
        }

        $path = $request->getPath();
        $url  = sprintf('https://%s%s', $host, $path); /** @todo Do not force HTTPS. */

        if (false === $url) {
            $error   = error_get_last();
            $message = sprintf('sprintf() failed with error: "%s"', $error['message']);
            throw new Exception($message);
        }

        /** @todo Use decorator pattern to aggregate options from request, eg:
          - MethodDecorator adds CURLOPT_POST, CURLOPT_PUT, etc...
          - HeaderDecorator adds CURLOPT_HTTPHEADER
          - etc... */
        $defaultOptions = $this->optionsFactory($request);

        $options = $this->headerCurlOptionFactory->create($request) + array(
            CURLOPT_URL => $url,
        );

        $options = $options + $defaultOptions + $this->options;
        $keys = array_keys($options);
        $values = array_values($options);
        $keys = array_map(array($this, 'nameCurlOption'), $keys);
        //var_dump(array_combine($keys, $values));

        if (true !== curl_setopt_array($curl, $options)) {
            $message = sprintf('curl_setopt_array() failed with error: "%s"', curl_error($curl));
            throw new Exception($message);
        }

        $result = curl_exec($curl);

        if (false === $result) {
            $message = sprintf('curl_exec() failed with error: "%s"', curl_error($curl));
            throw new Exception($message);
        }

        $info = curl_getinfo($curl);

        if (false === $info) {
            $message = sprintf('curl_getinfo() failed with error: "%s"', curl_error($curl));
            throw new Exception($message);
        }

        $statusCode = array_key_exists('http_code', $info) ?
            (int) $info['http_code'] : 0;

        $contentType = array_key_exists('content_type', $info) ?
            $info['content_type'] : null;

        $body    = $this->resourceFactory->create($result, $contentType);
        $builder = new ResponseBuilder(); /** @todo Director. */

        $response = $builder
            ->setStatusCode($statusCode) /** @todo Get status reason. */
            ->setBody($body)
            ->build();

        //var_dump($response);

        return $response;
    }

    private function nameCurlOption($value)
    {
        switch ($value) {
            case CURLOPT_AUTOREFERER:
                return 'CURLOPT_AUTOREFERER';

            case CURLOPT_CUSTOMREQUEST:
                return 'CURLOPT_CUSTOMREQUEST';

            case CURLOPT_FOLLOWLOCATION:
                return 'CURLOPT_FOLLOWLOCATION';

            case CURLOPT_HEADER:
                return 'CURLOPT_HEADER';

            case CURLOPT_HTTPHEADER:
                return 'CURLOPT_HTTPHEADER';

            case CURLOPT_INFILE:
                return 'CURLOPT_INFILE';

            case CURLOPT_INFILESIZE:
                return 'CURLOPT_INFILESIZE';

            case CURLOPT_POST:
                return 'CURLOPT_POST';

            case CURLOPT_POSTFIELDS:
                return 'CURLOPT_POSTFIELDS';

            case CURLOPT_PUT:
                return 'CURLOPT_PUT';

            case CURLOPT_RETURNTRANSFER:
                return 'CURLOPT_RETURNTRANSFER';

            case CURLOPT_URL:
                return 'CURLOPT_URL';

            case CURLOPT_VERBOSE:
                return 'CURLOPT_VERBOSE';

            default:
                return (string) $value;
        }
    }

    private function optionsFactory(RequestInterface $request)
    {
        $method = $request->getMethod();

        switch ($method) {
            case 'GET':
                return array();

            case 'POST':
                return $this->buildPostOptions($request->getBody());

            case 'PUT':
                return $this->buildPutOptions($request->getBody());

            default:
                $options = array(
                    CURLOPT_CUSTOMREQUEST => $method,
                );

                $body = $request->getBody();

                if ($body !== null) {
                    $content  = $body->getContent();
                    $contents = stream_get_contents($content);
                    $options[CURLOPT_POSTFIELDS] = $contents;
                }

                return $options;
        }
    }

    private function buildPostOptions(ResourceInterface $resource)
    {
        $content = $resource->getContent();

        /** @todo This also adds Content-Length and Content-Type: application/x-www-form-urlencoded */
        return array(
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => stream_get_contents($content),
        );
    }

    private function buildPutOptions(ResourceInterface $resource)
    {
        $content = $resource->getContent();
        $stats   = fstat($content);

        return array(
            CURLOPT_PUT        => true,
            CURLOPT_INFILE     => $content,
            CURLOPT_INFILESIZE => $stats[7], // 7 => file size.
        );
    }

    /**
     * {@inheritdoc}
     */
    /*public function get($url, $options = array())
    {
        $curl = self::createCurl($options);
        curl_setopt($curl, CURLOPT_URL, $url);
        return $this->_processResult($curl);
    }*/

    /**
     * {@inheritdoc}
     */
    public function __post($url, $data)
    {
        $data = (object) $data; /** @todo Data implement an HttpBody interface or so. */
        $curl = self::createCurl();

        curl_setopt_array($curl, array(
            CURLOPT_URL        => $url,
            CURLOPT_POST       => true,

            CURLOPT_HTTPHEADER => array(
                // The data is sent as JSON as per OneDrive documentation.
                'Content-Type: application/json', /** @todo This should be determined from HttpBody object, or passed to the function. */

                'Authorization: Bearer ' . $this->_state->token->data->access_token, /** @todo This should be passed to the function as custom header. */
            ),

            CURLOPT_POSTFIELDS => json_encode($data), /** @todo This should be determined from HttpBody or content-type. */
        ));

        return $this->_processResult($curl);
    }

    /**
     * {@inheritdoc}
     *
     * @todo $stream should implement an HttpBody interface or so.
     */
    public function __put($url, $stream, $contentType = null)
    {
        $curl  = self::createCurl();
        $stats = fstat($stream);

        $headers = array(
            'Authorization: Bearer ' . $this->_state->token->data->access_token, /** @todo This should be passed to the function as custom header. */
        );

        if (null !== $contentType) {
            $headers[] = 'Content-Type: ' . $contentType; /** @todo This should be determined from HttpBody. */
        }

        $options = array(
            CURLOPT_URL        => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_PUT        => true,
            CURLOPT_INFILE     => $stream,
            CURLOPT_INFILESIZE => $stats[7], // 7 => file size.
        );

        curl_setopt_array($curl, $options);
        return $this->_processResult($curl);
    }

    /**
     * {@inheritdoc}
     */
    public function __delete($url)
    {
        $curl = self::createCurl();

        curl_setopt_array($curl, array(
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ));

        return $this->_processResult($curl);
    }

    /**
     * Performs a call to the OneDrive API using the MOVE method.
     *
     * @param string       $path
     *        The path of the API call (eg. me/skydrive).
     * @param array|object $data
     *        The data to pass in the body of the request.
     *
     * @return object|string
     *         The response body, if any.
     *
     * @todo COPY is not a standard HTTP method; merge with a 'request()' method
     *       allowing the caller to pass a custom method.
     */
    public function __move($path, $data)
    {
        $url  = self::API_URL . $path;
        $data = (object) $data;
        $curl = self::createCurl();

        curl_setopt_array($curl, array(
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => 'MOVE',

            CURLOPT_HTTPHEADER    => array(
                // The data is sent as JSON as per OneDrive documentation.
                'Content-Type: application/json',

                'Authorization: Bearer ' . $this->_state->token->data->access_token,
            ),

            CURLOPT_POSTFIELDS    => json_encode($data),
        ));

        return $this->_processResult($curl);
    }

    /**
     * Performs a call to the OneDrive API using the COPY method.
     *
     * @param string       $path
     *        The path of the API call (eg. me/skydrive).
     * @param array|object $data
     *        The data to pass in the body of the request.
     *
     * @return object|string
     *         The response body, if any.
     *
     * @todo COPY is not a standard HTTP method; merge with a 'request()' method
     *       allowing the caller to pass a custom method.
     */
    public function __copy($path, $data)
    {
        $url  = self::API_URL . $path;
        $data = (object) $data;
        $curl = self::createCurl();

        curl_setopt_array($curl, array(
            CURLOPT_URL           => $url,
            CURLOPT_CUSTOMREQUEST => 'COPY',

            CURLOPT_HTTPHEADER    => array(
                // The data is sent as JSON as per OneDrive documentation.
                'Content-Type: application/json',

                'Authorization: Bearer ' . $this->_state->token->data->access_token,
            ),

            CURLOPT_POSTFIELDS    => json_encode($data),
        ));

        return $this->_processResult($curl);
    }

    /**
     * Creates a base curl object which is compatible with the OneDrive API.
     *
     * @param array $options
     *        Extra curl options to apply.
     *
     * @return resource
     *         A compatible curl object.
     */
    private function __createCurl($options = array())
    {
        $curl = curl_init();

        $defaultOptions = array(
            // General options.
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER    => true,

            // SSL options.
            // The value 2 checks the existence of a common name and also
            // verifies that it matches the hostname provided.
            CURLOPT_SSL_VERIFYHOST => $this->sslVerify ? 2 : false,

            CURLOPT_SSL_VERIFYPEER => $this->sslVerify,
        );

        if ($this->sslVerify && null !== $this->sslCaPath) {
            $defaultOptions[CURLOPT_CAINFO] = $this->sslCaPath;
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
     * @param resource $curl The cURL object used to perform the call.
     *
     * @return object|string The content returned, as an object instance if
     *                       served a JSON, or as a string if served as anything
     *                       else.
     *
     * @throws \Exception Thrown if curl_exec() fails.
     */
    private function ___processResult($curl)
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
            return (object) array();
        }

        $decoded = json_decode($result);
        $vars    = get_object_vars($decoded);

        if (array_key_exists('error', $vars)) {
            throw new \Exception($decoded->error->message,
                (int) $decoded->error->code);
        }

        return $decoded;
    }
}
