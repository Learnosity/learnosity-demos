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
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
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
        'title' => 'Demo activity - showcasing question types and assess options',
        'subtitle' => 'Walter White',
        'regions' => [
            'top-left' => [
                [
                    'type' => 'title_element'
                ]
            ],
            'top-right' => [
                [
                    'type' => 'itemcount_element'
                ]
            ],
            'right' => [
                [
                    'type' => 'verticaltoc_element'
                ],
                // *** Annotations API buttons *** //
                [
                    'type' => 'notepad_button'
                ],
                [
                    'type' => 'stickynote_add_button'
                ],
                [
                    'type' => 'stickynote_visibility_button'
                ],
                [
                    'type' => 'drawing_mode_button'
                ],
                [
                    'type' => 'drawing_visibility_button'
                ],
                // -------------------------- //
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'calculator_button'
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
        ],
        'annotations' => true,
        'annotations_api_init_options' => [
            'modules' => [
                'notepad' => true,
                'texthighlight' => true,
                'drawing' => true,
                'stickynote' => true
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Enable Annotations for Student Use</h2>
            <p>Annotations let students add sticky notes, highlighting, and freehand sketches to their responses, giving educators even greater access to learners' thought processes.</p>
            <p>For more information about Annotations, please see our <a href="https://reference.learnosity.com/annotations-api/" target="_blank">documentation</a>.</p>
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
