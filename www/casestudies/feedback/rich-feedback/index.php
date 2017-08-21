<?php

include_once '../../../config.php';
include_once 'includes/header.php';

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

$request = [
    'user_id'        => $studentid,
    'rendering_type' => 'assess',
    'assess_inline'  => true,
    'name'           => 'Student Assessment demo',
    'state'          => $session_state,
    'activity_id'    => 'DemoTest_DemoSiteExample',
    'session_id'     => $session_id,
    'course_id'      => 'commoncore',
    'activity_template_id' => 'FEEDBACK_DEMO_TEST',
    'type'           => 'submit_practice',
    'config'         => array(
        'labelBundle' => array(
            'item' => 'Question'
        ),
        'configuration' => array(
            'onsubmit_redirect_url' => 'feedback.php?session_id='. $session_id
        ),
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    )
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Student Assessment – Step 1</h1>
        <p>Here is a sample student assessment, with a mix of auto and non-autoscorable question types.</p>
        <p>Take the test as a student would, you will then be able to provide teacher feedback after completing the assessment.</p>
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
                history.pushState({}, '', window.location.pathname + '?session_id=<?php echo $session_id; ?>');
            }
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function toggleModalClass () {
        $('.modal-backdrop').css('display', 'none');
    }
</script>

<?php include_once 'includes/footer.php';
