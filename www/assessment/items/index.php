<?php

include_once '../../config.php';
include_once '../../../src/utils/uuid.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
);

$request = array(
    "user_id"        => $studentid,
    "rendering_type" => "assess",
    "name"           => "Items API demo - assess activity.",
    "state"          => "initial",
    "activity_id"    => "itemsassessdemo",
    "session_id"     => UUID::generateUuid(),
    "course_id"      => $courseid,
    "items"          => array("ccore_video_260_classification", "ccore_parcc_tecr_grade3"),
    "type"           => "submit_practice",
    "config"         => array(
        "subtitle"   => "Walter White",
        "navigation" => array(
            "show_intro"     => true,
            "show_itemcount" => true,
            "scroll_to_top"  => false,
            "scroll_to_test" => false
        ),
        "time" => array(
            "max_time"     => 1500,
            "limit_type"   => "soft",
            "show_pause"   => true,
            "warning_time" => 60,
            "show_time"    => true
        ),
        "renderSaveButton"  => true,
        "ignore_validation" => false
    )
);

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedActivity = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
    <h1>Items API</h1>
    <p>
        Learnosity's <b>Items API</b> provides a simple way to access content from the Learnosity item bank to pull in activities and assessments from the author site’s data store that can be embedded in your pages. It leverages the <a href="../questions">Questions API</a> and the <a href="../assess/">Assess API</a> as appropriate.</p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="../assess">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Items API Demos</h2>
            <p>Try one of the Demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Items API - Assess</h2>
                </div>
                <div class="panel-body">
                    <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="itemsapi_assess.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Items API - Inline</h2>
                </div>
                <div class="panel-body">
                    <p>Display items from the Learnosity Item Bank in no time with the Items API. The Items API builds on the Questions API's power and makes it quicker to integrate.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="itemsapi_inline.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once '../../../src/includes/footer.php';
