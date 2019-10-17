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


//simple api request object for Items API
$request = [
    'activity_id' => 'itemsbranchingdemo',
    'name' => 'Items Branching Demo',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'adaptive' => [
        'type' => 'itembranching',
        'steps' => [
            [
                'id' => 'question-1',
                'reference' => 'item_branching_demo_q1',
                'next' => [
                    'correct' => 'question-3',
                    'incorrect' => 'question-2'
                ]
            ],
            [
                'id' => 'question-2',
                'reference' => 'item_branching_demo_q2',
                'next' => 'question-3'
            ],
            [
                'id' => 'question-3',
                'reference' => 'item_branching_demo_q3',
                'next' => 'decision-1',
            ],
            [
                'id' => 'decision-1',
                'type' => 'global-score',
                'percentage' => 50,
                '>=' => 'question-5',
                '<' => 'question-4',
            ],
            [
                'id' => 'question-4',
                'reference' => 'item_branching_demo_q4',
                'next' => 'question-5'
            ],
            [
                'id' => 'question-5',
                'reference' => 'item_branching_demo_q5',
                'next' => null
            ],
        ]
    ],
    'config' => [
        'title' => 'Item Branching Assessment',
        'regions' => 'main'
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
            <h2>Create Branching Assessments</h2>
            <p>Use the power of Learnosity's branching assessment format to build an adaptive activity that seamlessly adapts to your user.</p>
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
