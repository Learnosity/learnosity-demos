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
    'user_id' => 'demos-site',
    'items' => [
        'Demo3',
        'Demo4',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',
        'Demo10'
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Regions</h2>
            <p>Learnosity regions are a part of the Assess API, and allow you to create a personalized, fluid and extensible assessment UI.</p>
            <p>All visual elements such as buttons, timer, pager, etc. are modularized in such a way that they can be placed
            in different <em>regions</em> of the assessment container.</p>
            <p>Read more about regions on the <a href="http://docs.learnosity.com/assessapi/knowledgebase/regions.php">docs site</a>,
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
