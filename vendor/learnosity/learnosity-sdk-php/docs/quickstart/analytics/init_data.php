<?php

/**
     * Copyright (c) 2021 Learnosity, MIT License
     *
     * Basic example of pulling information from the Learnosity cloud using Data API.
     */

// Setup to load the necessary classes from the example directory,
// and set up variables related to user access.
require_once __DIR__ . '/../../../bootstrap.php';
$config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php.
use LearnositySdk\Request\DataApi;
use LearnositySdk\Request\Remote;

$itembank_uri = 'https://data.learnosity.com/latest-lts/itembank/items';

// Public & private security keys required to access Learnosity APIs and
// data. These keys grant access to Learnosity's public demos account,
// loaded from a configuration file on line 11.
// Learnosity will provide keys for your own private account.
$consumerKey = $config['consumerKey'];
$security_packet = [
    'consumer_key'   => $consumerKey,
    'domain'         => 'localhost',
];
$consumer_secret = $config['consumerSecret'];

$data_api = new DataApi();

echo "Do request using manual iteration..." . PHP_EOL;

$data_request = [
    'limit' => 1,
];

// Do 5 subsequent requests using the `next` pointer
for ($request_count = 0; $request_count < 5; $request_count++) {
    echo ">>> [{$itembank_uri} ({$request_count})] " . json_encode($data_request) . PHP_EOL;

    $result = $data_api->request(
        $itembank_uri,
        $security_packet,
        $consumer_secret,
        $data_request,
        'get'
    );

    // DataApi::request() returns a Remote object
    /** @var Remote $result */
    $response = $result->json();

    echo "<<< [{$result->getStatusCode()}]" . PHP_EOL;
    var_dump($result->getBody());

    if (isset($response['meta']['next']) && isset($response['meta']['records']) && $response['meta']['records'] > 0) {
        $data_request['next'] = $response['meta']['next'];
    }
}

echo "Do request using requestRecursive and callback..." . PHP_EOL;

$data_request = [
    'limit' => 1,
];

// Define the callback that gets the returned data
$callback = function (array $data) {
    echo "Callback got:" . PHP_EOL;
    var_dump($data);
};

$data_api->requestRecursive(
    $itembank_uri,
    $security_packet,
    $consumer_secret,
    $data_request,
    'get',
    $callback,
    5           // Just do 5 iterations of 1 record
);

echo "Do request using requestRecursive and return value..." . PHP_EOL;

$data_request = [
    'limit' => 1,
];

// If you pass null for the callback parameter it'll return the final results as an array
$result = $data_api->requestRecursive(
    $itembank_uri,
    $security_packet,
    $consumer_secret,
    $data_request,
    'get',
    null,
    5           // Just do 5 iterations of 1 record
);

echo "Result of recursive request:" . PHP_EOL;
var_dump($result);
