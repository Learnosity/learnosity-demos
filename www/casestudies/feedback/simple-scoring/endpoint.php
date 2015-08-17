<?php
header("Content-type: application/json");

//external config for key/secret etc.
include_once '../../../config.php';

//use SDK
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//domain must be whitelisted
$domain = $_POST['domain'];

//security object, with domain taking from requester
$security = [
    'user_id'      => $_POST['request']['user_id'],
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

//initialize Items API with provided request object
$init = new Init('items', $security, $consumer_secret, $_POST['request']);
echo $init->generate();
?>
