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
    'state'=> 'initial',
    'activity_id'=> 'tryagaindemo',
    'items'=> [
        'Space Demo Item 4 - New',
        'Try_Again_math_test'
    ],
    'name'=> 'TEST',
    'type'=> 'submit_practice',
    'rendering_type'=> 'assess',
    'course_id'=> 'commoncore',
    'session_id'=> Uuid::generate(),
    'user_id'=> 'demos-site',
    'dynamic_items'=> [
        'try_again'=> [
            'max_attempts'=> 5,
            'random'=> true
        ]
    ],
    'config'=> [
        'navigation'=> [
            'show_intro'=> false
        ],
        'regions'=> 'main',
        'region_overrides'=> [
            'bottom'=> [[
                'type'=> 'try_again_button'
            ]]
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
            <h2>Using Dynamic Content And "Try Again" in Assessments</h2>
            <p>This demo showcases the <a href="https://help.learnosity.com/hc/en-us/articles/360000755358-Using-Dynamic-Content-and-Try-Again-in-your-Assessments">Try Again</a> functionality. Try Again allows students to ask for another set of data for the Question they are attempting..</p>
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
