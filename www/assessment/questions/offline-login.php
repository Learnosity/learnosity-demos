<?php
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../../config.php';

$user_id = $_POST['userid'];
$domain = $_POST['domain'];

$timestamp = gmdate('Ymd-Hi');
$signature = hash('sha256', $consumer_key . '_' . $domain . '_' . $timestamp . '_' . $user_id . '_' . $consumer_secret);


$security = [
    'timestamp'     => $timestamp,
    'domain'        => $domain,
    'consumer_key'  => $consumer_key,
    'user_id'       => $user_id,
    'signature'     => $signature
];

echo json_encode($security);
