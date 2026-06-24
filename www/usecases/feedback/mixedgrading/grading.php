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
$activity_id = filter_input(INPUT_GET, 'activity_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$state = filter_input(INPUT_GET, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'initial';
$items = filter_input(INPUT_GET, 'items', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$timestamp = gmdate('Ymd-Hi');

$consumer_key = $consumer_key_postgres;
$consumer_secret = $consumer_secret_postgres;

$items = explode(',', $items);

$security = [
    'user_id'      => $student_id,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
    'timestamp'    => $timestamp
];

$gradingRequest = [
    'user_id'        => $student_id,
    'rendering_type' => 'inline',
    'name'           => 'Teacher Assessment demo',
    'state'          => 'review',
    'session_id'     => $session_id,
    'activity_id'    => $activity_id,
    'items'          => $items,
];

$gradingInit = new Init('items', $security, $consumer_secret, $gradingRequest);
$signedGradingRequest = $gradingInit->generate(false);

$appConfig = json_encode([
    'items'      => $items,
    'sessionId'  => $session_id,
    'studentId'  => $student_id,
    'graderId'   => $grader_id,
    'activityId' => $activity_id,
    'activity'   => $signedGradingRequest,
    'readonly'   => false,
]);

?>

<?php
// Determine Feedback Aide environment
$fa_host = explode('.', $_SERVER['HTTP_HOST']);
$fa_env = '';
if (in_array('dev', $fa_host)) $fa_env = '.dev';
elseif (in_array('staging', $fa_host)) $fa_env = '.staging';
elseif (in_array('ldc', $fa_host)) $fa_env = '.ldc';
?>

<script src="<?= $url_items ?>"></script>
<script src="https://feedbackaide<?= $fa_env ?>.learnosity.com/js"></script>
<link rel="stylesheet" media="all" href="includes/styles/main.css">
<?php include_once 'includes/icons.php'; ?>

<div class="jumbotron section">
    <div class="overview">
        <h1>Teacher Scoring – Step 2</h1>
        <p>This page renders the student’s assessment in review, and loads the interactive scoring and teacher feedback controls alongside the questions that require a score to be set.</p>
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
