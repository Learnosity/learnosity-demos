<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'course_id'      => $courseid,
    'items'          => array('Demo3', 'Demo4', 'Demo5', 'Demo6', 'Demo7', 'Demo8', 'Demo9', 'Demo10'),
    'type'           => 'submit_practice',
    'config'         => array(
        'renderSubmitButton'  => true,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Next demo"><a href="itemsapi_adaptive.php"><span class="glyphicon glyphicon-circle-arrow-right"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Inline</h1>
    <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
</div>

<div class="section">
    <br>
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
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
            }
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
