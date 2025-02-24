<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$grader_id = filter_input(INPUT_GET, 'grader_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? Uuid::generate();
$student_id = filter_input(INPUT_GET, 'student_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'initial';
$items = filter_input(INPUT_GET, 'items', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$timestamp = gmdate('Ymd-Hi');

$security = [
    'user_id'      => $grader_id,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
    'timestamp'    => $timestamp
];

$gradingRequest = [
    'organisation_id'      => $roAdditionalOrgId,
    'user_id'              => $grader_id,
    'rendering_type'       => 'inline',
    'name'                 => 'Teacher Assessment demo',
    'state'                => $state,
    'session_id'           => $session_id,
];
$items = explode(',', $items);

$gradingInit = new Init('items', $security, $consumer_secret, $gradingRequest);
$signedGradingRequest = $gradingInit->generate(false);

$appConfig = json_encode([
    'items'     => $items,
    'sessionId' => $session_id,
    'studentId'    => $student_id, // student ID
    'graderId'  => $grader_id,
    'activity'  => $signedGradingRequest,
]);

?>

    <script src="<?= $url_grading ?>"></script>
    <link rel="stylesheet" media="all" href="includes/styles/main.css">

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h1>Teacher Scoring – Step 2</h1>
            <p>This page renders the student’s assessment in review, and loads the interactive scoring and teacher feedback controls alongside the questions that require a score to be set. In this example a score is mandatory for each question within items for the manual grading to be saved and submitted.</p>
        </div>
    </div>

    <div class="section">
        <div class="row">
            <h1>Teacher Scoring</h1>
        </div>
        <div id="manual-grading">
            <div class="row">
                <div id="inline-items-wrapper"></div>
            </div>
        </div>
        <div class="row submit-btn-group">
            <button type="button" class="mg-grading-next-btn" aria-label="Go to next step Submit" data-original-title="Go to next step" style="" id="lrn_assess_next_btn" disabled>
                <span class="btn-label">Save and submit to learner</span>
                <span class="btn-spinner" style="display: none;"></span>
            </button>
        </div>
    </div>
    <script id="grading-inline-script"
            type="module"
            data-parameters='<?php echo htmlspecialchars($appConfig, ENT_QUOTES); ?>'
            src="includes/js/grading.js"></script>

<?php
include_once 'includes/footer.php';
