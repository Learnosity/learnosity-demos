<?php

include_once '../../config.php';
include_once 'includes/header.php';
include_once 'Learnosity/Sdk/Request/Init.php';
include_once 'Learnosity/Sdk/Utils/Utilities/Uuid.php';

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
    "session_id"     => Uuid::generate(),
    "course_id"      => $courseid,
    "items"          => array("Demo3", "Demo4", "Demo5", "Demo6", "Demo7", "Demo8", "Demo9", "Demo10"),
    "type"           => "submit_practice",
    "config"         => array(
        "renderSubmitButton"  => true,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log("Learnosity Items API is ready");
            }
        },
        app = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);
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
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_adaptive.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="Demo3"></span>
    <span class="learnosity-item" data-reference="Demo4"></span>
    <span class="learnosity-item" data-reference="Demo5"></span>
    <span class="learnosity-item" data-reference="Demo6"></span>
    <span class="learnosity-item" data-reference="Demo7"></span>
    <span class="learnosity-item" data-reference="Demo8"></span>
    <span class="learnosity-item" data-reference="Demo9"></span>
    <span class="learnosity-item" data-reference="Demo10"></span>
    <span class="learnosity-submit-button"></span>
</p>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
