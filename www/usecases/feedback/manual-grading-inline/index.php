<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$activity_template_id = filter_input(INPUT_GET, 'activity_template_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'Manual Grading collection';
$session_id    = Uuid::generate();
$session_state = 'initial';
$activity_id   = Uuid::generate();

$onsubmit_redirect_url = 'grading.php?';
$items = [
    'Manual Grading Demo - Item 1',
    'Manual Grading Demo - Item 3',
    'Manual Grading Demo - Item 11',
    'Manual Grading Demo - Item 6',
    'Manual Grading Demo - Item 10',
    'Manual Grading Demo - Item 12',
];
$params = [
    'session_id'            => $session_id,
    'student_id'            => Uuid::generate(),
    'activity_id'           => $activity_id,
    'activity_template_id'  => $activity_template_id,
    'items'                 =>  implode(',', $items)
];

$request = [
    'organisation_id'      => $roAdditionalOrgId,
    'user_id'              => $params['student_id'],
    'rendering_type'       => 'assess',
    'assess_inline'        => true,
    'name'                 => 'Student Assessment demo',
    'state'                => $session_state,
    'activity_id'          => $activity_id,
    'session_id'           => $params['session_id'],
    'activity_template_id' => $params['activity_template_id'],
    'type'                 => 'submit_practice',
    'config'               => array(
        'configuration' => array(
            'onsubmit_redirect_url' => $onsubmit_redirect_url . http_build_query($params),
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

    <script src="<?= $url_items ?>"></script>
    <link rel="stylesheet" media="all" href="includes/styles/main.css">

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://help.learnosity.com/hc/en-us/articles/19987787700893-Grading-API" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h1>Student Assessment – Step 1</h1>
            <p>Here is a sample student assessment, with a mix of auto and non-autoscorable question types.</p>
            <p>Take the test as a student would, then you will be redirected to the manual scoring functionality to score the assessment.</p>
            <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
        </div>
    </div>

    <div class="section">
        <!-- Container for the items api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script id="items-script"
            type="module"
            data-parameters='<?php echo htmlspecialchars($signedRequest, ENT_QUOTES); ?>'
            src="includes/js/items.js"></script>

<?php
include_once 'includes/footer.php';
