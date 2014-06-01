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

use LearnositySdk\Request\Init;
use LearnositySdk\Request\Remote;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];
$endpoint = (isset($_POST['endpoint'])) ? $_POST['endpoint'] : null;
$data     = (isset($_POST['request'])) ? $_POST['request'] : null;

$Init = new Init('data', $security, $consumer_secret, $data);
$signedRequest = $Init->generate();

$Remote = new Remote();
$response = $Remote->post($endpoint, $signedRequest);

echo $response->getBody();
