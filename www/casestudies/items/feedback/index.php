<?php

//external config for key/secret etc.

include_once '../../../config.php';
include_once 'includes/header.php';

//use SDK
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

//show in initial state to start and, when reloaded with session id, show in review mode
if (isset($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
    $session_state = 'resume';
} else {
    $session_id = Uuid::generate();
    $session_state = 'initial';
}

//build request object
$request = [
    'user_id'        => $studentid,
    'rendering_type' => 'assess',
    'assess_inline'  => true,
    'name'           => 'Items API demo - assess activity demo',
    'state'          => $session_state,
    'activity_id'    => "DemoTest_DemoSiteExample",
    'session_id'     => $session_id,
    'course_id'      => 'commoncore',
    'activity_template_id' => "FEEDBACK_DEMO_TEST",
    'type'           => 'submit_practice',
    'config'         => [
        'captureOnResumeError' => true,
        'configuration' => [
            'onsubmit_redirect_url' => 'feedback.php?session_id='. $session_id
        ],
        "navigation" => array(
            "show_outro" => false,
            "show_intro" => false
        ),
        'regions' => "main"
    ]
];


//start signed request
$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Assessment and Feedback</h1>
        <p>Teacher and Peer feedback is an integral part to any product. Complete the assessment below to go to your Teacher feedback page.</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                //add to history to support back button and show in resume mode
                history.pushState({}, '', window.location.pathname + '?session_id=' + activity.request.session_id);
            }
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function toggleModalClass () {
        $('.modal-backdrop').css('display', 'none');
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
