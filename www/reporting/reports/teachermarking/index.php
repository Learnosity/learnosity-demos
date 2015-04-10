<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$sessionid = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'constructedresponse-demo',
    'state'          => 'initial',
    'activity_id'    => 'constructedresponse-demo',
    'session_id'     => $sessionid,
    'course_id'      => $courseid,
    'items'          => array('Demo-ConstructedResponse'),
    'type'           => 'submit_practice',
    'config'         => array(
        'renderSubmitButton'  => false,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Constructed Response</h1>
        <p>This is a sample constructed response question a student might attempt in an assessment.</p>
        <p>On submission, the page will redirect to an example of where a teacher can enter a grade and feedback.</p>
    </div>
</div>

<div class="section">
    <h3>Constructed Response</h3>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <!-- Container for the item to load into -->
            <span class="learnosity-item" data-reference="Demo-ConstructedResponse"></span>
            <button id="lrn-submit">Submit</button>
        </div>
    </div>
</div>
<script src="//items.learnosity.com"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);

    var submitSettings = {
        success: function (response_ids) {
            location.href = './marking.php?session=<?php echo $sessionid; ?>';
        },
        error: function (e) {
            // Receives the event object defined in the Event section
            console.log("submit has failed",e);
        }
    };

    document.getElementById('lrn-submit').onclick = function () {
        itemsApp.submit(submitSettings);
    };
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
