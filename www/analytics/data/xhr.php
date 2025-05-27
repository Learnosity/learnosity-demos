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

$endpoint = filter_input(INPUT_POST, 'endpoint', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]]);
$resource = filter_input(INPUT_POST, 'resource', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]]);

if (strpos($endpoint, 'sessions/responses/feedback')!==false){
    $consumer_key = $consumer_key_postgres;
    $consumer_secret = $consumer_secret_postgres;
}

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$data = json_decode(html_entity_decode(filter_input(INPUT_POST, 'request', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]])), true);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'get']]);

if ($resource === 'responsesfeedbackupdate') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'update']]);
}
# Get the data API URL we are dealing with - so we can limit it to only that domain.
# This comes from the env_config.php or lrn_config.php
$data_url_parsed = parse_url($url_data);
$parsed_endpoint = parse_url($endpoint);

if($parsed_endpoint['scheme'] != $data_url_parsed['scheme']){
    header('HTTP/1.0 403 Forbidden');
    error_log("[SECURITY] Invalid scheme requested: " . $parsed_endpoint['scheme'] , );
    die('Forbidden');
}
if($parsed_endpoint['host'] !=  $data_url_parsed['host']){
    error_log("[SECURITY] Invalid URL requested: " . $parsed_endpoint['host']);
    header('HTTP/1.0 403 Forbidden');
    die('Forbidden');
}

# Make request to the Data API
$dataapi = new DataApi(['ssl_verify' => $curl_ssl_verify]);
$response = $dataapi->request($endpoint, $security, $consumer_secret, $data, $action);

if (strlen($response->getBody())) {
    echo $response->getBody();
} else {
    $err = $response->getError();
    echo $err['message'];
}
