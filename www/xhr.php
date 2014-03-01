<?php

/*
|--------------------------------------------------------------------------
| xhr.php
|--------------------------------------------------------------------------
|
| This script is a proxy to perform a cross-domain XHR request. It
| expects a form POST with 2 parameters:
|   - endpoint (full URL to POST to)
|   - request (body of form POST)
|
*/

include_once 'config.php';
include_once 'utils/RequestHelper.php';

$security = [
    'consumer_key'    => $consumer_key,
    'domain'          => $domain,
    'timestamp'       => $timestamp
];
$endpoint = (isset($_POST['endpoint'])) ? $_POST['endpoint'] : null;
$data     = (isset($_POST['request'])) ? $_POST['request'] : null;

$RequestHelper = new RequestHelper(
    'data',
    $security,
    $consumer_secret,
    $data
);

$signedRequest = $RequestHelper->generateRequest();
var_dump($signedRequest);
$response = $RequestHelper->sendXHR($endpoint, $signedRequest);

echo $response;
