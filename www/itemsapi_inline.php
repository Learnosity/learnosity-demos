<?php

include_once 'config.php';
include_once '../src/utils/uuid.php';
include_once '../src/utils/RequestHelper.php';
include_once '../src/includes/header.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
);

$request = array(
    "user_id"        => $studentid,
    "rendering_type" => "inline",
    "name"           => "Items API demo - Inline Activity.",
    "state"          => "initial",
    "activity_id"    => "itemsinlinedemo",
    "session_id"     => UUID::generateUuid(),
    "course_id"      => $courseid,
    "items"          => array("ccore_video_260_classification", "ccore_parcc_tecr_grade3"),
    "type"           => "submit_practice",
    "config"         => array(
        "renderSubmitButton" => true
    )
);

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<!-- Container for the items api to load into -->
<script src="http://items.learnosity.com/"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<div class="jumbotron">
    <h1>Items API – Inline</h1>
    <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="assessapi.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="ccore_video_260_classification"></span>
    <span class="learnosity-item" data-reference="ccore_parcc_tecr_grade3"></span></p>
    <span class="learnosity-submit-button"></span>
</p>

<?php
    include_once '../src/views/modals/initialisation-preview.php';
    include_once '../src/includes/footer.php';
