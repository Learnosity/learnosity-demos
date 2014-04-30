<?php

include_once '../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'activity_template_id' => 'demo-activity-1',
    'rendering_type'       => 'assess',
    'type'                 => 'local_practice',
    'course_id'            => $courseid,
    'session_id'           => UUID::generateUuid(),
    'user_id'              => $studentid
);

include_once 'utils/settings-override.php';

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
    <h1>Items API – Activities</h1>
    <p>Preview the <a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">API Initialisation Object</a> to see how simple it can be using the Items API to load activities
    authored in the Learnosity item bank.<p>
    <p><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">Customise the activity</a> you want to load.<p>
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
    var activity = <?php echo $signedRequest; ?>;
    var eventOptions = {
        readyListener: function () {
            console.log("Learnosity Items API is ready");
        }
    };
    var app = LearnosityItems.init(activity, eventOptions);
</script>

<?php
    include_once 'views/modals/settings-items-activities.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
