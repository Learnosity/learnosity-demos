<?php

include_once '../../config.php';
include_once 'includes/header.php';
include_once 'Learnosity/Sdk/Request/Init.php';
include_once 'Learnosity/Sdk/Utils/Utilities/Uuid.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_template_id' => 'demo-activity-1',
    'activity_id'          => 'demo-activity-1',
    'name'                 => 'Demo Activity',
    'course_id'            => $courseid,
    'session_id'           => Uuid::generateUuid(),
    'user_id'              => $studentid
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron">
    <h1>Items API – Activities</h1>
    <p>Activities are a wrapper for multiple items authored in the Learnosity Author site. They can also
    include configuration used by the <a href="<?php echo $env['www'] ?>assessment/assess/index.php">Assess API</a> to control the assessment user interface.</p>
    <p>Preview the <a href="#" data-toggle="modal" data-target="#initialisation-preview">API Initialisation Object</a> to see how simple it can be using the Items API to load activities
    authored in the Learnosity item bank.<p>
    <p><a href="#" data-toggle="modal" data-target="#settings">Customise the activity</a> you want to load.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                <span class="glyphicon glyphicon-list-alt"></span> Customise API Settings
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_workedsolutions.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="//items.learnosity.com"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log("Learnosity Items API is ready");
            }
        },
        app = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);
</script>

<?php
    include_once 'views/modals/settings-items-activities.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
