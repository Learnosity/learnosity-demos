<?php

// Setup to load the necessary classes from the example directory
require_once(__DIR__ . '/../../bootstrap.php');

use LearnositySdk\Request\DataApi;
use LearnositySdk\Request\Remote;

$security_packet = [
    'consumer_key'   => 'yis0TYCu7U9V4o7M',
    'domain'         => 'localhost',
];

# XXX: The consumer secret should be in a properly secured credential store, and *NEVER* checked in in revision control
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
$data_request = [ 'limit' => 1 ];

$DataApi = new DataApi();

# Do 5 subsequent requests using the `next` pointer
for ($reqno=0; $reqno<5; $reqno++) {
    $itembankUri = 'https://data.learnosity.com/v1/itembank/items';
    print(">>> [{$itembankUri} ({$reqno})] " . json_encode($data_request) . PHP_EOL);

    $res = $DataApi->request(
        $itembankUri,
        $security_packet,
        $consumer_secret,
        $data_request,
        'get'
    );

    // DataApi::request() returns a Remote object
    print("<<< [{$res->getStatusCode()}] {$res->getBody()}" . PHP_EOL);
    $response = $res->json();
    if (isset($response['meta']['next'])
        && isset($response['meta']['records'])
        && $response['meta']['records'] > 0
    ) {
        $data_request['next'] = $response['meta']['next'];
    }
}
