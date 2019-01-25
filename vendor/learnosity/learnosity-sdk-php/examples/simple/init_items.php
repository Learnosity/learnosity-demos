<?php

// Setup to load the necessary classes from the example directory
require_once(__DIR__ . '/../../bootstrap.php');

use LearnositySdk\Request\Init;

$security_packet = [
    'consumer_key'   => 'yis0TYCu7U9V4o7M',
    'domain'         => 'localhost',
    'timestamp'     => '20170727-2107',
];

# XXX: The consumer secret should be in a properly secured credential store, and *NEVER* checked in in revision control
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';
$items_request = json_decode(
    ' {
        "mode": "item_list",
        "config": {
            "item_list": {
                "item": {
                    "status": true
                }
            }
        },
        "user": {
            "id": "walterwhite",
            "firstname": "walter",
            "lastname": "white"
        }
    }',
    true
);

$init = new Init(
    'items',
    $security_packet,
    $consumer_secret,
    $items_request
);

print($init->generate());
