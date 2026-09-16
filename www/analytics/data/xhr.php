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

/*
 * Never render PHP warnings/notices/stack traces to the client. Exposing them
 * leaks absolute filesystem paths, filenames and line numbers (see LRN-52744).
 * Errors are still recorded via the server error log for later analysis.
 */
ini_set('display_errors', '0');
ini_set('log_errors', '1');

include_once '../../env_config.php';
include_once '../../lrn_config.php';

use LearnositySdk\Request\DataApi;

/**
 * Send a generic JSON error to the client without disclosing internal details.
 *
 * @param string $clientMessage User-facing, non-sensitive message.
 * @param string $logMessage    Detailed message written to the server error log.
 * @param int    $statusCode    HTTP status code to return.
 */
function respond_with_error(string $clientMessage, string $logMessage, int $statusCode = 400): void
{
    error_log('[xhr.php] ' . $logMessage);
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['error' => $clientMessage]);
    exit;
}

$endpoint = filter_input(INPUT_POST, 'endpoint', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]]);

// Validate required parameters before using them. Requesting the endpoint
// without the expected parameters must not trigger PHP warnings.
if (empty($endpoint)) {
    respond_with_error('Bad request.', 'Missing required "endpoint" parameter.');
}

$parsed_endpoint = parse_url($endpoint);
if ($parsed_endpoint === false || !isset($parsed_endpoint['scheme'], $parsed_endpoint['host'])) {
    respond_with_error('Bad request.', 'Malformed "endpoint" parameter.');
}

if (strpos($endpoint, 'sessions/responses/feedback') !== false) {
    $consumer_key = $consumer_key_postgres;
    $consumer_secret = $consumer_secret_postgres;
}

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$data = json_decode(html_entity_decode(filter_input(INPUT_POST, 'request', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => null]]) ?? ''), true);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'get']]);

# Get the data API URL we are dealing with - so we can limit it to only that domain.
# This comes from the env_config.php or lrn_config.php
$data_url_parsed = parse_url($url_data);

if ($parsed_endpoint['scheme'] != $data_url_parsed['scheme']) {
    error_log("[SECURITY] Invalid scheme requested: " . $parsed_endpoint['scheme']);
    header('HTTP/1.0 403 Forbidden');
    die('Forbidden');
}
if ($parsed_endpoint['host'] != $data_url_parsed['host']) {
    error_log("[SECURITY] Invalid URL requested: " . $parsed_endpoint['host']);
    header('HTTP/1.0 403 Forbidden');
    die('Forbidden');
}

# Make request to the Data API
try {
    $dataapi = new DataApi(['ssl_verify' => $curl_ssl_verify]);
    $response = $dataapi->request($endpoint, $security, $consumer_secret, $data, $action);
} catch (\Throwable $e) {
    // Log the full detail server-side, return a generic message to the client.
    respond_with_error('An error occurred while processing the request.', 'Data API request failed: ' . $e->getMessage(), 502);
}

if (strlen($response->getBody())) {
    echo $response->getBody();
} else {
    $err = $response->getError();
    // Log the underlying error detail; return a generic message to the client.
    error_log('[xhr.php] Data API returned an error: ' . json_encode($err));
    http_response_code(502);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'An error occurred while processing the request.']);
}
