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
        'item_difficulty_tolerance' => 0.1,
        'item_difficulty_offset' => 0,
        'eap' => array(
            'mean'               => 0,
            'standard_deviation' => 1,
            'theta_min'          => -4,
            'theta_max'          => 4,
            'num_points'         => 50
        ),
        'termination_criteria' => array(
            'min_items' => 5,
            'max_items' => 50,
            'error_below' => 0.7
        ),
        'required_tags' => array(
            array('type' => 'adaptive-lifecycle', 'name' => 'operational')
        )
    ),
    'config' => array(
        'title' => 'Adaptive Assessment',
        'navigation' => array(
            'intro_item'             => 'adaptive-intro',
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false
        ),
        'time' => array(),
        'assessApiVersion' => 'v2',
        'questionsApiVersion' => 'v2',
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_adaptive.php',
            'onsave_redirect_url'   => 'itemsapi_adaptive.php'
        )
    )
);

if (isset($_POST['adaptive'])) {
    foreach ($_POST['adaptive'] as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $childKey => $childValue) {
                if (strlen($childValue)) {
                    $request['adaptive'][$key][$childKey] = (float) $childValue;
                } else {
                    unset($request['adaptive'][$key][$childKey]);
                }
            }
        } else {
            if (strlen($value)) {
                $request['adaptive'][$key] = (float) $value;
            } else {
                unset($request['adaptive'][$key]);
            }
        }
    }
}

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
    <h1>Items API – Adaptive Assessment</h1>
    <p>A dynamic assessment that adapts to the user's ability in real time.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="//docs.learnosity.com/itemsapi/adaptive/itemadaptive.php" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                <span class="glyphicon glyphicon-list-alt"></span> Customise Adaptive Settings
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_activities.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="//items.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
