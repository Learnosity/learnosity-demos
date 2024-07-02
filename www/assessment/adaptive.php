<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$sessionId = Uuid::generate();

//simple api request object for Items API
$request = [
    'activity_id' => 'itemadaptivedemo',
    'name' => 'Items API - Item Adaptive activity',
    'rendering_type' => 'assess',
    'session_id' => $sessionId,
    'user_id' => 'ANONYMIZED_USER_ID',
    'adaptive' => [
        'type' => 'itemadaptive',
        'initial_ability' => 0,
        'item_difficulty_tolerance' => 0.1,
        'item_difficulty_offset' => 0,
        'eap' => [
            'mean' => 0,
            'standard_deviation' => 1,
            'theta_min' => -4,
            'theta_max' => 4,
            'num_points' => 50
        ],
        'termination_criteria' => [
            'min_items' => 5,
            'max_items' => 50,
            'error_below' => 0.7
        ],
        'required_tags' => [
            [
                'type' => 'adaptive-lifecycle',
                'name' => 'operational'
            ]
        ]
    ],
    'config' => [
        'title' => 'Item Adaptive Assessment',
        'regions' => 'main',
        'navigation' => [
            'intro_item' => 'adaptive-intro'
        ],
        'configuration'       => [
            'onsubmit_redirect_url' => 'adaptive-report.php?session_id=' . $sessionId
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Generate Item Adaptive (Rasch Model) Assessments</h2>
            <p>Use our item adaptive technology to deliver an adaptive test to your student based on item difficulty level and user ability.</p>        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the Items API assessment player to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Items API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
