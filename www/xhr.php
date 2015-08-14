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

use LearnositySdk\Request\DataApi;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);
$endpoint = (isset($_POST['endpoint'])) ? $_POST['endpoint'] : null;
$data     = (isset($_POST['request'])) ? json_decode($_POST['request'], true) : null;
$action   = (isset($_POST['action'])) ? $_POST['action'] : 'get';

$dataapi = new DataApi(['ssl_verify' => $curl_ssl_verify]);
$response = $dataapi->request($endpoint, $security, $consumer_secret, $data, $action);

if (strlen($response->getBody())) {
    echo $response->getBody();
} else {
    $err = $response->getError();
    echo $err['message'];
}
