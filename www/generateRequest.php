<?php

/*
|--------------------------------------------------------------------------
| generateRequest.php
|--------------------------------------------------------------------------
|
| Use this script to generate a new signature and initialisation
| packet for a Learnosity service, or to generate the new signature
| but return an HTML packet from an initialised service.
|
| Main use case right now is to sign an 'items' packet from the Author
| API for previewing.
|
*/

include_once 'config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain
);

$service = null;
$sign_type = (isset($_POST['sign_type'])) ? $_POST['sign_type'] : null;
$show_modal = false;

switch ($sign_type) {
    case 'items-inline':
        $service = 'items';
        $content = $_POST['content'];
        $show_modal = true;
        $request = array(
            'user_id'        => $studentid,
            'rendering_type' => 'inline',
            'name'           => 'Items API demo - Inline Activity.',
            'state'          => 'initial',
            'activity_id'    => 'itemsinlinedemo',
            'session_id'     => Uuid::generate(),
            'course_id'      => $courseid,
            'items'          => $_POST['item_references'],
            'type'           => 'submit_practice',
            'config'         => array(
                'renderSubmitButton' => false,
                'questionsApiVersion' => 'v2'
            )
        );
        break;
    default:
        // No default
        break;
}

if (!is_null($service)) {
    $Init = new Init($service, $security, $consumer_secret, $request);
    $output = $Init->generate();
    if ($show_modal) {
        include_once 'views/modals/' . $sign_type . '.php';
    } else {
        echo $output;
    }
}
