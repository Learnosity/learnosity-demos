<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//alias(es) to eliminate the need for fully qualified classname(s) from sdk
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//security object. timestamp added by SDK
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

//here we use our GeoGebra config file to define Geogebra's Custom Features and Question Types.
//Contact GeoGebra to get a commercial licence.
$GeogebraConfig = gzdecode(file_get_contents('https://cdn.geogebra.org/partners/learnosity/self-host.json'));
$GeogebraConfig = json_decode($GeogebraConfig, true);


// Initialization options for Authoring Demo using Author API
$authorRequest = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => $GeogebraConfig
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];


// Initialization options for Assessment Demo using Items API
$itemsRequest = [
    'activity_id' => 'demos_geogebra',
    'activity_template_id' => 'GeoGebra_Testing_Activity',
    'name' => 'GeoGebra Demo',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'config' => [
        'configuration' => [
            'onsubmit_redirect_url' => 'geogebra.php'
        ],
        'region_overrides' => [
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'custom_button',
                    'options' => [
                        'name' => 'geogebra',
                        'label' => 'GeoGebra Graphing',
                        'icon_class' => 'lrn_btn ggb-calc-toggle ggb-icon-graphing'
                    ]
                ],
                [
                    'type' => 'verticaltoc_element'
                ]
            ]
        ],
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ]
    ]
];


$InitItems = new Init('items', $security, $consumer_secret, $itemsRequest);
$signedRequestItems = $InitItems->generate();

$InitAuthor = new Init('author', $security, $consumer_secret, $authorRequest);
$signedRequestAuthor = $InitAuthor->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h2>GeoGebra</h2>
        <p style="text-align:justify;">
        GeoGebra provides several powerful math tools including a graphing calculator, geometry tool, spreadsheet,
        probability calculator, algebra calculator and 3D graphing.
        </p>
        <p style="text-align:justify;">
        With the Learnosity and GeoGebra partnership, Learnosity clients have access to thousands of ready-made STEM
        education materials to create interactive, engaging learning and assessment opportunities for students.
        </p>
        <p>
        You will find two different demos below:
        </p>
        <ul>
            <li><p><a href="#authoring">Demo 1: Authoring GeoGebra content</a></p></li>
            <li><p><a href="#assessment">Demo 2: Assessment with GeoGebra tools</a></p></li>
        </ul>
    </div>
</div>

<!-- Container for the author api to load into -->
<div id="authoring" class="section pad-sml">
    <h3>Demo 1: Authoring GeoGebra content</h3>
    <p>This is the Learnosity Author API with GeoGebra Custom Questions and Features enabled. You can create Learnosity content including GeoGebra Calculators, Excersices and Notes.</p>
    <hr>
    <!--    HTML placeholder that is replaced by API-->
    <div id="learnosity-author"></div>
</div>

<!-- Container for the author api to load into -->
<div id="assessment" class="section pad-sml">
    <h3>Demo 2: Assessment with GeoGebra tools</h3>
    <p>This is the Learnosity Items API loading an Activity with GeoGebra content. You can also find the GeoGebra calculator in the Assessment toolbar.</p>
    <!--    HTML placeholder that is replaced by API-->
    <hr>
    <div id="learnosity_assess"></div>
</div>

<!-- version of api maintained in lrn_config.php file -->
<script src="<?php echo $url_authorapi; ?>"></script>
<script src="<?php echo $url_items; ?>"></script>
<script>
        var initializationObjectAuthor = <?php echo $signedRequestAuthor; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Learnosity API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObjectAuthor, callbacks);


        var initializationObjectItems = <?php echo $signedRequestItems; ?>;

        var callbacks = {
            readyListener: function () {
                console.log("Items API has successfully initialized.");

                // Following code is to render a custom feature (like geogebra calculator) to activity
                var assessApp = itemsApp.assessApp();
                assessApp.append({
                    features: [
                        {
                            "type": "customfeature",
                            "js": "https://cdn.geogebra.org/partners/learnosity/geogebra.js",
                            "css": "https://cdn.geogebra.org/partners/learnosity/geogebra.css",
                            "width": 750,
                            "height": 550,
                            "perspective": "AG",
                            "theme": false,
                            "showtutoriallink": false,
                            "showtoolbarhelp": false,
                            "showtoolbar": true,
                            "showmenubar": false,
                            "inlineButton": false,
                            "showtutoriallink": true
                        }
                    ]
                }).then(function(data) {
                    var graphingCalculator = data.features["customfeature-0"];
                    // dispatch the public method that is defined inside graphing calculator customfeature
                    assessApp
                    .on("button:geogebra:clicked", function(e) {
                        console.log(e);
                        graphingCalculator.toggle();
                    })
                    .on("item:changed", function() {
                        graphingCalculator.stop();
                    });
                });
            },
            errorListener: function (err) {
                console.log(err);
            }
        };


        var itemsApp = LearnosityItems.init(initializationObjectItems, callbacks);

</script>

<?php
    include_once 'includes/footer.php';