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
        'title' => 'Accessibility Demo',
        'subtitle' => 'Walter White',
        'regions' => 'main',
        'region_overrides' => [
            'right.masking_button' => true,
            'right.linereader_button' => true
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
            <h2>Offer Accessibility Controls and Assistive Tools</h2>
            <p>Beyond our ability to work with system-level screen-readers, braille displays, and keyboard helpers behind the scenes, Learnosity provides in-built accessibility options which can be configured, extended and set as defaults.</p>
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
