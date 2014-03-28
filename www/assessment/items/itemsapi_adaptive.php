<?php

include_once '../../config.php';
include_once '../../../src/utils/uuid.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'activity_id'    => 'itemadaptivedemo',
    'name'           => 'Items API demo - adaptive activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'course_id'      => $courseid,
    'session_id'     => UUID::generateUuid(),
    'user_id'        => $studentid,
    'adaptive'       => array(
        'type'                      => 'itemadaptive',
        'initial_ability'           => 0,
        'item_difficulty_tolerance' => 1,
        'max_difficulty_change'     => 0.7,
        'termination_criteria'      => array(
            'max_items' => 5
        ),
        'required_tags' => array(
            array('type' => 'course', 'name' => 'commoncore'),
            array('type' => 'subject', 'name' => 'Maths')
        )
    ),
    'config'         => array(
        'subtitle'   => 'Walter White',
        'navigation' => array(),
        'time' => array(),
        'assessApiVersion' => 'v2',
        'questionsApiVersion' => 'v2',
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_adaptive.php',
            'onsave_redirect_url'   => 'itemsapi_adaptive.php',

        )
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

<div class="jumbotron">
    <h1>Items API – Adaptive</h1>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_inline.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="http://items.staging.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
