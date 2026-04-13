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
                    "question_type_groups": [{
                        "name": "Custom Question Types",
                        "reference": "custom_q_types"
                    }],
                    "question_type_templates": {
                        "custom_clock": [{
                            "name": "Custom Question - Clock",
                            "description": "A custom question type - clock",
                            "group_reference": "custom_q_types",
                            "defaults": {
                                "type": "custom",
                                "stimulus": "Oh no! The hands on the clock have gotten all messed up! Help fix the clock by moving the hands to show what time it is! <br><strong>Drag the hands to show 4:30 on the clock.</strong>",
                                "js": {
                                    "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_q.js",
                                    "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_s.js"
                                },
                                "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock.css",
                                "instant_feedback": true,
                                "valid_response" : {
                                    "hourHandAngle": 45, 
                                    "minHandAngle": 90
                                  },
                                  "score":1
                            }
                        }]
                    },
                    "custom_question_types": [{
                        "custom_type": "custom_clock",
                        "type": "custom",
                        "name": "Custom Question - clock",
                        "editor_layout": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_layout.html",
                        "js": {
                            "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_q.js",
                            "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_s.js"
                        },
                        "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock.css",
                        "version": "v1.0.0",
                        "editor_schema": {
                            "hidden_question": false,
                            "properties": {
                                "instant_feedback": {
                                    "name": "Check answer button",
                                    "description": "Enables the Check Answer button underneath the question, which will provide the student with instant feedback on their response(s).",
                                    "type": "boolean",
                                    "required": false,
                                    "default": false
                                },
                                "valid_response": {
                                    "type": "question",
                                    "name": "Set correct answer(s)",
                                    "description": "Correct answer for the question",
                                    "whitelist_attributes": ["valid_response", "value"]
                                },
                                "score": {
                                    "type": "number",
                                    "name": "Score",
                                    "description": "Score for a correct answer.",
                                    "required": true,
                                    "default": 1
                                }
                            }
                        }
                    }]
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
            <h2>Author Custom Questions - clock</h2>
            <p>Create Custom Questions that can appear in the authoring environment and assessments. In this demo, we've added a Custom Clock question.
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
