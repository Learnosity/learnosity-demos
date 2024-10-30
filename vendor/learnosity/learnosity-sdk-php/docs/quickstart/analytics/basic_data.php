<?php

/* Copyright (c) 2023 Learnosity, MIT License
 * Basic example code for pulling information from the Learnosity cloud using Data API. */

// Setup to load the necessary classes from the example directory, & set up variables for access.
require_once __DIR__ . '/../../../bootstrap.php';
$config = require_once __DIR__ . '/../config.php'; // Load security keys from config.php, for Learnosity's public demos account.
use LearnositySdk\Request\DataApi; // Load core Data API library.
$itembank_uri = 'https://data.learnosity.com/v2023.1.LTS/sessions/responses'; // Choosing the Data API endpoint for sessions/responses.

// Learnosity will provide keys for your own private account.
$consumerKey = $config['consumerKey']; // Selecting the Learnosity account (consumer key).
$security_packet = [
    'consumer_key'   => $consumerKey, // Selecting the Learnosity account (consumer key).
    'domain'         => 'localhost',  // Selecting the domain where your app will be resident ('localhost' is for testing local code)
];
$consumer_secret = $config['consumerSecret']; // Providing the password for the Learnosity account being used from configuration file.

$data_api = new DataApi(); // Essential step of initializing the API

// Request setup block. Creates a variable holding the Data API request options as JSON.
$data_request = [
    'user_id' => ['student_0001'],
    'mintime' => '2020-01-01',
    'maxtime' => '2020-12-31',
    'limit' => 1
];
// Result setup block. Compiles all of the security configuration and request options together, then calls Data API to get the data.
$result = $data_api->request(
    $itembank_uri,
    $security_packet,
    $consumer_secret,
    $data_request,
    'get'
);
// Printout block. Printing the output into the browser window.
$response = $result->json(); // Convert the request data to JSON format
echo "<<< [{$result->getStatusCode()}]" . PHP_EOL; // Get the HTTP status code that the request returned, and add it to the data.
print_r($result->getBody()); // Print the returned data into the browser window.
