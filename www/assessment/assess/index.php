<?php

include_once '../../config.php';
include_once 'utils/uuid.php';
include_once 'includes/header.php';

$uniqueResponseIdSuffix = UUID::generateUuid();

//The assess app is loaded in a iframe via assess.learnosity.com so the signature needs
// to be generated with this domain.
$assessdomain = 'assess.learnosity.com';

//Activity JSON:  http://docs.learnosity.com/api/activity.php
$activitySignature = hash("sha256", $consumer_key . '_' . $assessdomain . '_' . $timestamp . '_' . $studentid . '_' . $consumer_secret);
$signedRequest = '{
    "items": [
        {
          "reference": "Demo3",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_demo3\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_demo3"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo4",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo4\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo4"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo5",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo5\"></span><span class=\"learnosity-feature\" data-type=\"calculator\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo5"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo6",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo6\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo6"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo7",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo7\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo7"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo8",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo8\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo8"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo9",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo9\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo9"
          ],
          "feature_ids": []
        },
        {
          "reference": "Demo10",
          "content": "<span class=\"learnosity-response question-'.$uniqueResponseIdSuffix.'_Demo10\"></span>",
          "workflow": [],
          "response_ids": [
            "'.$uniqueResponseIdSuffix.'_Demo10"
          ],
          "feature_ids": []
        }
    ],
    "time": {
        "max_time": 600,
        "limit_type": "soft",
        "show_pause": true,
        "warning_time": 60,
        "show_time": true
    },
    "ui_style": "main",
    "labelBundle": {
        "appName": "Assess Demo",
        "sheet": "Question"
    },
    "navigation": {
        "scroll_to_top": false,
        "scroll_to_test": false,
        "show_fullscreencontrol": true,
        "show_next": true,
        "show_prev": true,
        "show_save": false,
        "show_submit": true,
        "show_title": true,
        "intro_sheet": "",
        "show_intro": true,
        "outro_sheet": "",
        "show_outro": true,
        "toc": {
            "show_itemcount": true
        }
    },
    "name": "Demo Activity (8 questions)",
    "state": "initial",
    "questionsApiActivity": {
        "consumer_key": "' . $consumer_key . '",
        "timestamp": "' . $timestamp . '",
        "signature": "' . $activitySignature . '",
        "user_id": "' . $studentid . '",
        "type": "submit_practice",
        "state": "initial",
        "id": "assessdemo_' . UUID::generateUuid() . '",
        "name": "Assess API - Demo",
        "course_id": "' . $courseid . '",
        "questions": [
         {
            "type": "orderlist",
            "list": [
              "cat",
              "horse",
              "pig",
              "elephant",
              "mouse"
            ],
            "stimulus": "<p>Arrange these animals from smallest to largest</p>",
            "ui_style": "button",
            "validation": {
              "show_partial_ui": true,
              "partial_scoring": true,
              "valid_score": 1,
              "penalty_score": 0,
              "valid_response": [
                4,
                0,
                2,
                1,
                3
              ],
              "pairwise": false
            },
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_demo3",
            "metadata": {
              "sheet_reference": "Demo3",
              "widget_reference": "demo3"
            }
          },
          {
            "type": "clozeassociation",
            "template": "<p> <strong>The United States of America was founded in {{response}}.</strong></p>",
            "possible_responses": [
              "1676",
              "1776",
              "1876"
            ],
            "feedback_attempts": 2,
            "instant_feedback": true,
            "validation": {
              "show_partial_ui": true,
              "partial_scoring": true,
              "valid_score": 1,
              "penalty_score": 0,
              "valid_responses": [
                [
                  "1776"
                ]
              ]
            },
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo4",
            "metadata": {
              "sheet_reference": "Demo4",
              "widget_reference": "Demo4"
            }
          },
          {
            "type": "clozetext",
            "template": "<p>What is the sum of \\(785 \\times 89\\)</p> {{response}}",
            "is_math": true,
            "validation": {
              "show_partial_ui": true,
              "partial_scoring": true,
              "valid_score": 1,
              "penalty_score": 0,
              "valid_responses": [
                [
                  "69865"
                ]
              ]
            },
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo5",
            "metadata": {
              "sheet_reference": "Demo5",
              "widget_reference": "Demo5"
            }
          },
          {
            "type": "numberline",
            "points": [
              "5/5",
              "1/4",
              "2/4",
              "7/8"
            ],
            "is_math": true,
            "labels": {
              "points": "0,1,2,3,4",
              "show_min": true,
              "show_max": true
            },
            "line": {
              "min": 0,
              "max": 4,
              "left_arrow": true,
              "right_arrow": true
            },
            "stimulus": "<p>Drag the points onto the numberline.</p>",
            "ticks": {
              "distance": ".25",
              "show": true
            },
            "validation": {
              "partial_scoring": "true",
              "show_partial_ui": "true",
              "valid_score": "1",
              "penalty_score": "0",
              "threshold": "0",
              "valid_responses": [
                {
                  "point": "5/5",
                  "position": "1"
                },
                {
                  "point": "1/4",
                  "position": ".25"
                },
                {
                  "point": "2/4",
                  "position": "2"
                },
                {
                  "point": "7/8",
                  "position": "3.5"
                }
              ]
            },
            "instant_feedback": true,
            "snap_to_ticks": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo6",
            "metadata": {
              "sheet_reference": "Demo6",
              "widget_reference": "Demo6"
            }
          },
          {
            "type": "tokenhighlight",
            "template": "<p>He was told not to laugh in class.</p>",
            "tokenization": "word",
            "validation": {
              "show_partial_ui": true,
              "partial_scoring": true,
              "valid_score": 1,
              "penalty_score": 0,
              "valid_responses": [
                5
              ]
            },
            "stimulus": "<p>Highlight the verb in the sentence below.</p>",
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo7",
            "metadata": {
              "sheet_reference": "Demo7",
              "widget_reference": "Demo7"
            }
          },
          {
            "type": "mcq",
            "options": [
              {
                "value": "0",
                "label": "Berlin"
              },
              {
                "value": "1",
                "label": "Paris"
              },
              {
                "value": "2",
                "label": "London"
              },
              {
                "value": "3",
                "label": "Madrid"
              }
            ],
            "stimulus": "<strong>What\'s the capital of France?</strong>",
            "stimulus_review": "Something Else",
            "ui_style": {
              "type": "block",
              "choice_label": "upper-alpha"
            },
            "valid_responses": [
              {
                "value": "1",
                "score": 1
              }
            ],
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo8",
            "metadata": {
              "sheet_reference": "Demo8",
              "widget_reference": "Demo8"
            }
          },
          {
            "type": "clozedropdown",
            "template": "“It’s all clear,’ he {{response}}. “Have you the chisel and the bags? Great Scott! Jump, Archie, jump, and I’ll swing for it!’ Sherlock {{response}} had sprung out and seized the {{response}} by the collar. The other dived down the hole, and I heard the sound of {{response}} cloth as Jones clutched at his skirts. The light flashed upon the barrel of a revolver, but Holmes’ {{response}} came down on the man’s wrist, and the pistol {{response}} upon the stone floor.",
            "possible_responses": [
              [
                "whispered",
                "sprinted",
                "joked"
              ],
              [
                "Homes",
                "holmes",
                "Holmes"
              ],
              [
                "acquaintance",
                "intruder",
                "shopkeeper"
              ],
              [
                "burning",
                "departing",
                "rending",
                "broken"
              ],
              [
                "revolver",
                "hunting crop"
              ],
              [
                "rattled",
                "clinked",
                "spilt"
              ]
            ],
            "stimulus": "<p><strong>Fill in the blanks.</strong></p>",
            "validation": {
              "show_partial_ui": true,
              "partial_scoring": true,
              "valid_score": 1,
              "penalty_score": 0,
              "valid_responses": [
                [
                  "whispered"
                ],
                [
                  "Holmes"
                ],
                [
                  "intruder"
                ],
                [
                  "rending"
                ],
                [
                  "hunting crop"
                ],
                [
                  "clinked"
                ]
              ]
            },
            "ui_style": {
              "fontsize": "large"
            },
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo9",
            "metadata": {
              "sheet_reference": "Demo9",
              "widget_reference": "Demo9"
            }
          },
          {
            "type": "graphplotting",
            "axis_x": {
              "ticks_distance": 1,
              "draw_labels": true
            },
            "axis_y": {
              "ticks_distance": 1,
              "draw_labels": true
            },
            "canvas": {
              "x_min": 0,
              "x_max": 10.2,
              "y_min": -0.5,
              "y_max": 10.2,
              "snap_to": "grid"
            },
            "grid": {
              "x_distance": 1,
              "y_distance": 1
            },
            "toolbar": {
              "tools": [
                "point",
                "move"
              ],
              "default_tool": "move"
            },
            "ui_style": {
              "margin": "10px"
            },
            "stimulus": "<p>Plot the following points \\((2,5), (4,8), (8,1)\\).</p>",
            "is_math": true,
            "validation": {
              "valid_score": "1",
              "penalty_score": "0",
              "valid_responses": [
                [
                  {
                    "id": "lrn_1",
                    "type": "point",
                    "coords": {
                      "x": 2,
                      "y": 5
                    }
                  },
                  {
                    "id": "lrn_2",
                    "type": "point",
                    "coords": {
                      "x": 4,
                      "y": 8
                    }
                  },
                  {
                    "id": "lrn_3",
                    "type": "point",
                    "coords": {
                      "x": 8,
                      "y": 1
                    }
                  }
                ]
              ]
            },
            "instant_feedback": true,
            "response_id": "'.$uniqueResponseIdSuffix.'_Demo10",
            "metadata": {
              "sheet_reference": "Demo10",
              "widget_reference": "Demo10"
            }
          }
        ]
    },
    "configuration": {
        "onsave_redirect_url": "' . $env['protocol'] . $env['page'] . '",
        "onsubmit_redirect_url": "' . $env['protocol'] . $env['page'] . '",
        "questionsApiVersion": "v2"
    }
}';

?>

<div class="jumbotron">
    <h1>Assess API</h1>
    <p>Assessment made easy – configurable layouts, pause, fullscreen mode, simple assessment delivery to desktops and tablet devices in no time at all.<p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/assessapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-4"> <p class='text-right'><a class="btn btn-primary btn-lg" href="<?php echo $env['www'] ?>authoring/author/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the assess api to load into -->
<span id="learnosity_assess"></span>
<script src="//assess.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityAssess.init(activity, "learnosity_assess");
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
