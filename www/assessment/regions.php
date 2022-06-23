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
    'activity_id' => 'itemsregionsdemo',
    'name' => 'Items API demo - regions',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo3'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo4'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo6'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo7'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo8'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo9'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo10'
        ]
    ],
    'config' => [
        'title' => 'Demo activity - showcasing regions',
        'subtitle' => 'Walter White',
        'regions' => 'main',
        'configuration'       => [
            'onsubmit_redirect_url'  => 'regions.php',
            'onsave_redirect_url'    => 'regions.php',
            'ondiscard_redirect_url' => 'regions.php'
        ],
    ]
];

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Customize the Assessment Player UI</h2>
            <p>Learnosity regions are a part of the Assess API, and allow you to create a personalized, fluid and extensible assessment UI.</p>
            <p>All visual elements such as buttons, timer, pager, etc. are modularized in such a way that they can be placed
            in different <em>regions</em> of the assessment container.</p>
            <p>Read more about regions on the <a href="https://support.learnosity.com/hc/en-us/articles/360000758337-Customizing-the-Assessment-Player-experience-with-Regions">docs site</a>,
            or select one of the <a href="#" class="text-muted" data-toggle="modal" data-target="#settings">default or custom regions</a>
            to see the sorts of things you can do.</p>
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
include_once '../../src/views/modals/settings-items-regions.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
