<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = [
    'user_id'      => 'demos-site',
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

//simple api request object for item list view, with optional creation of items
$request = [
    'mode'      => 'item_edit',
    'reference' => Uuid::generate(),
    'config'    => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => json_decode('{
                    "question_type_groups": [
                        {
                            "name": "Custom Question Types",
                            "reference": "custom_q_types"
                        }
                    ],
                    "question_type_templates": {
                        "custom_box_and_whisker": [
                            {
                                "name": "Custom Question - Box & Whisker",
                                "description": "A custom question type - Box & Whisker",
                                "group_reference": "custom_q_types",
                                "defaults": {
                                "type": "custom",
                                "stimulus": "Draw a <b>box &amp; whisker</b> chart for the following: <b>6, 2, 5, 3, 6, 10, 11, 6</b>",
                                "js": {
                                    "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_q.js",
                                    "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_s.js"
                                },
                                "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker.css",
                                "line_min": 1,
                                "line_max": 19,
                                "step": 1,
                                "min": 2,
                                "max": 14,
                                "quartile_1": 4,
                                "median": 6,
                                "quartile_3": 10,
                                "score": 1,
                                "valid_response": {
                                    "type": "object",
                                    "value": {
                                    "min": 2,
                                    "max": 11,
                                    "quartile_1": 5,
                                    "median": 6,
                                    "quartile_3": 8
                                    }
                                },
                                "instant_feedback": true
                                }
                            }
                        ]
                    },
                    "custom_question_types": [
                        {
                            "custom_type": "custom_box_and_whisker",
                            "type": "custom",
                            "name": "Custom Question - Box And Whisker",
                            "editor_layout": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_layout.html",
                            "js": {
                                "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_q.js",
                                "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker_s.js"
                            },
                            "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_box_whisker.css",
                            "version": "v1.0.0",
                            "editor_schema": {
                                "hidden_question": false,
                                "properties": {
                                "line_min": {
                                    "type": "number",
                                    "name": "Minimum range",
                                    "description": "Set minimum range.",
                                    "required": true,
                                    "default": 0
                                },
                                "line_max": {
                                    "type": "number",
                                    "name": "Maximum range",
                                    "description": "Set maximum range.",
                                    "required": true,
                                    "default": 20
                                },
                                "min": {
                                    "type": "number",
                                    "name": "Min",
                                    "description": "Set default min value.",
                                    "required": true
                                },
                                "max": {
                                    "type": "number",
                                    "name": "Max",
                                    "description": "Set default max value.",
                                    "required": true
                                },
                                "step": {
                                    "type": "number",
                                    "name": "Step",
                                    "description": "Set snap to range step value.",
                                    "required": true,
                                    "default": 1
                                },
                                "quartile_1": {
                                    "type": "number",
                                    "name": "Quartile 1",
                                    "description": "Set default first quartile value.",
                                    "required": true
                                },
                                "median": {
                                    "type": "number",
                                    "name": "Median",
                                    "description": "Set default median value.",
                                    "required": true
                                },
                                "quartile_3": {
                                    "type": "number",
                                    "name": "Quartile 3",
                                    "description": "Set default last quartile value.",
                                    "required": true
                                },
                                "valid_response": {
                                    "name": "Set correct answer(s)",
                                    "description": "In this section, configure the correct answer(s) for the question.",
                                    "type": "question",
                                    "white_list": ["line_min", "line_max", "min", "max", "step", "quartile_1", "median", "quartile_3"]
                                },
                                "score": {
                                    "name": "Point(s)",
                                    "description": "Score awarded for the correct response(s).",
                                    "type": "number",
                                    "required": true,
                                    "default": 1
                                },
                                "instant_feedback": {
                                    "name": "Check answer button",
                                    "description": "Enables the Check Answer button underneath the question, which will provide the student with instant feedback on their response(s).",
                                    "type": "boolean",
                                    "required": false,
                                    "default": false
                                }
                                }
                            }
                        }
                    ]
                }',true)
            ]
        ]
    ],
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Author Custom Questions - Box & Whisker</h2>
            <p>Create Custom Questions that can appear in the authoring environment and assessments. In this demo, we've added a Custom Box & Whisker question.
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Author API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);
    </script>


<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
