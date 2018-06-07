<?php

include_once '../../config.php';
include_once 'includes/header.php';

$request = array(
    'configuration' => array(
        'consumer_key' => $consumer_key
    ),
    'widget_type' => 'response',
    'ui' => array(
        'layout' => array(
            'global_template' => 'edit'
        )
    ),
    'dependencies' => [
        'questions_api' => [
            'init_options' => [
                'beta_flags' => [
                    'reactive_views' => true
                ]
            ]
        ]
    ]
);

include_once 'utils/settings-override.php';

if (empty($request['question_type'])) {
    $request['question_type'] = 'choicematrix';
}

switch ($request['question_type']) {
    case 'mcq':
        $widget_json = '{
            "options": [
                {
                    "label": "[Choice A]",
                    "value": "0"
                },
                {
                    "label": "[Choice B]",
                    "value": "1"
                },
                {
                    "label": "[Choice C]",
                    "value": "2"
                },
                {
                    "label": "[Choice D]",
                    "value": "3"
                }
            ],
            "stimulus": "<p>This is the question the student will answer</p>",
            "type": "mcq",
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        "2"
                    ]
                }
            },
            "ui_style": {
                "type": "horizontal"
            }
        }';
        // https://docs.learnosity.com/authoring/questioneditor/knowledgebase/author-api-template-references
        // Template Name is case sensitive
        $widget_template = 'Multiple choice – standard';
        break;
    case 'mcq-block':
        $widget_json = '{
            "options": [
                {
                    "label": "[Choice A]",
                    "value": "0"
                },
                {
                    "label": "[Choice B]",
                    "value": "1"
                },
                {
                    "label": "[Choice C]",
                    "value": "2"
                },
                {
                    "label": "[Choice D]",
                    "value": "3"
                }
            ],
            "stimulus": "<p>This is the question the student will answer using the block UI</p>",
            "type": "mcq",
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        "1"
                    ]
                }
            },
            "ui_style": {
                "type": "block",
                "choice_label": "upper-alpha"
            }
        }';
        // https://docs.learnosity.com/authoring/questioneditor/knowledgebase/author-api-template-references
        // Template Name is case sensitive
        $widget_template = 'Multiple choice – block layout';
        break;
    case 'choicematrix':
        $widget_json = '{
            "options": [
                "True",
                "False"
            ],
            "stems": [
                "[Stem 1]",
                "[Stem 2]",
                "[Stem 3]",
                "[Stem 4]"
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "choicematrix",
            "ui_style": {
                "stem_numeration": "upper-alpha",
                "type": "table",
                "horizontal_lines": false
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        null,
                        null,
                        null,
                        null
                    ]
                }
            }
        }';
        // https://docs.learnosity.com/authoring/questioneditor/knowledgebase/author-api-template-references
        // Template Name is case sensitive
        $widget_template = 'Choice matrix – labels';
        break;
    case 'association':
        $widget_json = '{
            "possible_responses": [
                "[Choice A]",
                "[Choice B]",
                "[Choice C]"
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "stimulus_list": [
                "[Stem 1]",
                "[Stem 2]",
                "[Stem 3]"
            ],
            "type": "association",
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        null,
                        null,
                        null
                    ]
                }
            }
        }';
        // https://docs.learnosity.com/authoring/questioneditor/knowledgebase/author-api-template-references
        // Template Name is case sensitive
        $widget_template = 'Match list';
        break;
    default:
        die('Missing question type');
        break;
}

$request['widget_json'] = json_decode($widget_json, true);
$signedRequest = array_merge_recursive(array(), $request);
// remove variable for demo page internal use.
unset($signedRequest['question_type']);
$signedRequest = json_encode($signedRequest);

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings">
                <a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                    <span class="glyphicon glyphicon-list-alt"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object">
                <a href="#" data-toggle="modal" data-target="#initialisation-preview">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation">
                <a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation">
                    <span class="glyphicon glyphicon-book"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box">
                <a href="#">
                    <span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API – Edit Question</h1>
        <p>Setup the Question Editor to directly load a question, bypassing the question tiles screen. For more information refer to <a href="http://docs.learnosity.com/authoring/questioneditor/initialisation#widget_json">the init options docs</a> and <a href="http://docs.learnosity.com/authoring/questioneditor/publicmethods#setWidget">the setWidget</a> public method.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <div class="learnosity-question-editor"></div>
</div>

<script src="<?php echo $url_questioneditor; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest ?>,
        domHook = 'learnosity-question-editor',
        eventOptions = {
            readyListener: function () {
                qeApp.setWidget(
                    <?php echo $widget_json; ?>,
                    '<?php echo $widget_template; ?>'
                );
            },
            errorListener: function (event) {
                console.log(event);
            }
        },
        qeApp;

    qeApp = LearnosityQuestionEditor.init(
        initOptions,
        domHook,
        eventOptions
    );
</script>

<?php
include_once 'views/modals/settings-questioneditor-v3.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
