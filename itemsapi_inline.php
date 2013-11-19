<?php

include_once 'src/includes/headertop.php';
include_once 'config.php';
include_once 'src/utils/RequestHelper.php';
include_once 'src/utils/signature.php';
include_once "src/utils/uuid.php";

$security = [
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp
];

$request = [
    "user_id"        => $studentid,
    "rendering_type" => "inline",
    "name"           => "Items API demo - Inline Activity.",
    "state"          => "initial",
    "activity_id"    => "itemsinlinedemo",
    "session_id"     => UUID::generateUuid(),
    "course_id"      => $courseid,
    "items"          => ["ccore_video_260_classification", "ccore_parcc_tecr_grade3"],
    "type"           => "submit_practice",
    "config"         => [
        "renderSubmitButton" => true
    ]
];

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedActivity = $RequestHelper->generateRequest();

?>

<script src="http://items.learnosity.com/"></script>
<script>
    var activity = <?php echo $signedActivity; ?>;
    LearnosityItems.init(activity);
</script>

<?php include "src/includes/headerbottom.php" ?>

<div class="jumbotron">
    <h1>Items API</h1>
    <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
    <div class="row">
        <div class="col-md-8"> <p>See it below.</p></div>
        <div class="col-md-4"> <p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_assess.php">Continue</a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="ccore_video_260_classification"></span>
    <span class="learnosity-item" data-reference="ccore_parcc_tecr_grade3"></span></p>
    <span class="learnosity-submit-button"></span>
</p>

<?php include "src/includes/footer.php" ?>
