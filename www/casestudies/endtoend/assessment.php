
<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$item_ref = Uuid::generate();
$activity_id = 'Demo_Activity';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

if (isset($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
    $session_state = 'resume';
} else {
    $session_id = Uuid::generate();
    $session_state = 'initial';
}


$request = array(
    'activity_id'    => $activity_id,
    'name'           => 'End to End Demo - Assessment',
    'rendering_type' => 'assess',
    'state'          => $session_state,
    'type'           => 'submit_practice',
    'session_id'     => $session_id,
    'user_id'        => $studentid,
    'items'          => getItemsArray(),
    'assess_inline'  => true,
    'config'         => [
        'title' => 'Demo Activity',
        'configuration' => [
            'onsubmit_redirect_url' => 'feedback.php?session_id='. $session_id
        ],
        'regions' => [
            'top-right' => [
                [
                    'type' => 'itemcount_element',
                ],
                [
                    'type' => 'timer_element'
                ],
                [
                    'type' => 'pause_button'
                ]
            ],
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'separator_element'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'verticaltoc_element'
                ],
                [
                    'type' => 'masking_button'
                ]
            ],
            'bottom-right' => [
                [
                    'type' => 'next_button'
                ],
                [
                    'type' => 'previous_button'
                ]
            ]
        ],
        'labelBundle' => array(
            'close' => 'Go to Reporting'
        ),
        'time' => [
            'show_pause' => true,
            'max_time' => 300
        ],
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    ]
);


function getItemsArray() {
    return explode(",", $_GET['itemIDs']);
}


$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Assessment</h1>
        <p>Here is a sample student assessment containing the questions created by the author in step 1.</p>
        <p>Take the test as a student would, you will then be able to provide teacher feedback after completing the assessment.</p>
    </div>
</div>

<div class="section">
    <div id="learnosity_assess"></div>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;

    var itemsApp = LearnosityItems.init(initOptions);
</script>

<?php
    include_once 'includes/footer.php';
