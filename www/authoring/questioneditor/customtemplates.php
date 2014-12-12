<?php

include_once '../../config.php';
include_once 'includes/header.php';

$request = '{
    "question_type_groups": [
        {
            "reference": "custom-1",
            "name": "MC Questions"
        },
        {
            "reference": "custom-2",
            "name": "Cloze Questions"
        },
        {
            "reference": "custom-3",
            "name": "Math/Graph Questions"
        },
        {
            "reference": "custom-4",
            "name": "Misc Questions"
        }
    ],
    "question_types": {
        "mcq": {
            "image": "http://dw6y82u65ww8h.cloudfront.net/questiontypes/templates/mcqblock.png"
        }
    },
    "template_defaults": false,
    "ui": {
        "public_methods": [],
        "layout": "2-column",
        "question_tiles": false,
        "documentation_link": false,
        "change_button": true,
        "source_button": false,
        "fixed_preview": true,
        "advanced_group": false,
        "search_field": false
    },
    "configuration": {
        "questionsApiVersion": "v2"
    },
    "question_type_templates": {
        "mcq": [
            {
                "name": "Multiple Choice",
                "group_reference": "custom-1",
                "defaults": {
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
                    "ui_style": {
                        "choice_label": "upper-alpha",
                        "type": "block"
                    },
                    "stimulus": "<p>This is the question the student will answer</p>",
                    "type": "mcq",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                ""
                            ]
                        }
                    }
                }
            },
            {
                "name": "Multiple Choice - multi-response",
                "group_reference": "custom-1",
                "defaults": {
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
                    "multiple_responses": true,
                    "ui_style": {
                        "choice_label": "upper-alpha",
                        "type": "block"
                    },
                    "stimulus": "<p>This is the question the student will answer</p>",
                    "type": "mcq",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                ""
                            ]
                        }
                    }
                }
            }
        ],
        "tokenhighlight": [
            {
                "name": "Token Highlight",
                "group_reference": "custom-4",
                "defaults": {
                    "stimulus": "<p>[This is the stem.]</p>",
                    "template": "<p><span class=\"lrn_token\">Risus et tincidunt turpis facilisis.</span></p><p><span class=\"lrn_token\">Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. dignissim, et tincidunt turpis facilisis.</span></p><p><span class=\"lrn_token\">Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.</span></p>",
                    "tokenization": "custom",
                    "type": "tokenhighlight",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1
                        }
                    }
                }
            }
        ],
        "longtext": [
            {
                "name": "Essay with formatting",
                "group_reference": "custom-4",
                "hidden": [
                    "is_math",
                    "stimulus_review"
                ],
                "defaults": {
                    "character_map": true,
                    "stimulus": "<p>[This is the stem.]</p>",
                    "type": "longtext"
                }
            }
        ],
        "numberline": [
            {
                "name": "Numberline",
                "group_reference": "custom-3",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "labels.show_min",
                    "labels.show_max",
                    "labels.points"
                ],
                "defaults": {
                    "is_math": true,
                    "labels": {
                        "frequency": 1,
                        "show_max": true,
                        "show_min": true
                    },
                    "line": {
                        "max": 10,
                        "min": 0
                    },
                    "points": [
                        "[Choice A]",
                        "[Choice B]",
                        "[Choice C]"
                    ],
                    "snap_to_ticks": true,
                    "stimulus": "<p>[This is the stem.]</p>",
                    "ticks": {
                        "distance": 1,
                        "show": true
                    },
                    "type": "numberline",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                {
                                    "point": "[Choice A]",
                                    "position": ""
                                },
                                {
                                    "point": "[Choice A]",
                                    "position": ""
                                },
                                {
                                    "point": "[Choice A]",
                                    "position": ""
                                }
                            ]
                        }
                    }
                }
            }
        ],
        "shorttext": [
            {
                "name": "Short Text",
                "group_reference": "custom-4",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "description"
                ],
                "defaults": {
                    "stimulus": "<p>[This is the stem.]</p>",
                    "type": "shorttext",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": ""
                        }
                    }
                }
            }
        ],
        "clozeassociation": [
            {
                "name": "Cloze Drag & Drop",
                "group_reference": "custom-2",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "case_sensitive"
                ],
                "defaults": {
                    "possible_responses": [
                        "Choice A",
                        "Choice B"
                    ],
                    "response_container": {
                        "pointer": "left"
                    },
                    "stimulus": "<p>[This is the stem.]</p>",
                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                    "type": "clozeassociation",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                null,
                                null
                            ]
                        }
                    }
                }
            }
        ],
        "choicematrix": [
            {
                "name": "Choice Matrix Table",
                "group_reference": "custom-1",
                "defaults": {
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
                        "type": "table"
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
                }
            }
        ],
        "clozedropdown": [
            {
                "name": "Cloze Dropdown",
                "group_reference": "custom-2",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "case_sensitive"
                ],
                "defaults": {
                    "possible_responses": [
                        [
                            "Choice A",
                            "Choice B",
                            "Choice C",
                            "Choice D"
                        ],
                        [
                            "Choice A",
                            "Choice B",
                            "Choice C",
                            "Choice D"
                        ]
                    ],
                    "response_container": {
                        "pointer": "left"
                    },
                    "stimulus": "<p>[This is the stem.]</p>",
                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                    "type": "clozedropdown",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                null,
                                null
                            ]
                        }
                    }
                }
            }
        ],
        "clozetext": [
            {
                "name": "Cloze Text",
                "group_reference": "custom-2",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "description",
                    "response_containers",
                    "multiple_line",
                    "response_container.height",
                    "response_container.width"
                ],
                "defaults": {
                    "stimulus": "<p>[This is the stem.]</p>",
                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                    "type": "clozetext",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                "",
                                ""
                            ]
                        }
                    }
                }
            }
        ],
        "imageclozeassociation": [
            {
                "name": "Label Image Drag & Drop",
                "group_reference": "custom-2",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "description",
                    "case_sensitive"
                ],
                "defaults": {
                    "image": {
                        "src": "//www.learnosity.com/static/img/Blank_US_Map.png"
                    },
                    "possible_responses": [
                        "Choice A",
                        "Choice B",
                        "Choice C"
                    ],
                    "response_container": {
                        "pointer": "left"
                    },
                    "response_positions": [
                        {
                            "x": 0.14,
                            "y": 48
                        },
                        {
                            "x": 35.1,
                            "y": 73.57
                        },
                        {
                            "x": 72.38,
                            "y": 84.58
                        }
                    ],
                    "stimulus": "<p>[This is the stem.]</p>",
                    "type": "imageclozeassociation",
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
                }
            }
        ],
        "graphplotting": [
            {
                "name": "Graph Plotting",
                "group_reference": "custom-3",
                "hidden": [
                    "ui_style"
                ],
                "defaults": {
                    "axis_x": {
                        "draw_labels": true,
                        "show_first_arrow": true,
                        "show_last_arrow": true,
                        "ticks_distance": 1
                    },
                    "axis_y": {
                        "draw_labels": true,
                        "show_first_arrow": true,
                        "show_last_arrow": true,
                        "ticks_distance": 1
                    },
                    "background_image": {
                        "src": ""
                    },
                    "canvas": {
                        "snap_to": "grid",
                        "x_max": 10.4,
                        "x_min": -10.4,
                        "y_max": 10.4,
                        "y_min": -10.4
                    },
                    "grid": {
                        "x_distance": 1,
                        "y_distance": 1
                    },
                    "is_math": true,
                    "stimulus": "<p>[This is the stem.]</p>",
                    "toolbar": {
                        "default_tool": "point",
                        "tools": [
                            "point",
                            "move"
                        ]
                    },
                    "type": "graphplotting",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": []
                        }
                    }
                }
            },
            {
                "name": "Graph default tools",
                "group_reference": "custom-3",
                "attribute_groups": [
                    {
                        "reference": "basic",
                        "name": "Basic"
                    },
                    {
                        "reference": "formatting",
                        "name": "Formatting"
                    },
                    {
                        "reference": "validation",
                        "name": "Validation"
                    }
                ],
                "hidden": [
                    "ui_style"
                ],
                "defaults": {
                    "axis_x": {
                        "draw_labels": true,
                        "show_first_arrow": true,
                        "show_last_arrow": true,
                        "ticks_distance": 1
                    },
                    "axis_y": {
                        "draw_labels": true,
                        "show_first_arrow": true,
                        "show_last_arrow": true,
                        "ticks_distance": 1
                    },
                    "background_image": {
                        "src": ""
                    },
                    "canvas": {
                        "snap_to": "grid",
                        "x_max": 10.4,
                        "x_min": -10.4,
                        "y_max": 10.4,
                        "y_min": -10.4
                    },
                    "grid": {
                        "x_distance": 1,
                        "y_distance": 1
                    },
                    "is_math": true,
                    "stimulus": "<p>[This is the stem.]</p>",
                    "toolbar": {
                        "default_tool": "point",
                        "tools": [
                            "point",
                            "move"
                        ]
                    },
                    "type": "graphplotting",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": []
                        }
                    }
                }
            }
        ],
        "formulaV2": [
            {
                "name": "Add text to maths",
                "group_reference": "custom-3",
                "hidden": [
                    "is_math",
                    "stimulus_review",
                    "description"
                ],
                "defaults": {
                    "is_math": true,
                    "response_containers": [
                        {
                            "width": "60px"
                        }
                    ],
                    "stimulus": "<p>[This is the stem.]</p>",
                    "template": "{{response}}\\text{sq ft}",
                    "type": "formulaV2",
                    "ui_style": {
                        "type": "floating-keyboard"
                    },
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                {
                                    "method": "equivSymbolic",
                                    "options": {
                                        "allowDecimal": false,
                                        "inverseResult": false
                                    },
                                    "value": "\\text{sq ft}"
                                }
                            ]
                        }
                    }
                }
            }
        ]
    }
}';

include_once 'utils/settings-override.php';

$signedRequest = ($request);

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API – Custom Templates</h1>
        <p>Create custom question type templates to suit your organisations authoring needs. Here we've removed the
        <em>search</em> and <em>advanced</em> elements as well as creating 4 custom question template groups.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <div class="learnosity-question-editor"></div>
</div>

<script src="//questioneditor.learnosity.com?v2"></script>
<script>
    var init, questionEditorApp;

    init = <?php echo $signedRequest; ?>;

    questionEditorApp = LearnosityQuestionEditor.init(init);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
