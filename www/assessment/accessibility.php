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
    'activity_id' => 'itemsaccessibilitydemo',
    'name' => 'Items API demo - Accessibility Demo',
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
        'title' => 'Accessibility Demo',
        'subtitle' => 'Walter White',
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
            <h2>Accessibility</h2>
            <p>
                The Assess API has a built in accessibility options panel that allows students to adjust settings during their assessment. Options include changing the colour scheme, font size and instructions on how to zoom.
            </p>
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
                itemsApp.dialogs().accessibility.show();
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
