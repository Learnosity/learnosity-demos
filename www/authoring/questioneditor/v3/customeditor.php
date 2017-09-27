<?php

include_once '../../../config.php';
include_once 'includes/header.php';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authoring/questioneditor" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1> Question Editor API - Custom Templates</h1>
        <p>This demo shows the Question Editor API with custom templates. Refer to <a href="https://docs.learnosity.com/authoring/questioneditor/knowledgebase/QETemplateCustomization">Customizing display of question types</a> and <a href="http://docs.learnosity.com/authoring/questioneditor/initialisation">the Initialisation Options docs</a>. <p>
    </div>
</div>

<!--
********************************************************************
*
* Nav for different Question Editor API examples
*
********************************************************************
-->
<div class="section">
    <!-- Container for the question editor api to load into -->
    <div class="my-question-editor"></div>
</div>


<script src="<?php echo $url_questioneditor_v3; ?>"></script>
<script>
var initOptions = {
  "configuration": {},
  "template_defaults": false,
  "question_type_groups": [
    {
      "name": "ELA Grade 3-5",
      "reference": "ELAjr"
    },
    {
      "name": "ELA Grade 6-8",
      "reference": "ELAsr"
    },
    {
      "name": "Math Grade 3-5",
      "reference": "MathJr"
    },
    {
      "name": "Math Grade 6-8",
      "reference": "MathSr"
    },
    {
      "name": "Science Grade 3-5",
      "reference": "SciJr"
    },
    {
      "name": "Science Grade 6-8",
      "reference": "SciSr"
    }
  ],
  "question_type_templates": {
    "fillshape": [
      {
        "name": "Fill Circle",
        "description": "Circle",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden": [
          "is_math",
          "instant_feedback",
          "feedback_attempts",
          "validation.allow_negative_scores",
          "ui_style.fontsize",
          "metadata.acknowledgements",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.distractor_rationale",
          "metadata",
          "possible_responses[ ].image",
          "stimulus_review",
          "img_src",
          "shape"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "type": "fillshape",
          "stimulus": "Fill&nbsp;\\(\\frac{1}{3}\\)&nbsp;of the circle using a total of&nbsp;\\(3\\)&nbsp;different segments.",
          "instant_feedback": true,
          "duplicate_responses": true,
          "shape": {
            "type": "circle",
            "parts": [
              {
                "value": "120"
              },
              {
                "value": "120"
              },
              {
                "value": "120"
              }
            ],
            "data_format": "degree"
          },
          "data_format": "degree",
          "possible_responses": [
            {
              "value": "30",
              "shape": "rectangle"
            },
            {
              "value": "120",
              "shape": "rectangle"
            },
            {
              "value": "15",
              "shape": "rectangle"
            },
            {
              "value": "15",
              "shape": "rectangle"
            },
            {
              "value": "45",
              "shape": "rectangle"
            },
            {
              "value": "20",
              "shape": "rectangle"
            }
          ],
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "method": "countByValue",
              "score": 1,
              "value": "120"
            }
          },
          "is_math": true
        }
      }
    ],
    "choicematrix": [
      {
        "hidden": [
          "multiple_responses",
          "metadata.distractor_rationale_response_level",
          "ui_style.fontsize",
          "ui_style.type",
          "ui_style.horizontal_lines",
          "instant_feedback",
          "feedback_attempts",
          "math_renderer",
          "ui_style.stem_width",
          "ui_style.option_width",
          "ui_style.option_row_title",
          "ui_style.stem_numeration",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints",
          "ui_style.stem_title",
          "is_math",
          "instructor_stimulus",
          "metadata.distractor_rationale"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "is_math": true,
          "options": [
            "True",
            "False"
          ],
          "stems": [
            "Patato",
            "Shoulder",
            "Bisycle",
            "Orange"
          ],
          "stimulus": "<p>Choose whether the spelling of the following word is true or false</p>\n",
          "type": "choicematrix",
          "ui_style": {
            "horizontal_lines": false,
            "type": "table"
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                [
                  1
                ],
                [
                  0
                ],
                [
                  1
                ],
                [
                  0
                ]
              ]
            }
          }
        },
        "description": "Select true or false",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "name": "True or False"
      }
    ],
    "numberlineplot": [
      {
        "name": "Plot on the Numberline",
        "description": "Place points on numberline",
        "image": "//assets.learnosity.com/organisations/6/66236e47-7325-4731-bf86-12b5716ac6de.jpg",
        "group_reference": "MathSr",
        "hidden": [
          "ticks.show",
          "ticks.show_min",
          "is_math",
          "line.left_arrow",
          "toolbar",
          "line.right_arrow",
          "ticks.minor_ticks",
          "ticks.base",
          "ticks.show_max",
          "ticks.distance",
          "line.min",
          "line.max",
          "ui_style.fontsize",
          "ui_style.layout",
          "ui_style.spacing",
          "ui_style.width",
          "stacked",
          "ui_style.height",
          "metadata.distractor_rationale_response_level",
          "labels.show",
          "labels.show_min",
          "points",
          "labels.show_max",
          "instructor_stimulus",
          "metadata.distractor_rationale",
          "ui_style.number_line_margin",
          "instant_feedback",
          "feedback_attempts",
          "math_renderer",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "layout",
          "ticks",
          "labels",
          "toolbar",
          "details",
          "more_options.heading",
          "more_options.divider"
        ],
        "defaults": {
          "stimulus": "<p>Plot the point&nbsp;\\(\\left(6+2\\right)-10\\)</p>\n",
          "stacked": false,
          "stacked_elements": 2,
          "line": {
            "max": 10,
            "min": -10,
            "right_arrow": true,
            "left_arrow": true
          },
          "ticks": {
            "base": "zero-based",
            "distance": 2,
            "minor_ticks": 1,
            "show": true,
            "show_min": true,
            "show_max": true
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "type": "point",
                  "point1": -2
                }
              ]
            }
          },
          "type": "numberlineplot",
          "is_math": true,
          "ui_style": {
            "layout": "horizontal"
          }
        }
      }
    ],
    "highlight": [
      {
        "name": "Image Highlight",
        "description": "Highlight the image",
        "image": "//assets.learnosity.com/organisations/6/027e8499-5a56-4075-82ae-06e336c2d52d.jpg",
        "group_reference": "SciJr",
        "hidden": [
          "ui_style.fontsize",
          "is_math",
          "metadata.distractor_rationale",
          "instructor_stimulus",
          "validation.max_score",
          "line_width",
          "line_color",
          "metadata.sample_answer",
          "metadata.distractor_rationale_response_level",
          "instant_feedback",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "img_src": "",
          "image": {
            "source": "http://media.showmeapp.com/files/192466/pictures/thumbs/691191/last_thumb1360353777.jpg",
            "width": 300,
            "height": 292
          },
          "line_color": [
            "rgba(255, 0, 0, 0.8)"
          ],
          "stimulus": "<p>Draw a circle anywhere on the barrel of this bunsen burner</p>\n",
          "type": "highlight"
        }
      }
    ],
    "imageclozedropdown": [
      {
        "name": "Dropdown Image",
        "description": "Choose from the menus",
        "image": "//assets.learnosity.com/organisations/6/a6c0afb2-6eff-480f-971f-07cf9835614a.jpg",
        "group_reference": "SciSr",
        "hidden": [
          "ui_style.fontsize",
          "is_math",
          "metadata.distractor_rationale",
          "metadata",
          "instructor_stimulus",
          "response_container.pointer",
          "response_container.width",
          "response_container.height",
          "response_container.placeholder",
          "metadata.distractor_rationale_response_level",
          "ui_style.validation_stem_numeration",
          "image.scale",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "aria_labels",
          "metadata.acknowledgements",
          "stimulus_review",
          "response_containers",
          "response_container.input_type",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "image": {
            "src": "https://s-media-cache-ak0.pinimg.com/564x/a5/d1/5b/a5d15b8e236784af3d18af456cf39d21.jpg"
          },
          "possible_responses": [
            [
              "Nucleus",
              "Plasma",
              "Cell"
            ],
            [
              "Tendons",
              "Golgi Body",
              "Tissue"
            ]
          ],
          "response_container": {
            "pointer": "left",
            "width": "115px"
          },
          "response_positions": [
            {
              "x": 62.6,
              "y": 25.14
            },
            {
              "x": 55.69,
              "y": 83.52
            }
          ],
          "stimulus": "<p>Choose the correct answers from the drop down menus.</p>\n",
          "type": "imageclozedropdown",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "Nucleus",
                "Golgi Body"
              ]
            }
          }
        }
      }
    ],
    "tokenhighlight": [
      {
        "name": "Token Highlight",
        "description": "Highlight the correct piece of text",
        "image": "//assets.learnosity.com/organisations/6/a6c0afb2-6eff-480f-971f-07cf9835614a.jpg",
        "group_reference": "SciSr",
        "hidden": [
          "ui_style.fontsize",
          "is_math",
          "metadata",
          "metadata.distractor_rationale",
          "max_selection",
          "metadata.distractor_rationale_response_level",
          "instructor_stimulus",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>Highlight the sentences which are true.&nbsp;</p>\n",
          "template": "<p><span class=\"lrn_token\">Electrons are larger than molecules</span>. <span class=\"lrn_token\">The Atlantic Ocean is the biggest ocean on Earth</span>. <span class=\"lrn_token\">The chemical make up food often changes when you cook it</span>. <span class=\"lrn_token\">Sharks are mammals</span>. <span class=\"lrn_token\">The human body has four lungs</span>. <span class=\"lrn_token\">Atoms are most stable when their outer shells are full</span>. <span class=\"lrn_token\">Filtration separates mixtures based upon their particle size</span>.</p>",
          "tokenization": "custom",
          "type": "tokenhighlight",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                2,
                5,
                6
              ]
            }
          }
        }
      },
      {
        "name": "Highlight",
        "description": "Highlight the sentence",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "hidden": [
          "ui_style.fontsize",
          "is_math",
          "metadata",
          "metadata.distractor_rationale",
          "max_selection",
          "metadata.distractor_rationale_response_level",
          "instructor_stimulus",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>Highlight the sentence with the spelling mistakes.</p>\n",
          "template": "<p><span class=\"lrn_token\">It takes many tributary streams to form a river</span>. <span class=\"lrn_token\">A river grows larger as it collects water from more tributaries along its course</span>. <span class=\"lrn_token\">The grate majorty of rivers eventually flow into a larger body of water, like an ocean, sea, or large lake</span>. <span class=\"lrn_token\">The end of the river is called the mouth</span>.</p>",
          "tokenization": "custom",
          "type": "tokenhighlight",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                2
              ]
            }
          }
        }
      }
    ],
    "numberline": [
      {
        "name": "Drag & Drop - Numberline",
        "description": "Drag the points to the number line",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden": [
          "ticks.show",
          "is_math",
          "metadata",
          "validation.threshold",
          "ui_style.width",
          "line.left_arrow",
          "line.right_arrow",
          "labels",
          "title",
          "labels.frequency",
          "labels.points",
          "labels.show_min",
          "labels.show_max",
          "snap_to_ticks",
          "instructor_stimulus",
          "ticks",
          "ui_style.fontsize",
          "ui_style.height",
          "ui_style.number_line_margin",
          "ui_style.points_distance_x",
          "ui_style.points_distance_y",
          "ui_style.line_position",
          "ui_style.title_position",
          "ui_style.points_box_position",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "labels": {
            "frequency": 1,
            "show_max": true,
            "show_min": true
          },
          "line": {
            "max": 8,
            "min": 0
          },
          "points": [
            "0.5",
            "0.25",
            "1",
            "0.75"
          ],
          "snap_to_ticks": true,
          "stimulus": "<p>Drag and drop the correct points to the number line.</p>\n",
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
                  "point": "1",
                  "position": 8
                },
                {
                  "point": "0.5",
                  "position": 4
                },
                {
                  "point": "0.25",
                  "position": 2
                },
                {
                  "point": "0.75",
                  "position": 6
                }
              ]
            }
          }
        }
      }
    ],
    "chemistry": [
      {
        "name": "Chemistry Formula",
        "description": "Complete the chemical equation",
        "image": "//assets.learnosity.com/organisations/6/027e8499-5a56-4075-82ae-06e336c2d52d.jpg",
        "group_reference": "SciJr",
        "hidden": [
          "is_math",
          "metadata",
          "stimulus_review",
          "validation.alt_responses[ ][ ].value[ ].options.inverseResult",
          "symbols",
          "response_container.height",
          "response_container.width",
          "metadata.distractor_rationale",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "instructor_stimulus",
          "ui_style.fontsize",
          "feedback_attempts",
          "instant_feedback",
          "validation.penalty",
          "handwriting_recognises",
          "text_blocks",
          "numberPad",
          "ui_style.layout"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "is_math": true,
          "stimulus": "<p>What is the chemical equation of Oxygen?</p>\n",
          "symbols": [
            "chemistry",
            "qwerty"
          ],
          "type": "chemistry",
          "ui_style": {
            "type": "block-on-focus-keyboard"
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "method": "equivLiteral",
                  "options": {
                    "inverseResult": false,
                    "ignoreOrder": false
                  },
                  "value": "o_2"
                }
              ]
            }
          }
        }
      }
    ],
    "imageclozeassociation": [
      {
        "name": "Image Drag and Drop",
        "description": "Drag and drop to the image",
        "image": "https://assets.learnosity.com/organisations/1/e006fb25-ecf0-4285-8bed-7cc94144b5eb.jpg",
        "group_reference": "ELAsr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "is_math",
          "metadata.distractor_rationale_response_level",
          "metadata.distractor_rationale",
          "ui_style.possibility_list_position",
          "response_container",
          "instructor_stimulus",
          "response_container.width",
          "response_container.height",
          "image.scale",
          "ui_style.show_drag_handle",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "validation.alt_responses",
          "group_possible_responses",
          "aria_labels",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "image": {
            "src": "//assets.learnosity.com/demos/docs/blank_us_map_v2.png"
          },
          "possible_responses": [
            "Pacific Ocean",
            "Atlantic Ocean"
          ],
          "response_container": {
            "pointer": "left"
          },
          "response_positions": [
            {
              "x": 0,
              "y": 2.09
            },
            {
              "x": 82.91,
              "y": 60.64
            }
          ],
          "stimulus": "Drag and drop the correct responses into the correct area.",
          "type": "imageclozeassociation",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "Pacific Ocean",
                "Atlantic Ocean"
              ]
            }
          }
        },
        "response_containers": [
          {
            "pointer": "left"
          }
        ],
        "is_math": true
      },
      {
        "name": "Cloze Drag drop",
        "description": "The eye",
        "image": "//assets.learnosity.com/organisations/6/027e8499-5a56-4075-82ae-06e336c2d52d.jpg",
        "group_reference": "SciJr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "image.scale",
          "ui_style.show_drag_handle",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints",
          "group_possible_responses",
          "aria_labels"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "image": {
            "src": "//assets.learnosity.com/organisations/130/8e95e725-d92c-4cc0-b033-834f25d883a4.jpeg"
          },
          "possible_responses": [
            "Vitreous Humour",
            "Lens",
            "Ciliary Body",
            "Chloroid",
            "Fovea",
            "Eyelid",
            "Aqueous Humor",
            "Conjunctiva",
            "Cornea",
            "Optic nerve",
            "Iris",
            "Sclera",
            "Retina"
          ],
          "response_container": {
            "width": "70px",
            "wordwrap": true
          },
          "response_positions": [
            {
              "x": 0,
              "y": 52.42
            },
            {
              "x": 47.59,
              "y": 86.56
            },
            {
              "x": 73.9,
              "y": 76.61
            },
            {
              "x": 46.93,
              "y": 1.61
            },
            {
              "x": 9.43,
              "y": 13.17
            },
            {
              "x": 25,
              "y": 1.61
            },
            {
              "x": 66.89,
              "y": 9.41
            },
            {
              "x": 79.61,
              "y": 26.07
            },
            {
              "x": 0,
              "y": 29.84
            },
            {
              "x": 42.54,
              "y": 46.77
            },
            {
              "x": 0,
              "y": 75.27
            },
            {
              "x": 82.02,
              "y": 41.94
            },
            {
              "x": 20.61,
              "y": 86.56
            }
          ],
          "stimulus": "<p>Drag and drop the correct names for the parts of the eye.</p>\n",
          "type": "imageclozeassociation",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "Iris",
                "Vitreous Humour",
                "Optic nerve",
                "Sclera",
                "Conjunctiva",
                "Eyelid",
                "Chloroid",
                "Retina",
                "Aqueous Humor",
                "Lens",
                "Cornea",
                "Fovea",
                "Ciliary Body"
              ]
            }
          },
          "ui_style": {
            "show_drag_handle": false
          }
        }
      }
    ],
    "audio": [
      {
        "name": "Audio",
        "description": "Record an audio",
        "image": "https://assets.learnosity.com/organisations/1/e006fb25-ecf0-4285-8bed-7cc94144b5eb.jpg",
        "group_reference": "ELAsr",
        "hidden": [
          "waveform",
          "ui_style.waveform",
          "ui_style.responsive_layout"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "max_length": 600,
          "stimulus": "<p>Record yourself using the audio recorder. Give an account of who is in your family. Describe them as much as possible in French.</p>\n",
          "type": "audio",
          "is_math": true
        }
      }
    ],
    "hotspot": [
      {
        "name": "Hotspot Science",
        "description": "Click on the right part",
        "image": "//assets.learnosity.com/organisations/6/a6c0afb2-6eff-480f-971f-07cf9835614a.jpg",
        "group_reference": "SciSr",
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "type": "hotspot",
          "stimulus": "<p>Click on the Right Ventricle.</p>\n",
          "image": {
            "source": "//assets.learnosity.com/organisations/130/e3886133-703f-472c-a404-fd172987901e.jpg",
            "width": 450,
            "height": 593
          },
          "areas": [
            [
              {
                "x": 35.6,
                "y": 37.18381112984822
              },
              {
                "x": 13.600000000000001,
                "y": 50.99494097807757
              },
              {
                "x": 12.4,
                "y": 65.1096121416526
              },
              {
                "x": 38.2,
                "y": 61.01180438448567
              },
              {
                "x": 43.8,
                "y": 41.73693086003373
              }
            ],
            [
              {
                "x": 28.599999999999998,
                "y": 8.043844856661044
              },
              {
                "x": 48,
                "y": 23.37268128161889
              },
              {
                "x": 73.6,
                "y": 18.97133220910624
              },
              {
                "x": 77.8,
                "y": 4.097807757166947
              },
              {
                "x": 55.60000000000001,
                "y": 0.45531197301854975
              }
            ],
            [
              {
                "x": 53.400000000000006,
                "y": 62.83305227655986
              },
              {
                "x": 86.8,
                "y": 64.95784148397976
              },
              {
                "x": 84.39999999999999,
                "y": 88.02698145025295
              },
              {
                "x": 65.8,
                "y": 88.33052276559866
              }
            ],
            [
              {
                "x": 15.8,
                "y": 67.99325463743676
              },
              {
                "x": 53.2,
                "y": 57.97639123102867
              },
              {
                "x": 52.6,
                "y": 86.0539629005059
              }
            ]
          ],
          "area_attributes": {
            "global": {
              "fill": "rgba(12, 176, 216, 0.48)",
              "stroke": "rgba(25, 90, 107, 0.83)"
            }
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "3"
              ]
            }
          }
        }
      }
    ],
    "formulaV2": [
      {
        "name": "Fill in the Blanks",
        "description": "Provide the correct answers",
        "image": "//assets.learnosity.com/organisations/6/66236e47-7325-4731-bf86-12b5716ac6de.jpg",
        "group_reference": "MathSr",
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "is_math": true,
          "stimulus": "<p>Fill in the blanks</p>\n",
          "template": "{{response}} + {{response}} = 12",
          "type": "formulaV2",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "method": "equivSymbolic",
                  "options": {
                    "inverseResult": false,
                    "decimalPlaces": 10
                  },
                  "value": "6+6=12"
                }
              ]
            }
          },
          "ui_style": {
            "type": "floating-keyboard"
          }
        }
      },
      {
        "name": "Math Formula",
        "description": "Solve the equation",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "is_math": true,
          "stimulus": "Solve the equation&nbsp;\\(\\frac{1}{2}\\times\\frac{3}{6}=\\)",
          "type": "formulaV2",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "method": "equivSymbolic",
                  "options": {
                    "inverseResult": false,
                    "decimalPlaces": 10
                  },
                  "value": "0.25"
                }
              ]
            }
          },
          "ui_style": {
            "type": "floating-keyboard"
          },
          "symbols": [
            "basic_junior"
          ]
        }
      }
    ],
    "longtext": [
      {
        "name": "Essay",
        "description": "Write an essay",
        "image": "https://assets.learnosity.com/organisations/1/e006fb25-ecf0-4285-8bed-7cc94144b5eb.jpg",
        "group_reference": "ELAsr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.min_height",
          "ui_style.max_height",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.acknowledgements",
          "stimulus_review",
          "is_math",
          "validation",
          "validation.max_score"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>Discuss the theme of love in Romeo and Juliet. If you choose to use quotes please use at least one text formatting option to make them stand out.&nbsp;</p>\n",
          "type": "longtext",
          "is_math": true
        }
      }
    ],
    "clozeformula": [
      {
        "name": "Math - Cloze",
        "description": "Enter the answer",
        "image": "//assets.learnosity.com/organisations/6/66236e47-7325-4731-bf86-12b5716ac6de.jpg",
        "group_reference": "MathSr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "ui_style.response_font_scale",
          "instant_feedback",
          "feedback_attempts",
          "handwriting_recognises",
          "showHints",
          "math_renderer",
          "ui_style.min_width",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "text_blocks",
          "response_container",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>Give an answer in the space provided.</p>\n",
          "template": "<p>Annie has&nbsp;\\(12\\)&nbsp;more weeks before she takes her piano exam. She is going on holidays for&nbsp;\\(2\\)&nbsp;of those weeks. Give a fraction in it's simplest form, showing the amount of time she'll lose out on practice before her exam. {{response}}</p>\n",
          "type": "clozeformula",
          "response_container": {
            "template": ""
          },
          "ui_style": {
            "type": "floating-keyboard"
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                [
                  {
                    "method": "equivLiteral",
                    "value": "\\frac{1}{6}",
                    "options": {
                      "ignoreOrder": false,
                      "inverseResult": false
                    }
                  }
                ]
              ]
            }
          },
          "is_math": true,
          "response_containers": []
        }
      }
    ],
    "clozeassociation": [
      {
        "name": "Cloze Drag & Drop",
        "description": "Drag and drop",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.possibility_list_position",
          "is_math",
          "metadata.distractor_rationale",
          "response_container",
          "ui_style.validation_stem_numeration",
          "ui_style.show_drag_handle",
          "instant_feedback",
          "feedback_attempts",
          "math_renderer",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "response_container",
          "validation.scoring_type",
          "response_container.width",
          "response_container.height",
          "response_container.placeholder",
          "instructor_stimulus",
          "metadata.distractor_rationale_response_level",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "possible_responses": [
            "Hawaii",
            "50",
            "Washington, DC."
          ],
          "response_container": {
            "pointer": "left"
          },
          "stimulus": "<p>Drag and drop the correct answer to the correct gap in the paragraph.</p>\n",
          "template": "<p>The U.S. is a country of {{response}}&nbsp;states covering a vast swath of North America, with Alaska in the northwest and {{response}}&nbsp;extending the nation’s presence into the Pacific Ocean. Major Atlantic Coast cities are New York, a global finance and culture center, and capital {{response}}.&nbsp;</p>\n",
          "type": "clozeassociation",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": []
            }
          },
          "is_math": true
        }
      }
    ],
    "simplechart": [
      {
        "name": "Bar Chart",
        "description": "Bar chart question",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "chart_data": {
            "data": [
              {
                "x": "Annie",
                "y": 0
              },
              {
                "x": "Fred",
                "y": 0
              },
              {
                "x": "John",
                "y": 0
              }
            ],
            "name": "Chart title"
          },
          "stimulus": "<p>Show on the bar chart that Annie has 20 apples, Fred has &nbsp;\\(\\frac{1}{2}\\)&nbsp;of what Annie has&nbsp;and John has the sum of Annie's and Fred's apples.</p>\n",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "x": "Annie",
                  "y": 20
                },
                {
                  "x": "Fred",
                  "y": 10
                },
                {
                  "x": "John",
                  "y": 30
                }
              ]
            }
          },
          "y_axis_label": "Apples",
          "type": "simplechart",
          "is_math": true,
          "ui_style": {
            "chart_type": "bar"
          },
          "max_y_value": 40,
          "snap_to_grid": 5
        }
      },
      {
        "name": "Line Chart",
        "description": "Plot the line",
        "image": "//assets.learnosity.com/organisations/6/66236e47-7325-4731-bf86-12b5716ac6de.jpg",
        "group_reference": "MathSr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "chart_data": {
            "data": [
              {
                "x": "2009",
                "y": 15
              },
              {
                "x": "2010",
                "y": 10
              },
              {
                "x": "2011",
                "y": 0
              }
            ],
            "name": "Sample Data"
          },
          "instant_feedback": true,
          "max_y_value": 50,
          "order_point": "",
          "snap_to_grid": 5,
          "stimulus": "<p>Graph the following table:</p><p>&nbsp;</p><div class=\"row\"><div class=\"col-md-8\"><table class=\"table table-bordered table-striped\"><thead><tr><th scope=\"row\">Year</th><th scope=\"col\">Quantity</th></tr></thead><tbody><tr><th scope=\"row\">2009</th><td>35</td></tr><tr><th scope=\"row\">2010</th><td>25</td></tr><tr><th scope=\"row\">2011</th><td>40</td></tr></tbody></table></div></div>",
          "ui_style": {
            "chart_type": "line"
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                {
                  "x": "2009",
                  "y": 35
                },
                {
                  "x": "2010",
                  "y": 25
                },
                {
                  "x": "2011",
                  "y": 40
                }
              ]
            }
          },
          "x_axis_label": "Quantity",
          "y_axis_label": "Year",
          "type": "simplechart"
        }
      }
    ],
    "clozedropdown": [
      {}
    ],
    "formulaessay": [
      {
        "name": "Math Essay",
        "description": "A Math Essay",
        "image": "//assets.learnosity.com/organisations/6/66236e47-7325-4731-bf86-12b5716ac6de.jpg",
        "group_reference": "MathSr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "instant_feedback",
          "feedback_attempts",
          "response_container",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "response_container.height",
          "response_container.width",
          "response_container.placeholder",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p><strong>Solve the equation for <em>i</em> if <em>i = prt </em>and show the steps involved</strong></p>\n\n<p>\\(p = 2000, r = 8\\%, t = 4\\)</p>\n",
          "type": "formulaessay",
          "ui_style": {
            "default_mode": "math",
            "keyboard_below_response_area": true,
            "fontsize": ""
          },
          "is_math": true
        }
      }
    ],
    "simpleshading": [
      {
        "name": "Simple Shading",
        "description": "Shade",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden": [
          "ui_style.fontsize",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "canvas": {
            "column_count": 3,
            "row_count": 4
          },
          "is_math": true,
          "stimulus": "Shade&nbsp;\\(\\frac{1}{2}\\)of the rectangle.",
          "type": "simpleshading",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": {
                "method": "byCount",
                "value": 6
              }
            }
          }
        }
      }
    ],
    "clozetext": [
      {
        "name": "Cloze Text",
        "description": "Fill in the missing word",
        "image": "https://assets.learnosity.com/organisations/1/e006fb25-ecf0-4285-8bed-7cc94144b5eb.jpg",
        "group_reference": "ELAsr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "instant_feedback",
          "feedback_attempts",
          "response_container.input_type",
          "validation.penalty",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "response_containers",
          "response_container",
          "multiple_line",
          "spellcheck",
          "character_map",
          "response_container.height",
          "response_container.width",
          "validation.scoring_type",
          "response_container.placeholder",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>Complete the following sentence.</p>\n",
          "template": "<p>The families in Romeo and Juliet are called the Montagues and {{response}}&nbsp;</p>\n",
          "type": "clozetext",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "Capulets"
              ]
            }
          }
        }
      }
    ],
    "sortlist": [
      {
        "name": "Sort List",
        "description": "Sort the list in a certain order",
        "image": "https://assets.learnosity.com/organisations/1/e006fb25-ecf0-4285-8bed-7cc94144b5eb.jpg",
        "group_reference": "ELAsr",
        "hidden": [
          "ui_style.fontsize",
          "ui_style.validation_stem_numeration",
          "ui_style.show_drag_handle",
          "instant_feedback",
          "feedback_attempts",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "validation.scoring_type",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "list": [
            "Ireland",
            "Luxembourg",
            "France",
            "Spain"
          ],
          "stimulus": "<p>Sort the following countries in order of size. Largest at the top.</p>\n",
          "type": "sortlist",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                2,
                3,
                0,
                1
              ]
            }
          },
          "is_math": true
        }
      }
    ],
    "mcq": [
      {
        "name": "Multiple Choice Question",
        "description": "Pick one response",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "hidden": [
          "multiple_responses",
          "ui_style.fontsize",
          "ui_style.type",
          "ui_style.columns",
          "ui_style.orientation",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "shuffle_options",
          "math_renderer",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "is_math",
          "instructor_stimulus",
          "metadata.distractor_rationale_response_level",
          "metadata.distractor_rationale",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "is_math": true,
          "options": [
            {
              "label": "Pencil",
              "value": "0"
            },
            {
              "label": "Boat",
              "value": "1"
            },
            {
              "label": "Beautiful",
              "value": "2"
            },
            {
              "label": "Shoe",
              "value": "3"
            }
          ],
          "shuffle_options": true,
          "stimulus": "<p>Which of the follwing is an adjective?</p>\n",
          "type": "mcq",
          "ui_style": {
            "type": "horizontal"
          },
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "2"
              ]
            }
          }
        }
      },
      {
        "name": "Multiple Responses",
        "description": "Choose one or more correct responses",
        "image": "//assets.learnosity.com/organisations/6/86ff1667-37f0-4436-990a-cbabbd334b66.jpg",
        "group_reference": "MathJr",
        "hidden": [
          "multiple_responses",
          "ui_style.fontsize",
          "ui_style.type",
          "ui_style.columns",
          "ui_style.orientation",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "shuffle_options",
          "math_renderer",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "multiple_responses": true,
          "options": [
            {
              "label": "\\(0.5\\)",
              "value": "0"
            },
            {
              "label": "\\(1\\frac{1}{2}\\)",
              "value": "1"
            },
            {
              "label": "\\(\\frac{1}{4}+\\frac{1}{4}\\)",
              "value": "2"
            },
            {
              "label": "\\(0.25+0.35\\)",
              "value": "3"
            }
          ],
          "stimulus": "<p>Select which of the following responses are equivalent to&nbsp;\\(\\frac{1}{2}\\)</p>\n",
          "type": "mcq",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "0",
                "2"
              ]
            }
          },
          "is_math": true,
          "ui_style": {
            "type": "horizontal"
          }
        }
      },
      {
        "name": "MCQ Physics",
        "description": "Choose the correct equation",
        "image": "//assets.learnosity.com/organisations/6/a6c0afb2-6eff-480f-971f-07cf9835614a.jpg",
        "group_reference": "SciSr",
        "hidden": [
          "multiple_responses",
          "ui_style.fontsize",
          "ui_style.type",
          "ui_style.columns",
          "ui_style.orientation",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "shuffle_options",
          "math_renderer",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "options": [
            {
              "label": "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n\t<tbody>\n\t\t<tr>\n\t\t\t<td>1.2 × 10<sup>2</sup>N</td>\n\t\t</tr>\n\t</tbody>\n</table>\n",
              "value": "0"
            },
            {
              "label": "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n\t<tbody>\n\t\t<tr>\n\t\t\t<td>1.2 × 10<sup>3</sup>N</td>\n\t\t</tr>\n\t</tbody>\n</table>\n",
              "value": "1"
            },
            {
              "label": "1.2 × 10<sup>4</sup>N",
              "value": "2"
            },
            {
              "label": "1.2 × 10<sup>5</sup>N",
              "value": "3"
            }
          ],
          "stimulus": "<p>A 1,200-kilogram car traveling at 10. meters per second hits a tree and is brought to rest in 0.10 second. What is the magnitude of the average force acting on the car to bring it to rest?</p>\n",
          "type": "mcq",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": [
                "3"
              ]
            }
          },
          "ui_style": {
            "type": "horizontal"
          }
        }
      },
      {
        "name": "Junior Physics",
        "description": "Physics density",
        "image": "//assets.learnosity.com/organisations/6/027e8499-5a56-4075-82ae-06e336c2d52d.jpg",
        "group_reference": "SciJr",
        "hidden": [
          "multiple_responses",
          "ui_style.fontsize",
          "ui_style.type",
          "ui_style.columns",
          "ui_style.orientation",
          "instant_feedback",
          "feedback_attempts",
          "validation.scoring_type",
          "shuffle_options",
          "math_renderer",
          "validation.penalty",
          "validation.alt_responses",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "stimulus_review",
          "metadata.hints"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "options": [
            {
              "label": "&nbsp;Measuring cylinder",
              "value": "0"
            },
            {
              "label": "Overflow can",
              "value": "1"
            },
            {
              "label": "Callipers",
              "value": "2"
            },
            {
              "label": "Balance",
              "value": "3"
            }
          ],
          "stimulus": "<p>Which one of the following pieces of apparatus would you NOT use in measuring the density of a stone?</p>\n",
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
        }
      }
    ],
    "plaintext": [
      {
        "name": "Essay Junior",
        "description": "A short essay",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "hidden": [
          "is_math",
          "metadata",
          "submit_over_limit",
          "validation.max_score",
          "stimulus_review",
          "placeholder",
          "character_map",
          "metadata.distractor_rationale",
          "metadata.rubric_reference",
          "metadata.sample_answer",
          "metadata.acknowledgements",
          "instructor_stimulus",
          "ui_style.fontsize",
          "ui_style.min_height",
          "ui_style.max_height",
          "max_length",
          "spellcheck"
        ],
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "show_copy": true,
          "show_cut": true,
          "show_paste": true,
          "stimulus": "<p>Write a short account of what you did on your summer holidays.</p>\n",
          "type": "plaintext",
          "is_math": false,
          "max_length": 500
        }
      }
    ],
    "shorttext": [
      {
        "name": "ShortText",
        "description": "Short text",
        "image": "https://assets.learnosity.com/organisations/1/64403e14-095f-4e51-a97a-75cc36f531df.jpg",
        "group_reference": "ELAjr",
        "hidden_sections": [
          "more_options.heading",
          "more_options.divider",
          "layout"
        ],
        "defaults": {
          "stimulus": "<p>How many states are in the United States of America?</p>\n",
          "type": "shorttext",
          "validation": {
            "scoring_type": "exactMatch",
            "valid_response": {
              "score": 1,
              "value": "50"
            }
          },
          "is_math": true
        }
      }
    ]
  },
  "widgetType": "response",
  "rich_text_editor": {
    "type": "wysihtml",
    "toolbar": "bold italic underline clearFormatting numberedList bulletedList math image undo redo"
  },
  "ui": {
    "change_button": true,
    "help_button": true,
    "source_button": false,
    "search_field": false,
    "advanced_group": false,
    "fixed_preview": true,
    "layout": {
      "global_template": "edit_preview"
    },
    "question_tiles": true
  },
    dependencies: {
        questions_api: {
            init_options: {
                beta_flags: {
                    reactive_views: true
                }
            }
        }
    }
};

var editorApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');
</script>


<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
