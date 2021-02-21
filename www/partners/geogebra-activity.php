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


//simple api request object for Items API
$request = [
    'activity_id' => 'demos_geogebra',
    'activity_template_id' => 'GeoGebra_Testing_Activity',
    'name' => 'GeoGebra Demo',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'config' => [
        'configuration' => [
            'onsubmit_redirect_url' => 'geogebra.php'
        ],
        'regions' => [
            'top-right' => [
                [
                    'type' => 'pause_button',
                    'position' => 'right'
                ],
                [
                    'type' => 'timer_element'
                ],
                [
                    'type' => 'reading_timer_element'
                ],
                [
                    'type' => 'itemcount_element',
                    'position' => 'right'
                ]
            ],
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'verticaltoc_element'
                ],
                [
                    'type' => 'custom_button',
                    'options' => [
                        'name' => 'geogebra',
                        'label' => 'GeoGebra Graphing',
                        'icon_class' => 'lrn_btn ggb-calc-toggle ggb-icon-graphing'
                    ]
                ]
            ],
            'bottom-right' => [
                [
                    'type' => 'next_button'
                ],
                [
                    'type' => 'previous_button'
                ]
            ]
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
        </ul>
    </div>
    <div class="overview">
        <h2>GeoGebra</h2>
        <p style="text-align:justify;">
        This is an example of a Learnosity Activity (assessment) with GeoGebra Popup Calculator.
        </p>
        <p>
        Return to Authoring View to see <a href="./geogebra.php">how to integrate GeoGebra in your Learnosity Authoring environment</a>.
        </p>
    </div>
</div>

<!-- Container for the author api to load into -->
<div class="section pad-sml">
    <!--    HTML placeholder that is replaced by API-->
    <div id="learnosity_assess"></div-->
</div>

<!-- version of api maintained in lrn_config.php file -->
<script src="<?php echo $url_items; ?>"></script>
<script>
        var initializationObject = <?php echo $signedRequest; ?>;

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

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);


</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';