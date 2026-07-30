<?php

/*
|--------------------------------------------------------------------------
| feedback-endpoint.php
|--------------------------------------------------------------------------
|
| Server-side proxy for the Data API session response feedback endpoint.
| Accepts a form POST with:
|   - action  : 'get' or 'update'
|   - request : JSON-encoded request body
|
| Calls /sessions/responses/feedback using postgres consumer credentials.
|
*/

header("Content-type: application/json");

include_once '../../../../env_config.php';
include_once '../../../../lrn_config.php';

use LearnositySdk\Request\DataApi;

$consumer_key    = $consumer_key_postgres;
$consumer_secret = $consumer_secret_postgres;

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'get']]);

$request_data = json_decode(
    html_entity_decode(
        filter_input(INPUT_POST, 'request', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => '{}']])
    ),
    true
) ?? [];

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
];

$endpoint = $url_data . '/sessions/responses/feedback';

$dataapi  = new DataApi(['ssl_verify' => $curl_ssl_verify]);
$response = $dataapi->request($endpoint, $security, $consumer_secret, $request_data, $action);

if (strlen($response->getBody())) {
    echo $response->getBody();
} else {
    $err = $response->getError();
    http_response_code(500);
    echo json_encode(['error' => $err]);
}
