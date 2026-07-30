<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$consumer_key    = $consumer_key_postgres;
$consumer_secret = $consumer_secret_postgres;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$activity_template_id = filter_input(INPUT_GET, 'activity_template_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'Mixed Grading collection';
$session_id    = Uuid::generate();
$session_state = 'initial';
$activity_id   = Uuid::generate();

$onsubmit_redirect_url = 'grading.php?';

// Environment-specific item references
$is_production = (getenv('deploy_env') === 'production');
if ($is_production) {
    $items = [
        'c6c4a5ac-7f4c-4deb-9c39-bcb4af901027',
        '6690583c-d231-4641-8516-6dac3aa795ad',
        'e228d3d5-08be-4b05-9f59-09cfc179e31a'
    ];
} else {
    $items = [
        '8d77bf34-22bc-407b-bcea-78b161c3ef5b',
        'feb9a6c0-a1a1-43b0-92d7-60ed9b2952f8',
        '9c8d60ef-d46f-4430-8fc6-5c0fef988aa9'
    ];
}
$params = [
    'session_id'            => $session_id,
    'student_id'            => Uuid::generate(),
    'activity_id'           => $activity_id,
    'activity_template_id'  => $activity_template_id,
    'items'                 =>  implode(',', $items)
];

$request = [
    'user_id'              => $params['student_id'],
    'rendering_type'       => 'assess',
    'assess_inline'        => true,
    'name'                 => 'Mixed Grading Demo',
    'state'                => $session_state,
    'activity_id'          => $activity_id,
    'session_id'           => $params['session_id'],
    'activity_template_id' => $params['activity_template_id'],
    'type'                 => 'submit_practice',
    'config'               => array(
        'configuration' => array(
            'title' => 'Mixed Grading Demo',
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
    <div class="overview">
        <h1>Student Assessment – Step 1</h1>
        <p>Here is a sample student assessment, with a mix of auto and non-autoscorable question types.</p>
        <p>Take the test as a student would, then you will be redirected to the manual scoring functionality to score the assessment.</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;">
            <pre><code id="xApiPreview"></code></pre>
        </div>
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
