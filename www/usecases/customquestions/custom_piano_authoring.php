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
                        "custom_piano": [{
                            "name": "Custom Question - Piano",
                            "description": "A custom question type - Piano",
                            "group_reference": "custom_q_types",
                            "defaults": {
                                "type": "custom",
                                "stimulus": "<strong>Identify the notes of a C major chord on the piano. Any inversion is permissible. Click a key to hear the note.</strong>",
                                "js": {
                                    "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano_q.js",
                                    "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano_s.js"
                                },
                                "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano.css",
                                "instant_feedback": true,
                                "valid_response": {
                                    "notes": ["C", "E", "G"],
                                    "indecies": [0, 4, 7]
                                },
                                "score": 1
                            }
                        }]
                    },
                    "custom_question_types": [{
                        "custom_type": "custom_piano",
                        "type": "custom",
                        "name": "Custom Question - Piano",
                        "editor_layout": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano_layout.html",
                        "js": {
                            "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano_q.js",
                            "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano_s.js"
                        },
                        "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_piano.css",
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
    <div class="overview">
        <h2>Maintenance Mode</h2>
        <p>The Authoring Demos are currently undergoing maintenance and will return soon.</p>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
