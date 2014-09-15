<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => $studentid
);

// retrieve responseId from GET parameter and switch to review state if questions have been submitted
if (isset($_GET['state']) && $_GET['state'] === 'review') {
    $state =  'review';
    $uniqueResponseIdSuffix = $_GET['uniqueResponseIdSuffix'];
} else {
    $state =  'initial';
    $uniqueResponseIdSuffix = Uuid::generate();
}

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "submit_practice",
    "state": "'.$state.'",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "questions": [
        {
            "response_id": "demo1-'.$uniqueResponseIdSuffix.'",
            "type": "mcq",
            "options" : [
                {"value" : "red"    , "label" : "Red"},
                {"value" : "violet"  , "label" : "Violet"},
                {"value" : "blue"   , "label" : "Blue"},
                {"value" : "orange" , "label" : "Orange"}
            ],
            "valid_responses" : [
                {"value" : "violet", "score": 1}
            ],
            "instant_feedback" : true,
            "multiple_responses": false,
            "penalty_score": -1
        },
        {
            "response_id": "demo1b-'.$uniqueResponseIdSuffix.'",
            "type": "mcq",
            "options": [
                {"label": "Dublin", "value": "1"},
                {"label": "Bristol", "value": "2"},
                {"label": "Liverpool", "value": "3"},
                {"label": "London", "value": "4"}
            ],
            "ui_style": {
                "type": "block",
                "columns": 1,
                "choice_label": "upper-alpha"
            },
            "valid_responses": [
                { "value":"4"}
            ],
            "is_math": true,
            "instant_feedback": true
        },
        {
            "response_id": "demo2-'.$uniqueResponseIdSuffix.'",
            "type": "mcq",
            "description" : "The <strong>student</strong> needs to say which of these are state capitals.",
            "options": [
                {"label": "Wilmington, NC", "value": "wilmington"},
                {"label": "Trenton, NJ", "value": "trenton"},
                {"label": "Topeka, KS", "value": "topeka"},
                {"label": "St. Louis, MO", "value": "stlouis"}
            ],
            "valid_responses": [
                { "value":"trenton", "score": "1" },
                { "value":"topeka", "score": "1"}
            ],
            "instant_feedback": true,
            "feedback_attempts": 2,
            "multiple_responses": true
        },
        {
            "response_id": "demo3-'.$uniqueResponseIdSuffix.'",
            "type": "shorttext",
            "description" : "The <strong>student</strong> needs to name the mayor of New York City.<br>Valid Responses:<dl><dt>Michael Bloomberg</dt><dd>Score 1</dd></dl>",
            "valid_responses": [
                {"value": "Michael Bloomberg", "score":1},
                {"value": "Bloomberg", "score":0.5},
                {"value": "Rudy Giuliani", "score":0.1},
                {"value": "Giuliani", "score":0.1}
            ],
            "case_sensitive": false,
            "instant_feedback": true
        },
        {
            "response_id": "demo4-'.$uniqueResponseIdSuffix.'",
            "type": "longtext",
            "description": "The student needs to write a brief explanation of cellular mitosis.",
            "max_length": 400,
            "character_map": true
        },
        {
            "response_id": "demo5-'.$uniqueResponseIdSuffix.'",
            "type": "plaintext",
            "description": "The student needs to write a haiku poem in German.",
            "show_copy": true,
            "show_cut": true,
            "show_paste": true,
            "character_map": ["Ä", "É", "Ö", "Ü", "ä", "é", "ö", "ü", "ß"],
            "max_length": 20,
            "show_word_count": "always",
            "show_word_limit": "always"
        },
        {
            "response_id": "demo6-'.$uniqueResponseIdSuffix.'",
            "type": "audio",
            "description": "The student needs to speak about a typical day in their life."
        },
        {
            "response_id": "demo7-'.$uniqueResponseIdSuffix.'",
            "type": "clozetext",
            "description" : "The student needs to fill in the blanks ",
            "template" : "<table class=\"table table-bordered\"><thead><tr><th><strong>Multiply</strong></th><th><strong>_ x 1</strong></th><th><strong>_ x 2</strong></th><th><strong>_ x 3</strong></th><th><strong>_ x 4</strong></th><th><strong>_ x 5</strong></th></tr></thead><tbody><tr><td><strong>1 x _</strong></td><td>{{response}}</td><td>2</td><td>3</td><td>4</td><td>5</td></tr><tr><td><strong>2 x _</strong></td><td>2</td><td>{{response}}</td><td>6</td><td>8</td><td>10</td></tr><tr><td><strong>3 x _</strong></td><td>3</td><td>6</td><td>{{response}}</td><td>12</td><td>15</td></tr><tr><td><strong>4 x _</strong></td><td>4</td><td>8</td><td>12</td><td>{{response}}</td><td>20</td></tr><tr><td><strong>5 x _</strong></td><td>5</td><td>10</td><td>15</td><td>20</td><td>{{response}}</td></tr></tbody></table>",
            "instant_feedback" : true,
            "case_sensitive" : false,
            "max_length" : 2,
            "valid_responses" : [
                [
                    {"value" : "1"}
                ], [
                    {"value" : "4"}
                ], [
                    {"value" : "9"}
                ], [
                    {"value" : "16"}
                ], [
                    {"value" : "25"}
                ], [
                    {"value" : "36"}
                ]
            ]
        },
        {
            "response_id": "demo8-'.$uniqueResponseIdSuffix.'",
            "type": "clozedropdown",
            "description" : "The student needs to select the correct response for each blank ",
            "template" : "<p>“It’s all clear,’ he {{response}}. “Have you the chisel and the bags? Great Scott! Jump, Archie, jump, and I’ll swing for it!’</p><p>Sherlock {{response}} had sprung out and seized the {{response}} by the collar. The other dived down the hole, and I heard the sound of {{response}} cloth as Jones clutched at his skirts. The light flashed upon the barrel of a revolver, but Holmes’ {{response}} came down on the man’s wrist, and the pistol {{response}} upon the stone floor.</p>",
            "instant_feedback" : true,
            "possible_responses" : [ ["whispered", "sprinted", "joked"], ["Homes", "holmes", "Holmes"], ["acquaintance", "intruder", "shopkeeper"], ["burning", "departing", "rending", "broken"], ["revolver","hunting crop"], ["rattled", "clinked", "spilt"] ],
            "valid_responses" : [
                [
                    {"value" : "whispered"}
                ], [
                    {"value" : "Holmes"}
                ], [
                    {"value" : "intruder"}
                ], [
                    {"value" : "rending"}
                ], [
                    {"value" : "hunting crop"}
                ], [
                    {"value" : "clinked"}
                ]
            ]
        },
        {
            "response_id": "demo9-'.$uniqueResponseIdSuffix.'",
            "type": "clozeassociation",
            "template": "<p> <strong>(a)</strong> \\\(5{{g}^{2}}{{h}^{4}}\\\times \\\text{-}4{{g}^{3}}{{h}^{3}}\\\) = {{response}}</p><p> <strong>(b)</strong> \\\(\\\text{-}36{{p}^{8}}{{t}^{9}}\\\div \\\text{-}9{{p}^{10}}{{t}^{3}}\\\) = {{response}}</p>",
            "possible_responses": ["\\\(20{{g}^{5}}{{h}^{7}}\\\)", "\\\(\\\text{-}20{{g}^{5}}{{h}^{7}}\\\)", "\\\(20{{g}^{8}}{{h}^{9}}\\\)", "\\\(\\\text{-}20{{g}^{8}}{{h}^{9}}\\\)", "\\\(4{{t}^{6}}{{p}^{2}}\\\)", "\\\(\\\dfrac{4{{t}^{6}}}{{{p}^{2}}}\\\)", "\\\(\\\dfrac{4{{p}^{2}}}{{{t}^{6}}}\\\)", "\\\(\\\dfrac{27{{t}^{6}}}{{{p}^{2}}}\\\)"],
            "description": "<p>Simplify the following, expressing your answers with positive indices.</p>",
            "is_math": true,
            "valid_responses": [
            [{
                "value": "\\\(\\\text{-}20{{g}^{5}}{{h}^{7}}\\\)"
            }],
            [{
                "value": "\\\(\\\dfrac{4{{t}^{6}}}{{{p}^{2}}}\\\)"
            }]
            ],
            "metadata": {
                "sample_answer": "<p><strong>(a)</strong> \\\(5{{g}^{2}}{{h}^{4}}\\\times \\\text{-}4{{g}^{3}}{{h}^{3}} \\\)</p><p> \\\(=5\\\times (\\\text{-}4){{g}^{2+3}}{{h}^{4+3}} \\\)</p><p> \\\( =\\\text{-}20{{g}^{5}}{{h}^{7}}\\\)</p><p><strong>(b)</strong> \\\(\\\text{-}36{{p}^{8}}{{t}^{9}}\\\div \\\text{-}9{{p}^{10}}{{t}^{3}}\\\) </p><p> \\\(=\\\dfrac{\\\text{-}36{{t}^{9-3}}}{\\\text{-}9{{p}^{10-8}}} \\\)  </p><p> \\\(=\\\dfrac{4{{t}^{6}}}{{{p}^{2}}}\\\)</p>"
            }
        },
        {
            "response_id": "demo11-'.$uniqueResponseIdSuffix.'",
            "type": "highlight",
            "description": "The student needs to mark one of the flower\'s anthers in the image.",
            "img_src": "//www.learnosity.com/static/img/flower.jpg",
            "line_color": "rgb(255, 20, 0)",
            "line_width": "4"
        },
        {
            "response_id": "demo12-'.$uniqueResponseIdSuffix.'",
            "type": "imageclozetext",
            "description": "The student needs to fill in the blanks",
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
            "instant_feedback": true,
            "case_sensitive": false,
            "max_length": 10,
            "validation": {
                "penalty": 0.5,
                "scoring_type": "partialMatch",
                "valid_response": {
                    "score": 1,
                    "value": ["Florida", "Oregon", "Texas", "California"]
                }
            }
        },
        {
            "response_id": "demo13-'.$uniqueResponseIdSuffix.'",
            "type": "imageclozedropdown",
            "img_src": "//www.learnosity.com/static/img/Blank_US_Map.png",
            "instant_feedback": true,
            "possible_responses": [
                ["Montana", "Alabama", "California", "Louisiana"],
                ["New Hampshire", "Pennsylvania", "Texas", "Idaho"],
                ["Florida", "New Jersey", "North Carolina"]
            ],
            "response_positions": [{
                "x": 4.35,
                "y": 52.2
            }, {
                "x": 38.78,
                "y": 72.69
            }, {
                "x": 76.87,
                "y": 81.72
            }],
            "validation": {
                "penalty": 0.5,
                "scoring_type": "partialMatch",
                "valid_response": {
                    "score": 1,
                    "value": ["Florida", "Oregon", "Texas", "California"]
                }
            }
        },
        {
            "response_id": "demo14-'.$uniqueResponseIdSuffix.'",
            "type": "imageclozeassociation",
            "img_src": "//www.learnosity.com/static/img/World_Map_AU_US_BR_RU.png",
            "possible_responses": ["<span style=\"font-size:20px;padding:5px;\">♂</span> Male", "<span style=\"font-size:20px;padding:5px;\">♀</span> Female"],
            "response_positions": [{
                "x": 61.02,
                "y": 73.98
            }, {
                "x": 8.29,
                "y": 60.22
            }, {
                "x": 19.77,
                "y": 5.2
            }, {
                "x": 70.43,
                "y": 21.93
            }],
            "instant_feedback": true,
            "valid_responses": [
                [{
                    "value": "<span style=\"font-size:20px;padding:5px;\">♂</span> Male",
                    "score": 1
                }],
                [{
                    "value": "<span style=\"font-size:20px;padding:5px;\">♀</span> Female",
                    "score": 1
                }],
                [{
                    "value": "<span style=\"font-size:20px;padding:5px;\">♂</span> Male",
                    "score": 1
                }],
                [{
                    "value": "<span style=\"font-size:20px;padding:5px;\">♂</span> Male",
                    "score": 1
                }]
            ],
            "duplicate_responses": true,
            "response_container": {
                "width": "105px"
            }
        },
        {
            "response_id": "demo15-'.$uniqueResponseIdSuffix.'",
            "type": "orderlist",
            "description": "In this question, the student needs to order the events, chronologically earliest to latest.",
            "list": ["Russian Revolution", "Discovery of the Americas", "Storming of the Bastille", "Battle of Plataea", "Founding of Rome", "First Crusade"],
            "ui_style": "bulletlist",
            "instant_feedback": true,
            "feedback_attempts": 2,
            "validation": {
                "valid_response": [4, 3, 5, 1, 2, 0],
                "valid_score": 1,
                "partial_scoring": true,
                "penalty_score": -1
            }
        },
        {
            "response_id": "demo16-'.$uniqueResponseIdSuffix.'",
            "type": "orderlist",
            "description": "In this question, the student needs to order the albums, chronologically earliest to latest.",
            "list": [
               "<div class=\"album\"><img src=\"//www.learnosity.com/static/img/beatles_sgt.-peppers-lonely-hearts-club-band.jpg\"><span class=\"caption\"> Sgt. Pepper\'s Lonely Hearts Club Band</span></div>",
               "<div class=\"album\"><img src=\"//www.learnosity.com/static/img/beatles_abbey-road.jpg\"><span class=\"caption\"> Abbey Road</span></div>",
               "<div class=\"album\"><img src=\"//www.learnosity.com/static/img/beatles_a-hard-days-night.jpg\"><span class=\"caption\"> A Hard Day\'s Night</span></div>",
               "<div class=\"album\"><img src=\"//www.learnosity.com/static/img/beatles_the-beatles.jpg\"><span class=\"caption\"> The Beatles</span></div>"
             ],
            "ui_style": "button",
            "instant_feedback": true,
            "feedback_attempts": 2,
            "validation": {
                "valid_response": [2, 0, 3, 1],
                "valid_score": 1,
                "partial_scoring": true,
                "penalty_score": -1
            }
        },
        {
            "response_id": "demo17-'.$uniqueResponseIdSuffix.'",
            "type": "orderlist",
            "list": ["Un peregrino llega a la cumbre agotado por la sed. El diablo, disfrazado de caminante, se ofrece a indicarle una fuente oculta, a condición de que reniegue de Dios, de la Virgen o de Santiago. Pero el peregrino mantiene su fe a toda costa, aun cuando se encuentra exhausto.", "Es entonces cuando se aparece Santiago vestido de peregrino, recoge al moribundo y le lleva a la escondida fuente, dándole de beber con su vieira.", "<h4>Fuente Reniega</h4>", "La acción tiene lugar en el Alto del Perdón, a pocos kilómetros de Pamplona."],
            "ui_style": "plainlist",
            "instant_feedback": true,
            "validation": {
                "valid_response": [2, 3, 0, 1],
                "valid_score": "1",
                "partial_scoring": "true",
                "penalty_score": "0",
                "pairwise": "0"
            }
        },
        {
            "response_id": "demo18-'.$uniqueResponseIdSuffix.'",
            "type": "orderlist",
            "list": [ "On the contrary, for a small street in a quiet neighbourhood, it was remarkably animated.",
        "There was a group of shabbily dressed men smoking and laughing in a corner, a scissors-grinder with his wheel, two guardsmen who were flirting with a nurse-girl, and several well-dressed young men who were lounging up and down with cigars in their mouths.",
        "It was a quarter past six when we left Baker Street, and it still wanted ten minutes to the hour when we found ourselves in Serpentine Avenue.",
        "The house was just such as I had pictured it from Sherlock Holmes’ succinct description, but the locality appeared to be less private than I expected.",
        "It was already dusk, and the lamps were just being lighted as we paced up and down in front of Briony Lodge, waiting for the coming of its occupant." ],
            "ui_style": "inline",
            "instant_feedback": true,
            "validation": {
                "valid_response": [2, 4, 3, 0, 1],
                "valid_score": "1",
                "partial_scoring": "true",
                "penalty_score": "0",
                "pairwise": "0"
            }
        },
        {
            "response_id": "demo19-'.$uniqueResponseIdSuffix.'",
            "type": "texthighlight",
            "description": "In this question, the student needs to highlight the <strong>adjectives</strong> in the extract.",
            "template": "His manner was not <valid>effusive</valid>. It seldom was; but he was <valid>glad</valid>, I think, to see me. With hardly a word spoken, but with a <valid>kindly</valid> eye, he waved me to an armchair, threw across his case of cigars, and indicated a spirit case and a gasogene in the corner. Then he stood before the fire and looked me over in his <valid>singular</valid> <valid>introspective</valid> fashion.",
            "instant_feedback": true,
            "feedback_attempts": 2,
            "word_bound": true,
            "validation": {
                "valid_score": 1,
                "partial_scoring": true,
                "penalty_score": -1
            }
        },
        {
            "response_id": "demo20-'.$uniqueResponseIdSuffix.'",
            "type": "association",
            "description": "In this question, the student needs to match the cities to the parent nation.",
            "stimulus_list": ["London", "Dublin", "Paris", "Boston", "Sydney"],
            "possible_responses": ["United States", "Australia", "France", "Ireland", "England"],
            "valid_responses": [
                [
                    {"value": "England"}
                ],[
                    {"value": "Ireland"}
                ],[
                    {"value": "France"}
                ],[
                    {"value": "United States"}
                ],[
                    {"value": "Australia"}
                ]
            ],
            "instant_feedback" : true
        },
        {
            "response_id": "demo21-'.$uniqueResponseIdSuffix.'",
            "description": "The student needs to categorise the triangles.",
            "type": "classification",
            "ui_style": {
                "column_count": 3,
                "row_count": 1,
                "column_titles": ["Isoceles", "Scalene", "Equilateral"],
                "row_min_height": "100px"
            },
            "possible_responses": [
                "<img src=\"//www.learnosity.com/static/img/triangle1.png\" />",
                "<img src=\"//www.learnosity.com/static/img/triangle2.png\" />",
                "<img src=\"//www.learnosity.com/static/img/triangle3.png\" />"
            ],
            "validation": {
                "valid_responses": [
                    [[1], [0], [2]]
                ],
                "partial_scoring": true,
                "valid_score": 1,
                "penalty_score": -0.5
            },
            "duplicate_responses": false,
            "instant_feedback": true
        },
        {
            "response_id": "demo22-'.$uniqueResponseIdSuffix.'",
            "type": "sortlist",
            "description": "In this question, the student needs to sort the events, chronologically earliest to latest.",
            "list": ["Russian Revolution", "Discovery of the Americas", "Storming of the Bastille", "Battle of Plataea", "Founding of Rome", "First Crusade"],
            "instant_feedback": true,
            "feedback_attempts": 2,
            "validation": {
                "valid_response": [4, 3, 5, 1, 2, 0],
                "valid_score": 1,
                "partial_scoring": true,
                "penalty_score": -1
            }
        },
        {
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
                "x_max": 6,
                "x_min": -6,
                "y_max": 5,
                "y_min": -6
            },
            "description": "",
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "mode": "point",
            "response_id": "demo24-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "validation": {
                "penalty_score": "0",
                "valid_responses": [
                    [{
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 5,
                            "y": 2
                        }
                    }, {
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": 3,
                            "y": 0
                        }
                    }, {
                        "id": "lrn_3",
                        "type": "point",
                        "coords": {
                            "x": 2,
                            "y": 4
                        }
                    }, {
                        "id": "lrn_4",
                        "type": "point",
                        "coords": {
                            "x": -1,
                            "y": -5
                        }
                    }]
                ],
                "valid_score": "1"
            }
        },
        {
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
                "x_max": 10,
                "x_min": -1,
                "y_max": 10,
                "y_min": -1
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "mode": "line",
            "response_id": "demo25-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "validation": {
                "penalty_score": "0",
                "valid_responses": [
                    [{
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": 0,
                            "y": 1
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 1,
                            "y": 2
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_3",
                        "type": "line",
                        "subElementsIds": {
                            "startPoint": "lrn_2",
                            "endPoint": "lrn_1"
                        }
                    }]
                ],
                "valid_score": "1"
            }
        },
        {
            "response_id": "demo10-'.$uniqueResponseIdSuffix.'",
            "type": "clozeinlinetext",
            "description": "The student needs to fill in the blanks ",
            "template": "<p>Sherlock Homes had sprung out and seized the {{response}} by the collar. The other dived down the hole, and I heard the sound of {{response}} cloth as Jones clutched at his skirts. The light flashed upon the barrel of a revolver, but Holmes’ {{response}} came down on the man’s wrist, and the pistol {{response}} upon the stone floor.</p>",
            "instant_feedback": true,
            "case_sensitive": false,
            "validation": {
                   "valid_responses": [["intruder"],["rending"],["hunting crop"],["clinked"]]
                }
            },
        {
            "response_id": "demo23-'.$uniqueResponseIdSuffix.'",
            "instant_feedback": true,
            "stimulus": "<strong>Which sentence or sentences imply that the cheetahs run fast?</strong>",
            "template": "<p>Most cheetahs live in the wilds of Africa. There are also some in Iran and northwestern Afghanistan. The cheetah\'s head is smaller than the leopard\'s, and its body is longer. This cat is built for speed. Its legs are much longer than the leopard\', allowing it to run at speeds of up to 70 miles per hour! This incredible ability helps the cheetahs catch their dinner, which is usually an unfortunate antelope. A cheetah’s spots are simply black spots, not rosettes or circles.</p>",
            "tokenization": "sentence",
            "type": "tokenhighlight",
            "validation": {
                "partial_scoring": true,
                "penalty_score": 0,
                "show_partial_ui": true,
                "valid_responses": [3, 4],
                "valid_score": 1
            }
        },
        {
            "instant_feedback": true,
            "is_math": true,
            "response_id": "demo26-'.$uniqueResponseIdSuffix.'",
            "stimulus": "Find other equations that are equal to \\\((x + 3)(x + 1)\\\)",
            "type": "formula",
            "validation": {
                "valid_responses": [
                    [{
                        "method": "equivSymbolic",
                        "value": "(x+3)(x+1)",
                        "options": {
                            "allowDecimal": false
                        }
                    }]
                ]
            }
        },
    {
        "instant_feedback": true,
        "labels": {
            "frequency": 10,
            "show_max": true,
            "show_min": true
        },
        "line": {
            "left_arrow": true,
            "max": 3,
            "min": 0,
            "right_arrow": true
        },
        "points": ["1.5", "2.5", "5"],
        "response_id": "demo31-'.$uniqueResponseIdSuffix.'",
        "snap_to_ticks": true,
        "stimulus": "Position the tokens at the closest points. If the number isn&#39;t on the line, do not place it.<br />\nHint: We&#39;ll accept anything within .1 of the correct answer.",
        "ticks": {
            "distance": ".1",
            "show": true
        },
        "type": "numberline",
        "validation": {
            "partial_scoring": true,
            "penalty_score": 0,
            "show_partial_ui": true,
            "threshold": 0.1,
            "valid_responses": [{
                "point": "1.5",
                "position": "1.5"
            }, {
                "point": "2.5",
                "position": "2.5"
            }],
            "valid_score": 1
        }
    },
        {
            "response_id": "demo27-'.$uniqueResponseIdSuffix.'",
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
                "x_max": 10,
                "x_min": -10,
                "y_max": 10,
                "y_min": -10
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "stimulus": "Plot a line segment between the coordinates \\\((-5,-9)\\\) and \\\((4,7)\\\)",
            "toolbar": {
                "default_tool": "segment",
                "tools": ["segment"]
            },
            "type": "graphplotting",
            "validation": {
                "penalty_score": 0,
                "valid_responses": [
                    [{
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": -5,
                            "y": -9
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 4,
                            "y": 7
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_3",
                        "type": "segment",
                        "subElementsIds": {
                            "startPoint": "lrn_2",
                            "endPoint": "lrn_1"
                        }
                    }]
                ],
                "valid_score": 1
            }
        },
        {
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
                "ticks_distance": 2
            },
            "canvas": {
                "snap_to": "grid",
                "x_max": 9,
                "x_min": -3,
                "y_max": 5,
                "y_min": -4
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "response_id": "demo28-'.$uniqueResponseIdSuffix.'",
            "toolbar": {
                "default_tool": "line",
                "tools": [
                    ["line", "ray", "segment", "vector"]
                ]
            },
            "type": "graphplotting",
            "ui_style": {
                "height": "375px",
                "width": "500px"
            },
            "validation": {
                "penalty_score": 0,
                "valid_responses": [
                    [{
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": 4,
                            "y": 0
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 7,
                            "y": 2
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_3",
                        "type": "ray",
                        "subElementsIds": {
                            "startPoint": "lrn_2",
                            "endPoint": "lrn_1"
                        }
                    }]
                ],
                "valid_score": 1
            }
        },

        {
            "response_id": "demo29-'.$uniqueResponseIdSuffix.'",
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
                "x_max": 10,
                "x_min": -10,
                "y_max": 10,
                "y_min": -10
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "stimulus": "Plot the circle with centre co-ordinates \\\((5,4)\\\) and a radius of 2 units.",
            "toolbar": {
                "default_tool": "circle",
                "tools": ["circle"]
            },
            "type": "graphplotting",
            "validation": {
                "penalty_score": 0,
                "valid_responses": [
                    [{
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": 5,
                            "y": 4
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 7,
                            "y": 4
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_3",
                        "type": "circle",
                        "subElementsIds": {
                            "centrePoint": "lrn_2",
                            "radiusPoint": "lrn_1"
                        }
                    }]
                ],
                "valid_score": 1
            }
        },

        {
            "response_id": "demo30-'.$uniqueResponseIdSuffix.'",
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
                "x_max": 9,
                "x_min": -9,
                "y_max": 9,
                "y_min": -9
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "stimulus": "Plot the vector originating at \\\((0,1)\\\) in the direction \\\(\\\binom{3}{4}\\\)",
            "toolbar": {
                "default_tool": "vector",
                "tools": ["vector"]
            },
            "type": "graphplotting",
            "validation": {
                "penalty_score": 0,
                "valid_responses": [
                    [{
                        "id": "lrn_2",
                        "type": "point",
                        "coords": {
                            "x": 0,
                            "y": 1
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_1",
                        "type": "point",
                        "coords": {
                            "x": 3,
                            "y": 5
                        },
                        "subElement": true
                    }, {
                        "id": "lrn_3",
                        "type": "vector",
                        "subElementsIds": {
                            "startPoint": "lrn_2",
                            "endPoint": "lrn_1"
                        }
                    }]
                ],
                "valid_score": 1
            }
        },
        {
            "response_id": "demo32-'.$uniqueResponseIdSuffix.'",
            "type": "choicematrix",
            "stimulus": "Which statement is true?",
            "options": ["True", "False"],
            "instant_feedback": true,
            "stems": [
                "Sydney is the capital city of Australia.",
                "Darwin is the capital of the Northern Territory",
                "Queensland is the largest state in Australia."
            ],
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "value": [1, 0, 1],
                    "score": 1
                }
            },
            "ui_style": {
                "stem_numeration": "lower-alpha"
            }
        },
        {
            "response_id": "demo33-'.$uniqueResponseIdSuffix.'",
            "type": "choicematrix",
            "stimulus": "Answer the following questions:",
            "options": ["Sydney", "Shanghai", "Berlin", "Dallas"],
            "instant_feedback": true,
            "stems": [
                "Which city lies in Australia?",
                "Which city is the capital city of a country?",
                "Which city has the largest population?",
                "Which city lies in Texas?"
            ],
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                "value": [0, 2, 1, 3],
                "score": 1
                }
            },
            "ui_style": {
                "stem_width": "600px",
                "option_width": "100px"
            }
        },
        {
            "instant_feedback": true,
            "is_math": true,
            "response_id": "demo34-'.$uniqueResponseIdSuffix.'",
            "stimulus": "Enter any two values, such that the expression is equal to \\\(5 = y + x\\\).",
            "template": "{{response}} = y + {{response}}",
            "type": "formula",
            "validation": {
                "valid_responses": [
                    [{
                        "method": "equivSymbolic",
                        "value": "5=y+x",
                        "options": {
                            "allowDecimal": true,
                            "decimalPlaces": 10
                        }
                    }]
                ]
            }
        },
        {
            "instant_feedback": true,
            "is_math": true,
            "response_id": "demo35-'.$uniqueResponseIdSuffix.'",
            "stimulus": "Enter any value, such that the value is equal to \\\(5m\\\). You may use \\\(km\\\), \\\(cm\\\), \\\(ft\\\), \\\(in\\\) or other units (rounded to two decimal places.",
            "type": "formula",
            "validation": {
                "valid_responses": [
                    [{
                        "method": "equivValue",
                        "value": "5m",
                        "options": {
                            "decimalPlaces": 2
                        }
                    }]
                ]
            }
        },
        {
            "response_id": "demo36-'.$uniqueResponseIdSuffix.'",
            "type": "simplechart",
            "ui_style": {
                "chart_type": "bar"
            },
            "description": "An empty bar chart.",
            "max_y_value": 10,
            "chart_data": {
                "name": "Favourite movie type",
                "data": [
                    { "x": "Comedy", "y": 4 },
                    { "x": "Action", "y": 5 },
                    { "x": "Romance", "y": 9 },
                    { "x": "Drama", "y": 1 }
                ]
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "value": [
                        { "x": "Comedy", "y": 4 },
                        { "x": "Action", "y": 5 },
                        { "x": "Romance", "y": 4 },
                        { "x": "Drama", "y": 1 },
                        { "x": "SciFi", "y": 4 }
                    ],
                    "score": 1
                }
            },
            "instant_feedback": true
        },
        {
            "response_id": "demo37-'.$uniqueResponseIdSuffix.'",
            "type": "simplechart",
            "ui_style": {
                "chart_type": "bar"
            },
            "description": "Sort a bar chart.",
            "add_point": false,
            "order_point": true,
            "resize_point": false,
            "chart_data": {
                "name": "Animals by size (cm)",
                "data": [
                    { "x": "Cat", "y": 25 },
                    { "x": "Mouse", "y": 10 },
                    { "x": "Hamster", "y": 13 },
                    { "x": "Horse", "y": 225 },
                    { "x": "Sheep", "y": 100 }
                ]
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "value": [
                        { "x": "Mouse", "y": 10 },
                        { "x": "Hamster", "y": 13 },
                        { "x": "Cat", "y": 25 },
                        { "x": "Sheep", "y": 100 },
                        { "x": "Horse", "y": 225 }
                    ],
                    "score": 1
                }
            },
            "instant_feedback": true
        },
        {
            "response_id": "demo38-'.$uniqueResponseIdSuffix.'",
            "type": "simplechart",
            "ui_style": {
                "chart_type": "line"
            },
            "max_y_value": 100,
            "x_axis_label": "X axis title",
            "y_axis_label": "Y axis title",
            "resize_point": true,
            "delete_point": true,
            "edit_label": true,
            "chart_data": {
                "name": "Random data",
                "data": [
                    { "x": "A", "y": 100 },
                    { "x": "B", "y": 0 },
                    { "x": "C", "y": 90 },
                    { "x": "D", "y": 10 },
                    { "x": "E", "y": 80},
                    { "x": "F", "y": 20 },
                    { "x": "G", "y": 70 },
                    { "x": "H", "y": 30 },
                    { "x": "I", "y": 60 },
                    { "x": "J", "y": 40 },
                    { "x": "K", "y": 50 },
                    { "x": "L", "y": 50 }
                ]
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "value": [
                        { "x": "A", "y": 100 },
                        { "x": "B", "y": 0 },
                        { "x": "C", "y": 90 },
                        { "x": "D", "y": 10 },
                        { "x": "E", "y": 80},
                        { "x": "F", "y": 20 },
                        { "x": "G", "y": 70 },
                        { "x": "H", "y": 30 },
                        { "x": "I", "y": 60 },
                        { "x": "J", "y": 40 },
                        { "x": "K", "y": 50 },
                        { "x": "L", "y": 40 },
                        { "x": "M", "y": 60 }
                    ],
                    "score": 1
                }
            },
            "instant_feedback": true
        },
        {
            "response_id": "demo39-'.$uniqueResponseIdSuffix.'",
            "type": "formulaessay"
        },
        {
            "response_id": "demo40-'.$uniqueResponseIdSuffix.'",
            "instant_feedback": true,
            "response_containers": [{
                "template": "25 + 45={{response}}"
            }],
            "stimulus": "It takes John 25 minutes to walk to the car park and 45 minutes to drive to work.",
            "template": "<p>{{response}} minutes = {{response}} hour and {{response}} minutes</p>\n\n<p>John needs to get out of the house at {{response}}:{{response}}a.m. in order to get to work at 9:00a.m.</p>\n",
            "type": "clozeformula",
            "ui_style": {
                "fontsize": "",
                "type": "block-on-focus-keyboard"
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        [{
                            "method": "isTrue",
                            "options": {
                                "decimalPlaces": 10,
                                "inverseResult": false
                            }
                        }],
                        [{
                            "method": "equivLiteral",
                            "value": "1",
                            "options": {
                                "ignoreOrder": false,
                                "inverseResult": false
                            }
                        }],
                        [{
                            "method": "equivLiteral",
                            "value": "10",
                            "options": {
                                "ignoreOrder": false,
                                "inverseResult": false
                            }
                        }],
                        [{
                            "method": "equivValue",
                            "value": "7",
                            "options": {
                                "decimalPlaces": 10,
                                "inverseResult": false
                            }
                        }],
                        [{
                            "method": "equivLiteral",
                            "value": "50",
                            "options": {
                                "ignoreOrder": false,
                                "inverseResult": false
                            }
                        }]
                    ]
                }
            }
        }
    ]
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Question Types</h1>
    <p>Rich Question Types can be embedded on any page with the Learnosity <b>Questions API</b>.
    Every question is highly configurable to suit the assessment purpose, be it formative or summative.<p>
    <p>Try a few questions and then submit at the bottom of the page</p>
</div>

<!-- Container for the questions api to load into -->
<script src="//questions.learnosity.com"></script>
<script>
    $(function(){
        var options = {
                saveSuccess: function(response_ids) {
                    $('button.finish').text('Going to Review...');
                    window.location = $('a#reviewButton').attr('href');
                }
            };
        window.questionsApp = LearnosityApp.init(<?php echo $signedRequest; ?>, options);

        // submit questions..
        $('button.save-review').on('click', function() {
            $(this).removeClass('save-review').text($(this).attr('data-saving-text'));
            LearnosityApp.save();
        });
    });
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">Question Types Overview</h2>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q1">Multiple Choice</h3>
            <p>Which of these colours has the smallest wavelength?</p>
            <span class="learnosity-response question-demo1-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q1">Multiple Choice (Block Style)</h3>
            <p>What is the capital city of England?</p>
            <span class="learnosity-response question-demo1b-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q2">Multiple Choice with multi select</h3>
            <p>Which of these cities are state capitals?</p>
            <span class="learnosity-response question-demo2-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q3">Short text</h3>
             <p>
                <span class="label label-info">Hint</span> &#8220;Michael Bloomberg&#8221; gets one point, &#8220;Bloomberg&#8221; gets half a point.
            </p>
            <p>Who is the Mayor of New York City?</p>
            <span class="learnosity-response question-demo3-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q4">Long text answer with basic formatting</h3>
            <p>Briefly explain cellular mitosis.</p>
            <span class="learnosity-response question-demo4-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q5">Plain text answer, with copy, cut &amp; paste</h3>
            <p>Write a haiku poem in German.</p>
            <span class="learnosity-response question-demo5-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q6">Spoken response</h3>
            <p>Describe a typical day in your life.</p>
            <span class="learnosity-response question-demo6-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q7">Cloze (fill in the blanks)</h3>
            <p>Complete the multiplication table below.</p>
            <span class="learnosity-response question-demo7-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q8">Cloze (fill in the blanks) with drop down menus</h3>
            <p>Fill in the blanks</p>
            <span class="learnosity-response question-demo8-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q9">Cloze (fill in the blanks) with drag and drop</h3>
            <p>Simplify the following, expressing your answers with positive indices.</p>
            <span class="learnosity-response question-demo9-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q10">Cloze Text Expanding (Extended Fill in the blanks)</h3>
            <p>Fill in the blanks.</p>
            <span class="learnosity-response question-demo10-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q40">Cloze (fill in the blanks) with Math</h3>
            <span class="learnosity-response question-demo40-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q11">Draw / highlight on a background image</h3>
            <p>Circle one of the flower's anthers in the picture.</p>
            <span class="learnosity-response question-demo11-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q12">Label an image (add text)</h3>
            <p>Name the states on the map</p>
            <span class="learnosity-response question-demo12-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q13">Label an image (with drop down menus)</h3>
            <p>Select the correct State names on the map.</p>
            <span class="learnosity-response question-demo13-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q14">Label an image (with drag and drop)</h3>
            <p>Indicate whether each of the highlighted countries currently has a male or a female <strong>Head of State</strong>.</p>
            <span class="learnosity-response question-demo14-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q15">Order a list</h3>
            <p>Sort these historical events chronologically, from earliest to latest.</p>
            <span class="learnosity-response question-demo15-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q16">Order buttons</h3>
            <p>Sort these Beatles albums by release date (earliest first).</p>
            <span class="learnosity-response question-demo16-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q17">Order paragraphs</h3>
            <p>Move the paragraphs into the correct order.</p>
            <span class="learnosity-response question-demo17-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q18">Order words or sentences within a paragraph</h3>
            <p>Rearrange the sentences into the correct order.</p>
            <span class="learnosity-response question-demo18-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q19">Text Highlight</h3>
            <p>Select all the <strong>adjectives</strong> in the text.</p>
            <span class="learnosity-response question-demo19-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q20">Token Highlight</h3>
            <p>Select all the <strong>relevant sections</strong> in the text.</p>
            <span class="learnosity-response question-demo23-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q21">Match Lists</h3>
            <p>Match each city to its parent nation.</p>
            <span class="learnosity-response question-demo20-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q22">Sort List</h3>
            <p>Sort these historical events chronologically, from earliest to latest.</p>
            <span class="learnosity-response question-demo22-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q23">Categories (Drag and Drop)</h3>
            <p>Drag each triangle to the correct category.</p>
            <span class="learnosity-response question-demo21-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q32">Choice Matrix</h3>
            <span class="learnosity-response question-demo32-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q33">Choice Matrix (wide)</h3>
            <span class="learnosity-response question-demo33-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q31">Numberline</h3>
            <span class="learnosity-response question-demo31-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q24">Plot Points</h3>
            <p>Plot points at \((5,2)\), \((3,0)\), \((2,4)\) and \((-1,-5)\).</p>
            <span class="learnosity-response question-demo24-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q25">Plot Lines</h3>
            <p>Plot the line \( y = x + 1 \)</p>
            <span class="learnosity-response question-demo25-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q27">Plot Segments</h3>
            <span class="learnosity-response question-demo27-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q28">Plot Rays</h3>
            <p>Graph a Ray originating at \((4,0)\) in the direction towards \((7,-2)\)</p>
            <p><span class="label label-info">Hint</span> You'll need to use the <strong>Ray</strong> tool</p>
            <span class="learnosity-response question-demo28-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q29">Plot Circles</h3>
            <span class="learnosity-response question-demo29-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q30">Plot Vectors</h3>
            <span class="learnosity-response question-demo30-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q26">Math Formula</h3>
            <p><span class="label label-info">Hint</span>  \(x(x+4) +3\), \(x^2 +4x +3\) and \(3 + x^2 +4x \) would all be acceptable.</p>
            <span class="learnosity-response question-demo26-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q34">Math Formula (Fill in the Blanks)</h3>
            <p><span class="label label-info">Hint</span>  Possible answers include:<br><br>\(5 = y + x\)<br>\(-5 = y + (-x -2y)\)</p>
            <p>Try a few and see - the question is evaluated as a whole, rather than each box on its own.</p>
            <span class="learnosity-response question-demo34-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q35">Math Formula (Unit comparison)</h3>
            <p><span class="label label-info">Hint</span>  \(0.005km\), \(500cm\), \(5000mm\) \(16.40ft\), \(196.8in\) would all be acceptable.</p>
            <span class="learnosity-response question-demo35-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q36">Simple Chart - Bar</h3>
            <p><span class="label label-info">Hint</span> Resize <em>Romance</em> to 4 and add a new <em>SciFi</em> bar with a y-axis value of 4.</p>
            <span class="learnosity-response question-demo36-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q37">Simple Chart - Bar Sorting</h3>
            <p><span class="label label-info">Hint</span> Sort the chart (ascending) by clicking on the arrows.</p>
            <span class="learnosity-response question-demo37-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q36">Simple Chart - Line</h3>
            <p><span class="label label-info">Hint</span> Resize L to 40 and add a new point (M) and set its value to 60.</p>
            <span class="learnosity-response question-demo38-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q39">Formula Essay</h3>
            <p><span class="label label-info">Hint</span> Add math and rich text in the one long-response. Switch between math mode and text mode using the buttons on the right of each selected line.</p>
            <span class="learnosity-response question-demo39-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>


    <div class="row">
        <div class="form-actions">
            <button class="btn btn-xlarge btn-primary save-review finish" data-saving-text="Saving..." <?php if ($state !== 'initial') { echo 'disabled'; } ?>>Save and Review</button>
            <a id="reviewButton" style="display:none;" class="btn btn-primary" href="?uniqueResponseIdSuffix=<?php echo $uniqueResponseIdSuffix; ?>&state=review">Review answers</a>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
