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
    'user_id' => 'demos-site',
    'adaptive' => [
        'type' => 'itembranching',
        'steps' => [
            [
                'id' => 'item-1',
                'reference' => 'French_Demo1',
                'next' => [
                    'correct' => 'item-3',
                    'incorrect' => 'item-2'
                ]
            ],
            [
                'id' => 'item-2',
                'reference' => 'French_Demo2',
                'next' => 'item-3'
            ],
            [
                'id' => 'item-3',
                'reference' => 'French_demo4',
                'next' => 'decision-1',
            ],
            [
                'id' => 'decision-1',
                'type' => 'global-score',
                'percentage' => 50,
                '>=' => 'item-5',
                '<' => 'item-4',
            ],
            [
                'id' => 'item-4',
                'reference' => 'French_Demo3',
                'next' => 'item-5'
            ],
            [
                'id' => 'item-5',
                'reference' => 'French_Demo5',
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
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Delivering branching assessments</h2>
            <p>A simple dynamic assessment that selects the next item or branch based on past performance, according to a pre-defined configuration.</p>
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
