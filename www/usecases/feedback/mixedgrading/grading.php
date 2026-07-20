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

// Item 2 is rendered + scored by the Grading API; items 1 & 3 use Items API
$is_production = (getenv('deploy_env') === 'production');
$item2_ref = $is_production
    ? '6690583c-d231-4641-8516-6dac3aa795ad'
    : 'feb9a6c0-a1a1-43b0-92d7-60ed9b2952f8';

$items_api_items = array_values(array_filter($items, fn($i) => $i !== $item2_ref));

// Items API signed request — student user_id, items 1 & 3 only
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
    'items'          => $items_api_items,
];

$gradingInit = new Init('items', $security, $consumer_secret, $gradingRequest);
$signedGradingRequest = $gradingInit->generate(false);

// Grading API signed request — grader user_id, item 2 only
$grading_security = [
    'user_id'      => $grader_id,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
    'timestamp'    => $timestamp,
];

$gradingApiRequest = [
    'user_id'        => $grader_id,
    'rendering_type' => 'inline',
    'name'           => 'Mixed Grading – Manual',
    'state'          => $state,
    'session_id'     => $session_id,
];

$gradingApiInit = new Init('items', $grading_security, $consumer_secret, $gradingApiRequest);
$signedGradingApiRequest = $gradingApiInit->generate(false);

$appConfig = json_encode([
    'items'           => $items,
    'item2Ref'        => $item2_ref,
    'sessionId'       => $session_id,
    'studentId'       => $student_id,
    'graderId'        => $grader_id,
    'activityId'      => $activity_id,
    'activity'        => $signedGradingRequest,      // Items API (items 1 & 3)
    'gradingActivity' => $signedGradingApiRequest,   // Grading API (item 2)
    'readonly'        => false,
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
<script src="<?= $url_grading ?>"></script>
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
