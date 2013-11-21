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
    <h1>Items API – Assess</h1>
    <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.<p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_inline.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="http://items.learnosity.com"></script>
<script>
    var activity = <?php echo $signedActivity; ?>;
    LearnosityItems.init(activity);
</script>

<?php include_once '../src/includes/footer.php';
