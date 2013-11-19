<?php

include_once 'config.php';
include_once 'src/utils/RequestHelper.php';
include_once 'src/utils/uuid.php';

$security = [
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
];

$request = [
    "user_id"        => $studentid,
    "rendering_type" => "assess",
    "name"           => "Items API demo - assess activity.",
    "state"          => "initial",
    "activity_id"    => "itemsassessdemo",
    "session_id"     => UUID::generateUuid(),
    "course_id"      => $courseid,
    "items"          => ["ccore_video_260_classification", "ccore_parcc_tecr_grade3"],
    "type"           => "submit_practice",
    "config"         => [
        "subtitle"   => "Walter White",
        "navigation" => [
            "show_intro"     => true,
            "show_itemcount" => true
        ],
        "renderSaveButton"  => true,
        "ignore_validation" => false
    ]
];

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedActivity = $RequestHelper->generateRequest();

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php
        include 'src/includes/headerbottom.php';
    ?>
    <div class="jumbotron">
        <h1>Items API Assess</h1>
        <p>Or with the flick of a switch make the items into an assessment.  Truly write once - use anywhere.<p>
        <p class='text-right'><a class="btn btn-primary btn-lg" href="ssoapi.php">Continue</a></p>
    </div>

    <!-- Container for the assess app to load into -->
    <div id="learnosity_assess"></div>

    <script src="http://items.learnosity.com"></script>
    <script>
        var activity = <?php echo $signedActivity; ?>;
        LearnosityItems.init(activity);
    </script>

<?php include "src/includes/footer.php" ?>
