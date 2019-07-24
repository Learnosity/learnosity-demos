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
    'activity_id' => 'testletadaptivedemo',
    'name' => 'Items API - Testlet Adaptive activity',
    'rendering_type' => 'assess',
    'organisation_id' => 505, //we use organisation_id in this demo because the Items are coming from a read-only org
    'session_id' => $sessionId,
    'user_id' => 'demos-site',
    'adaptive' => [
        'type' => 'branching',
        'item_difficulty_tolerance' => 1,
        'min_item_difficulty' => -4,
        'max_item_difficulty' => 2,
        'initial_ability' => 0,
        'eap' => [
            'mean' => -0.25,
            'standard_deviation' => 0.95,
            'theta_min' => -3,
            'theta_max' => 2.25,
            'num_points' => 40
        ],
        'sequence' => [
            [
                'required_tags' => [
                    'Testlet' => [
                        'sequence-2A'
                    ]
                ]
            ],
            [
                'required_tags' => [
                    'Testlet' => [
                        'sequence-2B'
                    ]
                ]
            ]
        ]
    ],
    'config' => [
        'title' => 'Item Adaptive Assessment',
        'regions' => 'main',
        'navigation' => [
            'intro_item' => 'branching-intro'
        ],
        'configuration' => [
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Build Testlet Adaptive Assessments</h2>
            <p>Create adaptive experiences that choose which fixed-form testlet to load at each decision point.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
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
