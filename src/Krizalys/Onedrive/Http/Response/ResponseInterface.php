<?php

namespace Krizalys\Onedrive\Http\Response;

interface ResponseInterface
{
    function getStatusCode();
    function getStatusReason();
    function getHeaders();
    function getBody();
}
