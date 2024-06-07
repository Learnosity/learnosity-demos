
<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$item_ref = Uuid::generate();
$activity_id = 'Demo_Activity';

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => Uuid::generate()]]);

$request = [
    'activity_id'    => $activity_id,
    'name'           => 'End to End Demo - Assessment',
    'rendering_type' => 'assess',
    'type'           => 'submit_practice',
    'session_id'     => $session_id,
    'user_id'        => 'demo_student',
    'items'          => getItemsArray(),
    'config'         => [
        'title' => 'Demo Activity',
        'configuration' => [
            'onsubmit_redirect_url' => 'feedback.php?session_id=' . $session_id
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
        'labelBundle' => [
            'close' => 'Go to Reporting'
        ],
        'time' => [
            'show_pause' => true,
            'max_time' => 300
        ]
    ]
];


function getItemsArray()
{
    $references = explode(",", filter_input(INPUT_GET, 'itemIDs', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
    $itemsArray = [];
    foreach ($references as $key => $reference) {
        $itemsArray[] = [
            'id' => Uuid::generate(),
            'reference' => $reference
        ];
    }
    return $itemsArray;
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
