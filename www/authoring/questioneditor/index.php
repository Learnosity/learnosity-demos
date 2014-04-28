<?php
include_once '../../config.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';
?>

<div class="jumbotron">
    <h1>Question Editor API</h1>
    <p>Our editor. Your item bank platform.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/questioneditorapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="../../reporting/reports/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!--
********************************************************************
*
* Nav for different Question Editor API examples
*
********************************************************************
-->
<div class="alert alert-info" id="example-description"></div>
<ul class="nav nav-tabs" id="nav-questioneditor">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">New Question<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="#" data-type="newQuestion" id="newQuestion">Standard</a></li>
            <li><a href="#" data-type="tileUI" id="tileUI">Question type tiles (beta)</a></li>
            <li><a href="#" data-type="defaults" id="defaults">with defaults</a></li>
            <li><a href="#" data-type="disabled" id="disabled">with certain attributes disabled</a></li>
            <li><a href="#" data-type="defaultsdisabled" id="defaultsdisabled">with certain attributes disabled and defaults</a></li>
            <li><a href="#" data-type="defaultsdisabledgraphing" id="defaultsdisabledgraphing">with certain attributes disabled and defaults (Graphing)</a></li>
            <li><a href="#" data-type="assetuploadexample" id="assetupload">with image gallery asset handler</a></li>
        </ul>
    </li>
    <li><a href="#" data-type="edit" id="edit">Edit Existing Question</a></li>
    <li><a href="#" data-type="feedback" id="feedback">Rubric Feedback</a></li>
    <li><a href="#" data-type="features" id="features">Stimulus Features</a></li>
</ul>

<!-- Container for the question editor api to load into -->
<script src="//questioneditor.learnosity.com"></script>
<div class="learnosity-question-editor"></div>
<script>
    /********************************************************************
    *
    * Set the different initialisation settings based off the
    * example currently being requested
    *
    ********************************************************************/
    var initType,
        initObjects = {
            newQuestion: {
                description: 'Just the standard default editor with no defaults set or attributes disabled.',
                json: {
                    configuration: {
                        questionsApiVersion: 'v2'
                    },
                    widgetType: 'response',
                    ui: {
                        columns: [{
                            tabs: ['edit', 'advanced'],
                            width: '50%'
                        }, {
                            tabs: ['preview', 'layout'],
                            width: '50%'
                        }],
                        fixed_preview: {
                            margin_top: 50
                        }
                    }
                }
            },
            tileUI: {
                description: 'Question type tile thumbnails are templates of commonly used question configuration.',
                json: {
                    configuration: {
                        questionsApiVersion: 'v2'
                    },
                    widgestType: 'response',
                        "question_types": {
                            "association": {},
                            "audio": {},
                            "classification": {},
                            "clozeassociation": {},
                            "clozedropdown": {},
                            "clozeinlinetext": {},
                            "clozetext": {},
                            "choicematrix": {},
                            "formula": {},
                            "graphplotting": {},
                            "highlight": {},
                            "imageclozeassociation": {},
                            "imageclozedropdown": {},
                            "imageclozetext": {},
                            "longtext": {},
                            "mcq": {},
                            "numberline": {},
                            "orderlist": {},
                            "plaintext": {},
                            "shorttext": {},
                            "sortlist": {},
                            "texthighlight": {},
                            "tokenhighlight": {},
                            "audioplayer": {},
                            "counter": {},
                            "sharedpassage": {},
                            "videoplayer": {}
                        },
                        "question_type_templates": {
                            "mcq": [{
                                "name": "MCQ Standard",
                                "description": "Standard Mulitple Choice Question",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": [{
                                        "value": "0",
                                        "label": "[Choice A]"
                                    }, {
                                        "value": "1",
                                        "label": "[Choice B]"
                                    }, {
                                        "value": "2",
                                        "label": "[Choice C]"
                                    }, {
                                        "value": "3",
                                        "label": "[Choice D]"
                                    }],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "mcq"
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/mcqdefault.png",
                                "hidden": ["description", "penalty_score", "is_math"]
                            }, {
                                "name": "MCQ Multi Response",
                                "description": "Multiple Choice Question with multiple responses",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "multiple_responses": true,
                                    "options": [{
                                        "value": "0",
                                        "label": "[Choice A]"
                                    }, {
                                        "value": "1",
                                        "label": "[Choice B]"
                                    }, {
                                        "value": "2",
                                        "label": "[Choice C]"
                                    }, {
                                        "value": "3",
                                        "label": "[Choice D]"
                                    }],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "mcq"
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/mcqmulti.png",
                                "hidden": ["multiple_responses", "description", "penalty_score", "is_math"]
                            }, {
                                "name": "MCQ Block UI",
                                "description": "Multiple Choice Question with Block UI",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": [{
                                        "value": "0",
                                        "label": "[Choice A]"
                                    }, {
                                        "value": "1",
                                        "label": "[Choice B]"
                                    }, {
                                        "value": "2",
                                        "label": "[Choice C]"
                                    }, {
                                        "value": "3",
                                        "label": "[Choice D]"
                                    }],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "mcq",
                                    "ui_style": {
                                        "choice_label": "upper-alpha",
                                        "type": "block"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/mcqblock.png",
                                "hidden": ["description", "penalty_score", "is_math"]
                            }, {
                                "name": "MCQ Hoizontal - 2 Column",
                                "description": "Multiple Choice Question Column format",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": [{
                                        "value": "1",
                                        "label": "[Choice A]"
                                    }, {
                                        "value": "2",
                                        "label": "[Choice B]"
                                    }, {
                                        "value": "3",
                                        "label": "[Choice C]"
                                    }, {
                                        "value": "4",
                                        "label": "[Choice D]"
                                    }],
                                    "stimulus": "[This is the Stem.]",
                                    "type": "mcq",
                                    "ui_style": {
                                        "columns": 2,
                                        "type": "horizontal"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/mcqcolumn.png",
                                "hidden": ["description", "penalty_score", "is_math"]
                            }],
                            "choicematrix": [{
                                "name": "Choice Matrix Table",
                                "description": "Choice Matrix with 2 option columns. Table format",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": ["True", "False"],
                                    "stems": ["[Stem 1]", "[Stem 2]", "[Stem 3]", "[Stem 4]"],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "choicematrix"
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/matrix-table.png",
                                "hidden": ["description", "is_math"]
                            }, {
                                "name": "Choice Matrix Inline",
                                "description": "Choice Matrix with 2 option columns. Inline format",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": ["True", "False"],
                                    "stems": ["[Stem 1]", "[Stem 2]", "[Stem 3]", "[Stem 4]"],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "choicematrix",
                                    "ui_style": {
                                        "type": "inline"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/matrix-inline.png",
                                "hidden": ["description", "is_math"]
                            },

                            {
                                "name": "Choice Matrix with Labels",
                                "description": "Choice Matrix with 2 option columns. Table Format with Stem Numeration",
                                "group_reference": "mcq",
                                "defaults": {
                                    "is_math": true,
                                    "options": ["True", "False"],
                                    "stems": ["[Stem 1]", "[Stem 2]", "[Stem 3]", "[Stem4]"],
                                    "stimulus": "[This is the STEM.]",
                                    "type": "choicematrix",
                                    "ui_style": {
                                        "stem_numeration": "upper-alpha",
                                        "type": "table"
                                    },
                                    "validation": {
                                        "scoring_type": "exactMatch",
                                        "valid_response": {
                                            "score": 1,
                                            "value": [null, null, null]
                                        }
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/matrix-stem.png",
                                "hidden": ["description", "is_math"]
                            }],
                            "longtext": [{
                                "name": "Essay with formatting",
                                "description": "Essay up to 10,000 words which may include text formatting controls.",
                                "group_reference": "writespeak",
                                "defaults": {
                                    "character_map": true,
                                    "is_math": true,
                                    "stimulus": "[This is the Stem.]"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/longtext.png"
                            }],
                            "plaintext": [{
                                "name": "Essay cut, copy & paste controls",
                                "description": "Essay up to 10,000 words does not include text formatting controls.",
                                "group_reference": "writespeak",
                                "defaults": {
                                    "character_map": true,
                                    "is_math": true,
                                    "show_copy": true,
                                    "show_cut": true,
                                    "show_paste": true,
                                    "stimulus": "[This is the STEM.]"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/plaintext.png"
                            }],
                            "shorttext": [{
                                "name": "Short Text",
                                "description": "Short answer respones.",
                                "group_reference": "writespeak",
                                "defaults": {
                                    "is_math": true,
                                    "stimulus": "[This is the STEM.]",
                                    "type": "shorttext"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/shorttext.png"
                            }],
                            "audio": [{
                                "name": "Audio - Block UI",
                                "description": "Audio response with Block UI.",
                                "group_reference": "writespeak",
                                "defaults": {
                                    "is_math": true,
                                    "max_length": 600,
                                    "overwrite_warning": true,
                                    "recording_cue": true,
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "audio"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/audio-block.png"
                            }, {
                                "name": "Audio - Button UI",
                                "description": "Audio response with Button UI.",
                                "group_reference": "writespeak",
                                "defaults": {
                                    "is_math": true,
                                    "max_length": 600,
                                    "overwrite_warning": true,
                                    "recording_cue": true,
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "audio",
                                    "ui_style": {
                                        "type": "button"
                                    }
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/audio-button.png"
                            }],
                            "clozetext": [{
                                "name": "Cloze Text",
                                "description": "Fill in the blanks.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "stimulus": "[This is the STEM.]",
                                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                                    "type": "clozetext"
                                },
                                "hidden": ["description"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/clozet.png"
                            }],
                            "clozedropdown": [{
                                "name": "Cloze Drop Down",
                                "description": "Fill in the blanks with drop down menus.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "possible_responses": [
                                        ["Choice A", "Choice B", "Choice C", "Choice D"],
                                        ["Choice A", "Choice B", "Choice C", "Choice D"]
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    },
                                    "stimulus": "[This is the STEM.]",
                                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                                    "type": "clozedropdown"
                                },
                                "hidden": ["description"]
                            }],
                            "clozeassociation": [{
                                "name": "Cloze Drag & Drop",
                                "description": "Fill in the blanks drag and drop.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "possible_responses": [
                                        ["Choice A"],
                                        ["Choice B"]
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    },
                                    "stimulus": "[This is the STEM.]",
                                    "template": "Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                                    "type": "clozeassociation"
                                },
                                "hidden": ["description"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/cloze_dd.png"
                            }],
                            "imageclozetext": [{
                                "name": "Label Image",
                                "description": "Fill in the blanks text box on and image.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "img_src": "//www.learnosity.com/static/img/Blank_US_Map.png",
                                    "response_container": {
                                        "pointer": "left"
                                    },
                                    "response_positions": [{
                                        "x": 0.14,
                                        "y": 48
                                    }, {
                                        "x": 35.1,
                                        "y": 73.57
                                    }, {
                                        "x": 72.38,
                                        "y": 84.58
                                    }],
                                    "stimulus": "<p>[This is the STEM]</p>\n",
                                    "type": "imageclozetext"
                                },
                                "hidden": ["description"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/image_cloze.png"
                            }],
                            "imageclozedropdown": [{
                                "name": "Label Image Drop Down",
                                "description": "Fill in the blanks image with drop down menus.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "img_src": "//www.learnosity.com/static/img/Blank_US_Map.png",
                                    "response_positions": [{
                                        "x": 0.14,
                                        "y": 48
                                    }, {
                                        "x": 35.1,
                                        "y": 73.57
                                    }, {
                                        "x": 72.38,
                                        "y": 84.58
                                    }],
                                    "stimulus": "<p>[This is the STEM]</p>\n",
                                    "type": "imageclozedropdown",
                                    "possible_responses": [
                                        ["Choice A", "Choice B", "Choice C"],
                                        ["Choice A", "Choice B", "Choice C"],
                                        ["Choice A", "Choice B", "Choice C"]
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    }
                                },
                                "hidden": ["description"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/image_dropdown.png"
                            }],
                            "imageclozeassociation": [{
                                "name": "Label Image Drag & Drop",
                                "description": "Fill in the blanks on image with Drag & Drop.",
                                "group_reference": "cloze",
                                "defaults": {
                                    "img_src": "//www.learnosity.com/static/img/Blank_US_Map.png",


                                    "response_positions": [{
                                        "x": 0.14,
                                        "y": 48
                                    }, {
                                        "x": 35.1,
                                        "y": 73.57
                                    }, {
                                        "x": 72.38,
                                        "y": 84.58
                                    }],
                                    "stimulus": "<p>[This is the STEM]</p>\n",
                                    "type": "imageclozeassociation",
                                    "possible_responses": [
                                        ["Choice A"],
                                        ["Choice B"],
                                        ["Choice C"]
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    }
                                },
                                "hidden": ["description"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/image_association.png"
                            }],
                            "association": [{
                                "name": "Match List",
                                "description": "Match reponses with list",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "possible_responses": ["[Choice A]", "[Choice B]", "[Choice C]"],
                                    "stimulus": "<p>[This is the STEM.]</p>\n",
                                    "stimulus_list": ["[Stem 1]", "[Stem 2]", "[Stem 3]"],
                                    "type": "association"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/association.png"
                            }],
                            "classification": [{
                                "name": "Classification - 1 row",
                                "description": "Drag and drop responses into grid with 2 columns and 1 row",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "possible_responses": ["[Choice A]", "[Choice B]", "[Choice C]", "[Choice D]"],
                                    "stimulus": "<p>[This is the STEM.]</p>\n",
                                    "type": "classification",
                                    "ui_style": {
                                        "column_count": 2,
                                        "column_titles": ["COLUMN 1", "COLUMN 2"],
                                        "row_count": 1
                                    }
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/classification.png"
                            }, {
                                "name": "Classification - 2 rows",
                                "description": "Drag and drop response into grid with 2 columns and 2 rows",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "possible_responses": ["[Choice A]", "[Choice B]", "[Choice C]", "[Choice D]"],
                                    "stimulus": "<p>[This is the STEM.]</p>\n",
                                    "type": "classification",
                                    "ui_style": {
                                        "column_count": 2,
                                        "column_titles": ["COLUMN 1", "COLUMN 2"],
                                        "row_count": 2,
                                        "row_titles": ["ROW 1", "ROW 2"]
                                    }
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/classification2.png"
                            }],
                            "sortlist": [{
                                "name": "Sort List",
                                "description": "Sort list by dragging items to the Target area into the correct order",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "list": ["[Choice A]", "[Choice B]", "[Choice C]", "[Choice D]"],
                                    "stimulus": "<p>[This is the STEM.]</p>\n",
                                    "type": "sortlist"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/sort-list.png"
                            }],

                            "orderlist": [{
                                "name": "Order List - Default",
                                "description": "List of Items to be arranged into the correct order.",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "list": ["[Choice A]", "[Choice B]", "[Choice C]", "[Choice D]"],
                                    "stimulus": "[This is the Stem.]",
                                    "type": "orderlist"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "//assets.learnosity.com/questiontypes/tiles/order_list.png"
                            }, {
                                "name": "Order List - List UI",
                                "description": "List of Items to be arranged into the correct order.",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "list": ["[Choice A]", ["Choice B"], "[Choice C]", ["Choice D"]],
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "orderlist",
                                    "ui_style": {
                                        "type": "list"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/order.png",
                                "hidden": ["description", "is_math"]
                            }, {
                                "name": "Order Paragraphs",
                                "description": "Order Paragraphs.",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "list": ["[Choice A] R<span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice B]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice C]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice D]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>"],
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "orderlist",
                                    "ui_style": {
                                        "type": "list"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/order-paragraph.png",
                                "hidden": ["description", "is_math"]
                            }, {
                                "name": "Order Sentences",
                                "description": "Order Sentences.",
                                "group_reference": "match",
                                "defaults": {
                                    "is_math": true,
                                    "list": ["[Choice A] R<span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice B]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice C]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>", "[Choice D]&nbsp;<span>&nbsp;R</span><span>isus dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae.</span>"],
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "orderlist",
                                    "ui_style": {
                                        "type": "inline"
                                    }
                                },
                                "image": "//assets.learnosity.com/questiontypes/tiles/order-sentence.png",
                                "hidden": ["description", "is_math"]
                            }],
                            "formula": [{
                                "name": "Math Formula",
                                "description": "Enter complex math. Default response box",
                                "group_reference": "math",
                                "defaults": {
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "formula",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/formula.png"
                            }, {
                                "name": "Math Formula Fraction",
                                "description": "Enter complex math. Fraction Response boxes",
                                "group_reference": "math",
                                "defaults": {
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "template": "\\frac{{{response}}}{{{response}}}",
                                    "type": "formula",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/fraction.png"
                            }, {
                                "name": "Math Formula Multiple",
                                "description": "Enter complex math. Add multiple response boxes",
                                "group_reference": "math",
                                "defaults": {
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "template": "{{response}} + {{response}} =",
                                    "type": "formula",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/multiple.png"
                            }],
                            "numberline": [{
                                "name": "Numberline",
                                "group_reference": "math",
                                "defaults": {
                                    "labels": {
                                        "frequency": 1,
                                        "show_max": true,
                                        "show_min": true
                                    },
                                    "line": {
                                        "max": 10,
                                        "min": 0
                                    },
                                    "points": ["[Choice A]", "[Choice B]", "[Choice C]"],
                                    "snap_to_ticks": true,
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "ticks": {
                                        "distance": "1",
                                        "show": true
                                    },
                                    "type": "numberline",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/numberline.png"
                            }],
                            "graphplotting": [{
                                "name": "Graph with Point Tool ",
                                "description": "10 x 10 unit quadrants with Point tool.",
                                "group_reference": "math",
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
                                    "type": "graphplotting",
                                    "toolbar": {
                                        "default_tool": "point",
                                        "tools": ["point", "move"]
                                    },
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "is_math": true

                                },
                                "hidden": ["description", "is_math", "mode"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/graph.png"
                            }, {
                                "name": "Graph default tools",
                                "description": "10 x 10 unit quadrants with all drawing tools.",
                                "group_reference": "math",
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
                                    "type": "graphplotting",
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math", "mode"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/graph2.png"
                            }, {
                                "name": "Graph - larger grid lines",
                                "description": "10 x 10 unit quadrants with grid lines set to 2 with all drawing tools.",
                                "group_reference": "math",
                                "defaults": {
                                    "axis_x": {
                                        "draw_labels": true,
                                        "show_first_arrow": true,
                                        "show_last_arrow": true,
                                        "ticks_distance": 2
                                    },
                                    "axis_y": {
                                        "draw_labels": true,
                                        "show_first_arrow": true,
                                        "show_last_arrow": true,
                                        "ticks_distance": 2
                                    },
                                    "canvas": {
                                        "snap_to": "grid",
                                        "x_max": 10.4,
                                        "x_min": -10.4,
                                        "y_max": 10.4,
                                        "y_min": -10.4
                                    },
                                    "grid": {
                                        "x_distance": 2,
                                        "y_distance": 2
                                    },

                                    "type": "graphplotting",
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math", "mode"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/graph3.png"
                            }, {
                                "name": "1st Quadrant Graph",
                                "description": "10 x 10 1st quadrant graph with all drawing tools.",
                                "group_reference": "math",
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
                                    "canvas": {
                                        "snap_to": "grid",
                                        "x_max": 10.4,
                                        "x_min": -0.4,
                                        "y_max": 10.4,
                                        "y_min": -0.4
                                    },
                                    "grid": {
                                        "x_distance": 1,
                                        "y_distance": 1
                                    },
                                    "type": "graphplotting",
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "is_math": true
                                },
                                "hidden": ["description", "is_math", "mode"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/graph4.png"
                            }],
                            "highlight": [{
                                "name": "Highlight Image",
                                "group_reference": "highlight",
                                "defaults": {
                                    "img_src": "",
                                    "is_math": true,
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "type": "highlight"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/image_highlight.png"
                            }],
                            "texthighlight": [{
                                "name": "Text Highlight",
                                "description": "The user can drag the cursor across the text which will be highlighted.",
                                "group_reference": "highlight",
                                "defaults": {
                                    "stimulus": "<p>[This is the Stem.]</p>\n",
                                    "template": "Risus et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.",
                                    "tokenization": "custom",
                                    "type": "texthighlight"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/text_highlight.png"
                            }],
                            "tokenhighlight": [{
                                "name": "Token Highlight",
                                "description": "User can click words/sentences/paragraphs to be highlighted",
                                "group_reference": "highlight",
                                "defaults": {
                                    "stimulus": "<p>[This is the Stem.]</p>",
                                    "template": "<p>Risus et tincidunt turpis facilisis.</p><p>Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. dignissim, et tincidunt turpis facilisis.</p><p>Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.</p>",
                                    "tokenization": "paragraph",
                                    "type": "tokenhighlight"
                                },
                                "hidden": ["description", "is_math"],
                                "image": "http://assets.learnosity.com/questiontypes/tiles/token.png"
                            }]
                        },
                        "question_type_groups": [{
                            "reference": "mcq",
                            "name": "Mulitple Choice"
                        }, {
                            "reference": "cloze",
                            "name": "Fill in the Blanks (Cloze)"
                        }, {
                            "reference": "writespeak",
                            "name": "Written & Spoken"
                        }, {
                            "reference": "match",
                            "name": "Classify, Match & Order"
                        }, {
                            "reference": "math",
                            "name": "Math & Cartesian Graphing"
                        }, {
                            "reference": "highlight",
                            "name": "Highlight"
                        }],
                        "ui": {
                            "question_tiles": true
                        }
                }
            },
            defaults: {
                description: 'In this example we\'re defaulting the editor to allow '
                    + 'editing of only one question type. We\'re also setting certain '
                    + 'attributes before the author sees it, like <em>instant_feedback</em> '
                    + 'being set to true, a default <em>Stimulus</em> being set etc.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    question_types: {
                        association: {
                            defaults: {
                                "type": "association",
                                "feedback_attempts": 5,
                                "instant_feedback": true,
                                "stimulus": "<p>Question stimulus goes here.</p>",
                                "validation": {
                                    "partial_scoring": true,
                                    "penalty_score": -0.5,
                                    "valid_score": 1
                                    }
                            }
                        }
                    },
                    widgetType: 'response'
                }
            },
            disabled: {
                description: 'In this example we\'re hiding certain '
                + 'attributes to demonstrate the flexibility you can provide to authors.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    question_types: {
                        clozetext: {
                            hidden: [
                                "character_map", "description", "feedback_attempts",
                                "instant_feedback", "is_math", "max_length",
                                "metadata", "response_container", "spellcheck", "stimulus_review"
                            ]
                        }
                    },
                    widgetType: 'response'
                }
            },
            defaultsdisabled: {
                description: 'In this example we\'re defaulting the editor to allow '
                + 'editing of only one question type. We\'re also hiding certain '
                + 'attributes to demonstrate the flexibility you can provide to authors.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    question_types: {
                        clozeassociation: {
                            hidden: [ "description", "feedback_attempts", "instant_feedback",
                                "is_math", "max_length", "metadata", "response_container",
                                "spellcheck", "stimulus_review"
                            ],
                            defaults : {
                                possible_responses: ["Answer 1", "Answer 2"],
                                template: "<p>Here is a nice template of a Close Text question. It is nice and "
                                    + "easy to put a {{response}} in.</p><p>Here is another {{response}} container.</p>"
                            }
                        }
                    },
                    widgetType: 'response'
                }
            },
            defaultsdisabledgraphing: {
                description: 'In this example we\'re defaulting the editor to allow '
                + 'very simple templating of Graphing Questions. We\'re also hiding certain '
                + 'attributes to demonstrate the flexibility you can provide to authors.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    widgetType: 'response',
                    question_types: {
                        graphplotting: {
                            hidden: [ "description", "feedback_attempts", "instant_feedback",
                                "is_math", "grid", "axis_x", "axis_y",
                                "draw_zero", "stimulus_review", "annotation", "mode","ui_style"
                            ],
                            defaults : {
                                annotation : {
                                    "label_right": "\\(X\\)",
                                    "label_top": "\\(Y\\)"
                                },
                                axis_x : {
                                    "draw_labels": true,
                                    "show_first_arrow": true,
                                    "show_last_arrow": true,
                                    "ticks_distance": 1
                                },
                                axis_y : {
                                    "draw_labels": true,
                                    "show_first_arrow": true,
                                    "show_last_arrow": true,
                                    "ticks_distance": 1
                                },
                                canvas : {
                                    "show_hover_position": true,
                                    "snap_to": "grid",
                                    "x_max": 10.5,
                                    "x_min": -10.5,
                                    "y_max": 10.5,
                                    "y_min": -10.5
                                } ,
                                draw_zero: true,
                                grid : {
                                    "x_distance": 1,
                                    "y_distance": 1
                                },
                                instant_feedback : true,
                                is_math : true,
                                stimulus : "Enter the question stimulus here.",
                                "validation": {
                                    "penalty_score": "0",
                                    "valid_responses": [],
                                    "valid_score": "1"
                                }
                            }
                        }
                    },
                ui: {
                        columns: [
                            {
                                tabs: ["edit", "advanced"],
                                width: "40%"
                            },
                            {
                                tabs: ["preview", "layout"],
                                width: "60%"
                            }
                        ],
                        fixed_preview: {
                            margin_top: 45
                        }
                    }
                }
            },
            assetuploadexample: {
                description: 'Example of the custom asset uploader.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    widgetType: 'response',
                    question_types: {
                        imageclozeassociation: {
                            defaults: {
                                "img_src": "//upload.wikimedia.org/wikipedia/commons/5/5f/Sydney_1932.jpg",
                                "possible_responses": ["North Sydney", "Harbour Bridge", "The Rocks"],
                                "response_container": {"pointer": "left"},
                                "response_positions": [{
                                    "x": 45,
                                    "y": 42.47
                                    }, {
                                    "x": 12.22,
                                    "y": 64.2
                                    }, {
                                    "x": 45,
                                    "y": 24.94
                                    }]
                            }
                        }
                    },
                    assetRequest: function(mediaRequested, returnType, callback) {
                        if (mediaRequested === 'image') {
                            var $modal = $('.modal.img-upload'),
                                $images = $('.asset-img-gallery img'),
                                imgClickHandler = function () {
                                    if (returnType === 'HTML') {
                                        callback('<img src="' + $(this).data('img') + '"/>');
                                    } else {
                                        callback($(this).data('img'));
                                    }
                                    $modal.modal('hide');
                                };
                            $images.on('click', imgClickHandler);
                            $modal.modal({
                                backdrop: 'static'
                            }).on('hide', function () {
                                $images.off('click', imgClickHandler);
                            });
                        }
                    },
                    ui: {
                        columns: [
                            {
                                tabs: ["edit", "advanced"],
                                width: "50%"
                            },
                            {
                                tabs: ["preview", "layout"],
                                width: "50%"
                            }
                        ],
                        fixed_preview: {
                            margin_top: 45
                        }
                    }
                }
            },
            edit: {
                description: 'In this example we\'re editing a previously created question.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    question_types : ["imageclozeassociation"],
                    widget_json: {
                        "type": "imageclozeassociation",
                        "img_src": "//www.learnosity.com/static/img/Blank_US_Map.png",
                        "possible_responses": ["Oregon", "California", "Texas", "Florida"],
                        "response_positions": [
                            {
                                "x": 71.25,
                                "y": 79.88
                            }, {
                                "x": 0,
                                "y": 15.68
                            }, {
                                "x": 35.53,
                                "y": 70.41
                            }, {
                                "x": 0,
                                "y": 44.08
                            }
                        ],
                        "validation": {
                            "partial_scoring": true,
                            "penalty_score": -0.5,
                            "valid_responses": [
                                ["Florida"],
                                ["Oregon"],
                                ["Texas"],
                                ["California"]
                            ],
                            "valid_score": 1
                        }
                    },
                    widgetType: 'response'
                }
            },
            feedback: {
                description: 'For teacher and grader feedback/rubrics. Default '
                    + 'editor with an existing rating feedback type.',
                json: {
                    configuration: {
                        questionsApiVersion: 'v2'
                    },
                    widget_json: {
                        'options': [
                            {
                                'value': '1',
                                'label': '25%',
                                'label_tooltip': 'Unsatisfactory',
                                'tint': 'red',
                                'description': 'Poor effort.'
                            },
                            {
                                'value': '2',
                                'label': '50%',
                                'label_tooltip': 'Average',
                                'tint': 'orange',
                                'description': 'You only just passed, more effort is required.'
                            },
                            {
                                'value': '3',
                                'label': '75%',
                                'label_tooltip': 'Credit',
                                'tint': 'blue',
                                'description': 'You responded well to all questions.'
                            },
                            {
                                'value': '4',
                                'label': '100%',
                                'label_tooltip': 'Perfect',
                                'tint': 'green',
                                'description': 'You answered everything correctly!'
                            }
                        ],
                        'type': 'rating'
                    },
                    widget_type: 'feedback'
                }
            },
            features: {
                description: 'Stimulus Features like Audio and Video. Default '
                    + 'editor with an existing video feature.',
                json: {
                    configuration: {
                        questionsApiVersion: "v2"
                    },
                    widget_json: {
                        "src": "//www.youtube.com/watch?feature=player_detailpage&amp;v=flL7M36QszA",
                        "type": "videoplayer"
                    },
                    widget_type: 'feature'
                }
            }
        };

    function changeExample(evt) {

        var type = $(this).attr('data-type');
        evt.preventDefault();
        $('#nav-questioneditor').find('li').removeClass('active');
        if ($(this).closest('ul').hasClass('dropdown-menu')) {
            $(this).closest('li.dropdown').addClass('active');
        } else {

            $(this).parent().addClass('active');
        }
        if (typeof type !== 'undefined') {
            window.location.hash = $(this).attr('id');
            currentType = initObjects[type];
            $('#example-description').html(currentType.description);
            LearnosityQuestionEditor.init(currentType.json);
        }
    }

    (function($) {
        $('#nav-questioneditor').find('a').on('click', changeExample);
        var hashString = window.location.hash;
        if(hashString !== "") {
            $(hashString).trigger('click');
        } else {
            $('#newQuestion').trigger('click');
        }
    }(jQuery));
</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
