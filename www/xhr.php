<?php

/*
|--------------------------------------------------------------------------
| xhr.php
|--------------------------------------------------------------------------
|
| Use this script to generate a new signature and initialisation
| packet for a Learnosity service.
|
| Main use case right now is to sign an 'items' packet from the Author
| API for previewing.
|
*/

include_once 'config.php';
include_once '../src/utils/RequestHelper.php';
include_once '../src/utils/uuid.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
);

$service = null;
$sign_type = (isset($_POST['sign_type'])) ? $_POST['sign_type'] : null;
$show_modal = false;

switch ($sign_type) {
    case 'itemsinline':
        $service = 'items';
        $show_modal = true;
        $request = [
            "user_id"        => $studentid,
            "rendering_type" => "inline",
            "name"           => "Items API demo - Inline Activity.",
            "state"          => "initial",
            "activity_id"    => "itemsinlinedemo",
            "session_id"     => UUID::generateUuid(),
            "course_id"      => $courseid,
            "items"          => $_POST['item_references'],
            "type"           => "submit_practice",
            "config"         => [
                "renderSubmitButton" => false
            ]
        ];
        break;
    default:
        // No default
        break;
}

if (!is_null($service)) {
    $RequestHelper = new RequestHelper(
        $service,
        $security,
        $consumer_secret,
        $request
    );
    $output = $RequestHelper->generateRequest();
    if ($show_modal) {
        include_once '../src/views/modals/' . $sign_type . '.php';
    } else {
        echo $output;
    }
}
