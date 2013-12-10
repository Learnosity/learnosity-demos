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
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'course_id'      => $courseid,
    'session_id'     => UUID::generateUuid(),
    'user_id'        => $studentid,
    'items'          => array('ccore_video_260_classification', 'ccore_parcc_tecr_grade3'),
    'config'         => array(
        'title'      => '',
        'subtitle'   => 'Walter White',
        'navigation' => array(
            'show_next'              => true,
            'show_prev'              => true,
            'show_fullscreencontrol' => false,
            'show_progress'          => true,
            'show_submit'            => true,
            'show_title'             => true,
            'show_save'              => false,
            'show_calculator'        => false,
            'scroll_to_top'          => false,
            'scroll_to_test'         => false,
            'show_itemcount'         => true,
            'toc'                    => true,
            'transition'             => 'slide',
            'transition_speed'       => 400
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => true,
            'warning_time' => 1440,
            'show_time'    => true
        ),
        'ui_style'            => 'main',
        'ignore_validation'   => false,
        'questionsApiVersion' => 'v2',
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_assess.php',
            'onsave_redirect_url'   => 'itemsapi_assess.php',
            'idle_timeout'          => array(
                'interval'       => 300,
                'countdown_time' => 60
            )
        )
    )
);

// Examine the settings modal form post and replace the default
// $request variables.
if (isset($_POST['ui_style'])) {
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subkey => $subvalue) {
                if ($subvalue === 'true') {
                    $_POST[$key][$subkey] = true;
                } elseif ($subvalue === 'false') {
                    $_POST[$key][$subkey] = false;
                }
            }
        } else {
            if ($value === 'true') {
                $_POST[$key] = (bool)$value;
            } elseif ($value === 'false') {
                $_POST[$key] = false;
            }
        }
    }
    $request['config'] = array_replace_recursive($request['config'], $_POST);
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
    <h1>Items API – Assess</h1>
    <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.<p>
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
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_inline.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="http://items.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
