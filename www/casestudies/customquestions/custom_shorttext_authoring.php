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
    'domain'       => $_SERVER['SERVER_NAME'],
    'consumer_key' => $consumer_key
];

$request = '{
  "id": "custom-shorttext",
  "type": "local_practice",
  "state": "initial",
  "session_id": "' . $session_id . '",
  "questions": []
}';


$init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

?>
<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/questions/knowledgebase/customquestions" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Custom Question - Short Text</h1>
        <p>Here is a demo which shows an example custom authoring implementation of the Short Text question type.</p>
        <p>Author can create inline element rendered using Learnosity Questions API or a complete custom element to control the output json of Questions Editor</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div id="lrnQuestionEditor">
        </div>
    </div>
</div>

<script src="<?php echo $url_questioneditor; ?>"></script>
<script src="<?php echo $url_questions; ?>"></script>
<script>
    // Learnosity - An example on how to create inline custom element when author custom question type
    (function () {
        var editorSchemas = {
            "hidden_question": false,
            "properties": {
                "width": {
                    "type": "number",
                    "name": "Width",
                    "required": false
                },
                "height": {
                    "type": "number",
                    "name": "Height",
                    "required": false
                },
                "validation": {
                    "type": "object",
                    "name": "Valid response",
                    "required": false,
                    "attributes": {
                        "score": {
                            "type": "number",
                            "name": "Score",
                            "group": "validation",
                            "description": "Score for a correct answer.",
                            "required": false
                        },
                        "valid_response": {
                            "type": "object",
                            "required": false,
                            "attributes": {
                                "value": {
                                    "type": "string",
                                    "name": "Correct Answer",
                                    "required": false
                                }
                            }
                        }
                    }
                }
            }
        };
        var initOptions = {
            configuration: {
                consumer_key: '<?php echo $consumer_key; ?>'
            },
            question_type_groups: [
                {
                    "reference" : "custom_question",
                    "name" : "Custom question collection",
                    "group_icon": "https://www.learnosity.com/static/img/features/features_proven.png"
                }
            ],
            question_type_templates: {
                custom_short_text_inline_questions_api: [
                    {
                        "name": "Custom Question - Short text + inline Questions API",
                        "description": "A custom question type - short text - with inline Questions API to set validation data",
                        "group_reference": "custom_question",
                        "image": "//assets.learnosity.com/questiontypes/templates/mcqmulti.png",
                        "defaults": {
                            "type": "custom",
                            "js": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.js",
                            "css": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.css"
                        }
                    }
                ],
                custom_short_text_custom_renderer: [
                    {
                        "name": "Custom Question - Short text + custom Renderer",
                        "description": "A custom question type - short text - with custom Renderer to set validation data",
                        "group_reference": "custom_question",
                        "image": "//assets.learnosity.com/questiontypes/templates/mcqmulti.png",
                        "defaults": {
                            "type": "custom",
                            "js": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.js",
                            "css": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.css"
                        }
                    }
                ]
            },
            custom_question_types: [{
                "custom_type": "custom_short_text_inline_questions_api",
                "type": "custom",
                "name": "Custom Shorttext (DRAFT)",
                "editor_layout": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.html",
                "js": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.js",
                "css": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.css",
                "version": "v0.1.0",
                "editor_schema": editorSchemas
            }, {
                "custom_type": "custom_short_text_custom_renderer",
                "type": "custom",
                "name": "Custom Shorttext (DRAFT)",
                "editor_layout": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.html",
                "js": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.js",
                "css": "//demos.staging.learnosity.com/casestudies/customquestions/custom_shorttext.css",
                "version": "v0.1.0",
                "editor_schema": editorSchemas
            }]
        };

        var getNested = function (object, attributeString) {
            if (object) {
                var split = attributeString.match(/(.+?)\.(.*)/);
                if (split) {
                    return getNested(object[split[1]], split[2]);
                }

                return object[attributeString];
            }
        };
        var listenForQEAttributesChange = function (qeApp, keys, callback) {
            var repository = {};
            var widgetJson = qeApp.getWidget();

            $.each(keys, function (__, key) {
                repository[key] = widgetJson[key];
            });

            qeApp.on('revisionHistoryState:change', function () {
                var widgetJson = qeApp.getWidget();

                if (widgetJson) {
                    $.each(repository, function (key, value) {
                        var newValue = widgetJson[key];

                        if (newValue !== value) {
                            repository[key] = newValue;

                            callback({
                                key: key,
                                value: newValue
                            });
                        }
                    });
                }
            });
        };

        // ===============================================================================
        // Using custom renderer to render any UI
        // ===============================================================================
        var ShorttextCustomRenderer = function ($editPanel, qeApp) {
            this.$editPanel = $editPanel;
            this.qeApp = qeApp;

            this.init();
            this.render();
        };

        ShorttextCustomRenderer.prototype.init = function () {
            listenForQEAttributesChange(this.qeApp, ['width', 'height'], function (data) {
                var key = data.key;
                var value = data.value;

                this.$el[key](value);
            }.bind(this));
        };

        ShorttextCustomRenderer.prototype.render = function () {
            var widgetJson = this.qeApp.getWidget();
            var width = widgetJson.width;
            var height = widgetJson.height;
            var value = getNested(widgetJson, 'validation.valid_response.value');

            this.$editPanel
                .find('[data-custom-shorttext-element]')
                .replaceWith('<input class="custom-input" type="text">');

            this.$el = this.$editPanel
                .find('.custom-input')
                .width(width)
                .height(height)
                .val(value)
                .on('change', function (event) {
                    var validationValueAttr = this.qeApp.attribute('validation.valid_response.value');

                    validationValueAttr.setValue(event.currentTarget.value);
                }.bind(this));
        };

        ShorttextCustomRenderer.prototype.reset = function () {
            this.qeApp.off('revisionHistoryState:change');
        };

        // ===============================================================================
        // Using Questions API to render the current Custom Question as inline element
        // ===============================================================================
        var _count = 0;
        var ShorttextInlineQuestionsApiRenderer = function ($editPanel, qeApp, questionsApp) {
            this.$editPanel = $editPanel;
            this.qeApp = qeApp;
            this.questionsApp = questionsApp;

            this.init();
            this.render();
        };

        ShorttextInlineQuestionsApiRenderer.prototype.init = function () {
            listenForQEAttributesChange(this.qeApp, ['width', 'height'], function () {
                this.render();
            }.bind(this));

            this.$editPanel
                .find('[data-custom-shorttext-element]')
                .replaceWith('<div class="questionContainer"></div>');

            this.$questionContainer = this.$editPanel.find('.questionContainer');
        };

        ShorttextInlineQuestionsApiRenderer.prototype.render = function () {
            var widgetJson = this.qeApp.getWidget();
            var value = getNested(widgetJson, 'validation.valid_response.value');
            var responseId = 'inline-' + _count;
            var responses = {};

            // NOTE that in this case we use `responses` argument because we want the new question instance
            // to be "resumed" with validation.valid_response.value as its value. If you are not using current
            // question instance to update
            responses[responseId] = {
                value: value
            };

            this.$questionContainer
                .html('<span class="learnosity-response question-' + responseId + '"/>');

            this.questionsApp.append({
                questions: [
                    $.extend(widgetJson, {
                        response_id: responseId
                    })
                ],
                responses: responses
            });

            this._responseId = responseId;

            _count++;
        };

        ShorttextInlineQuestionsApiRenderer.prototype.appendInstanceComplete = function () {
            var _instance = this.questionsApp.question(this._responseId);

            if (_instance) {
                _instance.on('change', function () {
                    var newValue = _instance.getResponse().value;
                    var validationValueAttr = this.qeApp.attribute('validation.valid_response.value');

                    validationValueAttr.setValue(newValue);
                }.bind(this));
            }
        };

        ShorttextInlineQuestionsApiRenderer.prototype.getQuestionInstance = function () {
            var questionsApp = this.questionsApp;

            return new Promise(function (resolve, reject) {
                setInterval(function () {
                    this.questionsApp.question(responseId);
                }, 10);
            });
        };

        ShorttextInlineQuestionsApiRenderer.prototype.reset = function () {
            this.qeApp.off('revisionHistoryState:change');
        };
        // ===============================================================================
        var customQuestionHandlers = {
            custom_short_text_custom_renderer: ShorttextCustomRenderer,
            custom_short_text_inline_questions_api: ShorttextInlineQuestionsApiRenderer
        };
        var questionEditorApp = LearnosityQuestionEditor.init(initOptions, '#lrnQuestionEditor');
        var _hiddenQuestionApp = LearnosityApp.init(<?php echo $signedRequest; ?>, {
            readyListener: function () {
                // For inline question renderer to detect when a new question instance has been appended successfully,
                // we need to rely on this readyListener to tell when an instance is ready
                if (_handler && _handler.appendInstanceComplete) {
                    _handler.appendInstanceComplete();
                }
            }
        });
        var _handler, _activeInlineQuestionInstance;

        // Listen to the right events to bootstrap our custom handler
        questionEditorApp.on('widget:ready', function (data) {
            var widget = questionEditorApp.getWidget();
            var Handler;

            if (widget.type === 'custom') {
                Handler = customQuestionHandlers[widget.custom_type];

                if (Handler) {
                    _handler = new Handler($(data.wrapper), questionEditorApp, _hiddenQuestionApp);
                }
            }
        });

        questionEditorApp.on('widget:changed', function () {
            if (_handler) {
                _handler.reset && _handler.reset();
                _handler = null;
            }
        });

        // Expose window context in case we want to access the public method of questionEditorApp
        window.questionEditorApp = questionEditorApp;
    })();
</script>
<?php
include_once 'includes/footer.php';
