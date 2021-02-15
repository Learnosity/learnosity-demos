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
include_once '../../env_config.php';
include_once '../../lrn_config.php';

use LearnositySdk\Request\DataApi;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);
$endpoint = filter_input(INPUT_POST, 'endpoint', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]]);
$data = json_decode(html_entity_decode(filter_input(INPUT_POST, 'request', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]])), true);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'get']]);

$dataapi = new DataApi(['ssl_verify' => $curl_ssl_verify]);
$response = $dataapi->request($endpoint, $security, $consumer_secret, $data, $action);

if (strlen($response->getBody())) {
    echo $response->getBody();
} else {
    $err = $response->getError();
    echo $err['message'];
}
