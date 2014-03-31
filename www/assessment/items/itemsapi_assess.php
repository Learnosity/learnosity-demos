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
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'course_id'      => $courseid,
    'session_id'     => UUID::generateUuid(),
    'user_id'        => $studentid,
    'items'          => array("Demo3", "Demo4", "Demo5", "Demo6", "Demo7", "Demo8", "Demo9", "Demo10"),
    'config'         => array(
        'title'      => 'Demo activity - showcasing question types and assess options',
        'subtitle'   => 'Walter White',
        'navigation' => array(
            'scroll_to_top'            => false,
            'scroll_to_test'           => false,
            'show_intro'               => true,
            'show_outro'               => false,
            'show_next'                => true,
            'show_prev'                => true,
            'show_fullscreencontrol'   => false,
            'show_progress'            => true,
            'show_submit'              => true,
            'show_title'               => true,
            'show_save'                => false,
            'show_calculator'          => false,
            'show_itemcount'           => true,
            'skip_submit_confirmation' => false,
            'swipe'                    => true,
            'toc'                      => true,
            'transition'               => 'slide',
            'transition_speed'         => 400,
            'warning_on_change'        => false,
            'scrolling_indicator'      => false
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => true,
            'warning_time' => 120,
            'show_time'    => true
        ),
        'ui_style'            => 'main',
        'ignore_validation'   => false,
        'questionsApiVersion' => 'v2',
        'assessApiVersion'    => 'v2',
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_assess.php',
            'onsave_redirect_url'   => 'itemsapi_assess.php',
            'idle_timeout'          => array(
                'interval'       => 300,
                'countdown_time' => 60
            ),
            'stylesheet' => '',
            'fontsize'   => 'normal'
        )
    )
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
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="<?php echo $env['www'] ?>assessment/items/itemsapi_inline.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
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
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
