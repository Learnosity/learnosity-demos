$(function () {

    // ===========================================================================================
    // Clients define their own initOptions as well as how the QuestionsAPI signature is generated
    // The code below is just an example of how signature is generated
    // ===========================================================================================
    var widgetJson = {
            "is_math": true,
            "stimulus": "Sally has {{var:x}} apples, she gives {{var:y}} apples to Jack. How many apples does she have left?",
            "type": "formulaV2",
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [{
                        "method": "equivLiteral",
                        "value": "{{var:correctAnswer}}",
                        "options": {
                            "inverseResult": false,
                            "decimalPlaces": 10
                        }
                    }]
                }
            },
            "metadata": {
                "dynamic_content_data": {
                    "variables": [
                        {"name": "x", "min": 10, "max": 15, "step": 1},
                        {"name": "y", "min": 1, "max": 14, "step": 1}
                    ],
                    "equation": "{{var:x}}-{{var:y}}={{response}}"
                }
            }
        };
    var questionEditorInitOptions = {
        configuration: {
            consumer_key: 'xxx',
        },
        rich_text_editor: {
            type: 'wysihtml'
        },
        widgetType: 'response',
        question_type_templates: {
            formulaV2: [
                {
                    "name": "Algorithmic Math",
                    "description": "Algorithmic Math question type",
                    "group_reference": "math",
                    "defaults": {
                        "is_math": true,
                        "stimulus": "<p>[This is the algorithmic math question type demo.]</p>",
                        "type": "formulaV2"
                    }
                }
            ]
        },
        ui: {
            layout: {
                edit_panel: {
                    formulaV2: [
                        {
                            layout: 'algorithmic-formulaV2-layout'
                        }
                    ]
                }
            }
        },
        label_bundle: {
            'metadata.dynamic_content_data.variables.button.add': 'Add Variable',
            'validation.valid_response.score': 'Score value',
            'template': 'Math Problem'
        },
        widget_json: widgetJson,
        custom_metadata: {
            dynamic_content_data: {
                type: "object",
                attributes: {
                    equation: {
                        name: 'Equation',
                        type: 'string',
                        required: false
                    },
                    variables: {
                        name: 'Variables',
                        type: 'array',
                        items: {
                            type: 'object',
                            attributes: {
                                name: {
                                    name: 'Name',
                                    type: 'string'
                                },
                                min: {
                                    name: 'Min',
                                    type: 'number',
                                    required: true,
                                    default: 0
                                },
                                max: {
                                    name: 'Max',
                                    type: 'number',
                                    required: true,
                                    default: 1
                                },
                                step: {
                                    name: 'Step',
                                    type: 'number',
                                    required: true,
                                    default: 1
                                },
                                decimal_place: {
                                    name: 'Decimal',
                                    type: 'number',
                                    required: false,
                                    default: 0
                                }
                            }
                        }
                    },
                    added_answers: {
                        namme: 'Added answers',
                        type: 'array',
                        required: false,
                        items: {
                            type: 'object',
                                attributes: {
                                row_index: {
                                    name: 'Row index',
                                    type: 'number'
                                },
                                value: {
                                    name: 'Value',
                                    type: 'number'
                                }
                            }
                        }
                    },
                    exclude: {
                        name: 'Exclude rows',
                        required: false,
                        type: 'array',
                            items: {
                            type: 'number'
                        }
                    }
                }
            }
        }
    };
    var user_id = 'demo_user';
    var domain = window.domain;
    var containerSelector = '.my-editor';
    var workersPath = 'build/' + window.versionPath + '/workers/';
    var LRNAlgorithmicMath = window.LRNAlgorithmicMath;
    var questionEditorApp, securityData, algorithmicMathApp;

    // Should set those 4 values in order to init LRN algorithmicMathApp:
    //
    // securityData = {
    //     consumer_key = '...',
    //     user_id = '...',
    //     timestamp = '...',
    //     signature = '...'
    // }
    //
    function getSecurityData() {
        var $deferred = new $.Deferred();
        var onSecurityDataLoaded = function (data) {
            securityData = data;
            questionEditorInitOptions.configuration.consumer_key = data.consumer_key;

            $deferred.resolve();
        };

        $.ajax({
            url: 'https://docs.learnosity.com/demos/isolation/chromeAppLogin/security.php',
            method: 'POST',
            data: {
                userid: user_id,
                domain: domain
            }
        })
        .done(onSecurityDataLoaded)
        .fail($deferred.reject);

        return $deferred;
    }

    // ===========================================================================================
    // LRN Question Editor initialisation
    // ===========================================================================================
    function initQuestionEditor() {
        questionEditorApp = LearnosityQuestionEditor.init(
            questionEditorInitOptions,
            containerSelector
        );

        return $.Deferred().resolve();
    }

    // ===========================================================================================
    // LRN algorithmicMathApp initialisation
    // ===========================================================================================
    function initAlgorithmicMath() {
        algorithmicMathApp = new LRNAlgorithmicMath({
            questionEditorApp: questionEditorApp,
            security: securityData,
            workersPath: workersPath
        });
    }

    // =============================================================================================
    // NOTE: this method is exposed to test re-initialization or bad execution of the app.
    // DO NOT USE THIS IN PRODUCTION CODE
    // =============================================================================================
    window.bootstrap = function () {
        getSecurityData()
            .then(initQuestionEditor)
            .then(initAlgorithmicMath);
    };
    window.mimicBadData = function () {
        questionEditorApp.setWidget(widgetJson);
        initAlgorithmicMath();
    };
    // =============================================================================================

    // Bootstrap app example
    window.bootstrap();
});
