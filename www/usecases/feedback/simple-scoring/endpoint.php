<?php

header("Content-type: application/json");

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;

$filters = [
    "domain" => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
    ],
    "request" => [
        "filter" => FILTER_UNSAFE_RAW,
        "flags" => FILTER_REQUIRE_ARRAY | FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP
    ]

];
$post_data = filter_input_array(INPUT_POST, $filters);

//domain must be whitelisted
$domain = $post_data['domain'];

//security object, with domain taking from requester
$security = [
    'user_id'      => $post_data['request']['user_id'],
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

//initialize Items API with provided request object
$init = new Init('items', $security, $consumer_secret, $post_data['request']);
echo $init->generate();
