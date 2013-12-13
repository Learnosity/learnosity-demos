<?php

include_once '../../config.php';
include_once '../../../src/utils/uuid.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp,
    "user_id"      => $studentid
);

$RequestHelper = new RequestHelper(
    'questions',
    $security,
    $consumer_secret
);

$activitySignature = $RequestHelper->getSignature();

$uniqueResponseIdSuffix = UUID::generateUuid();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$signedRequest = '{
    "consumer_key": "'.$consumer_key.'",
    "timestamp": "' . $timestamp . '",
    "signature": "'.$activitySignature.'",
    "user_id": "'.$studentid.'",
    "type": "submit_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "renderSubmitButton" : "true",
    "questions": [
    {
        "response_id": "demo1-'.$uniqueResponseIdSuffix.'",
        "type": "mcq",
        "description": "Which of this has the smallest wavelength?",
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
        "feedback_attempts" : 1,
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
        "instant_feedback": true,
        "case_sensitive": true
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
        "template" : "<table><thead><tr><th><strong>Multiply</strong></th><th><strong>_ x 1</strong></th><th><strong>_ x 2</strong></th><th><strong>_ x 3</strong></th><th><strong>_ x 4</strong></th><th><strong>_ x 5</strong></th></tr></thead><tbody><tr><td><strong>1 x _</strong></td><td>{{response}}</td><td>2</td><td>3</td><td>4</td><td>5</td></tr><tr><td><strong>2 x _</strong></td><td>2</td><td>{{response}}</td><td>6</td><td>8</td><td>10</td></tr><tr><td><strong>3 x _</strong></td><td>3</td><td>6</td><td>{{response}}</td><td>12</td><td>15</td></tr><tr><td><strong>4 x _</strong></td><td>4</td><td>8</td><td>12</td><td>{{response}}</td><td>20</td></tr><tr><td><strong>5 x _</strong></td><td>5</td><td>10</td><td>15</td><td>20</td><td>{{response}}</td></tr></tbody></table>",
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
        "possible_responses" : [ ["whispered", "sprinted", "joked"], ["Homes", "holmes", "Holmes", ], ["acquaintance", "intruder", "shopkeeper"], ["burning", "departing", "rending", "broken"], ["revolver","hunting crop"], ["rattled", "clinked", "spilt"] ],
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
        "response_id": "demo10-'.$uniqueResponseIdSuffix.'",
        "type": "highlight",
        "description": "The student needs to mark one of the flower\'s anthers in the image.",
        "img_src": "http://www.staging.learnosity.com/static/img/flower.jpg",
        "line_color": "rgb(255, 20, 0)",
        "line_width": "4"
    },
    {
        "response_id": "demo11-'.$uniqueResponseIdSuffix.'",
        "type": "imageclozetext",
        "description": "The student needs to fill in the blanks",
        "img_src": "http://www.staging.learnosity.com/static/img/Blank_US_Map.png",
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
        "case_sensitive": true,
        "max_length": 10,
        "valid_responses": [
            [{
                "value": "California"
            }],
            [{
                "value": "Texas"
            }],
            [{
                "value": "Florida"
            }]
        ]
    },
    {
        "response_id": "demo12-'.$uniqueResponseIdSuffix.'",
        "type": "imageclozedropdown",
        "img_src": "http://www.staging.learnosity.com/static/img/Blank_US_Map.png",
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
        "valid_responses": [
            [{
                "value": "California",
                "score": 1
            }],
             [{
                "value": "Texas",
                "score": 1
            }],
             [{
                "value": "Florida",
                "score": 1
            }]
        ]
    },
    {
        "response_id": "demo13-'.$uniqueResponseIdSuffix.'",
        "type": "imageclozeassociation",
        "img_src": "http://www.staging.learnosity.com/static/img/World_Map_AU_US_BR_RU.png",
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
                "value": "<span style=\"font-size:20px;padding:5px;\">♀</span> Female",
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
        "response_id": "demo14-'.$uniqueResponseIdSuffix.'",
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
        "response_id": "demo15-'.$uniqueResponseIdSuffix.'",
        "type": "orderlist",
        "description": "In this question, the student needs to order the albums, chronologically earliest to latest.",
        "list": [
           "<div class=\"album\"><img src=\"http://www.staging.learnosity.com/static/img/beatles_sgt.-peppers-lonely-hearts-club-band.jpg\"><span class=\"caption\"> Sgt. Pepper\'s Lonely Hearts Club Band</span></div>",
           "<div class=\"album\"><img src=\"http://www.staging.learnosity.com/static/img/beatles_abbey-road.jpg\"><span class=\"caption\"> Abbey Road</span></div>",
           "<div class=\"album\"><img src=\"http://www.staging.learnosity.com/static/img/beatles_a-hard-days-night.jpg\"><span class=\"caption\"> A Hard Day\'s Night</span></div>",
           "<div class=\"album\"><img src=\"http://www.staging.learnosity.com/static/img/beatles_the-beatles.jpg\"><span class=\"caption\"> The Beatles</span></div>",
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
        "response_id": "demo16-'.$uniqueResponseIdSuffix.'",
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
        "response_id": "demo17-'.$uniqueResponseIdSuffix.'",
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
        "response_id": "demo18-'.$uniqueResponseIdSuffix.'",
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
        "response_id": "demo19-'.$uniqueResponseIdSuffix.'",
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
            "<img src=\"http://www.staging.learnosity.com/static/img/triangle1.png\" />",
            "<img src=\"http://www.staging.learnosity.com/static/img/triangle2.png\" />",
            "<img src=\"http://www.staging.learnosity.com/static/img/triangle3.png\" />"
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
        "type": "graphplotting",
        "description": "The student needs to plot a simple cubic curve.",
        "mode": "point",
        "canvas": {
            "snap_to": "grid",
            "x_min": -10,
            "x_max": 10,
            "y_min": -10,
            "y_max": 10
        },
        "axis_x": {
            "ticks_distance": 1,
            "draw_labels": true,
            "show_last_arrow": true
        },
        "axis_y": {
            "ticks_distance": 1,
            "draw_labels": true,
            "show_last_arrow": true
        },
         "grid": {
            "x_distance": 1,
            "y_distance": 1
        }
    },
    {
        "response_id": "demo23-'.$uniqueResponseIdSuffix.'",
        "type": "graphplotting",
        "description": "The student needs to plot the line \\\( y = x + 1 \\\)",
        "mode": "line",
        "is_math": true,
        "canvas": {
            "snap_to": "grid",
            "x_min": -10,
            "x_max": 10,
            "y_min": -10,
            "y_max": 10
        },
        "axis_x": {
            "ticks_distance": 1,
            "draw_labels": true,
            "show_last_arrow": true
        },
        "axis_y": {
            "ticks_distance": 1,
            "draw_labels": true,
            "show_last_arrow": true
        },
        "grid": {
            "x_distance": 1,
            "y_distance": 1
        }
    },
    {
        "response_id": "demo24-'.$uniqueResponseIdSuffix.'",
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
        "response_id": "demo25-'.$uniqueResponseIdSuffix.'",
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
        "stimulus": "Find other equations that are equal to \\((x + 3)(x + 1)\\)",
        "template": "{{response}}",
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
    }
]
}';

?>

<div class="jumbotron">
    <h1>Questions API - Question Types</h1>
    <p>Rich Question Types can be embedded on any page with the Learnosity <b>Questions API</b>.  Every question is highly configurable to suit the assessment purpose, be it formative or summative.<p>
    <p>Try a few questions and then submit at the bottom of the page</p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="./featuretypes.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the questions api to load into -->
<script src="http://questions.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityApp.init(activity);
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Question Types Overview</h2>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q1">Multiple Choice</h3>
        <p>Which of these colours has the smallest wavelength?</p>
        <span class="learnosity-response question-demo1-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q1">Multiple Choice (Block Style)</h3>
        <p>What is the capital city of England?</p>
        <span class="learnosity-response question-demo1b-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q2">Multiple Choice with multi select</h3>
        <p>Which of these cities are state capitals?</p>
        <span class="learnosity-response question-demo2-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
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
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q4">Long text answer with basic formatting</h3>
        <p>Briefly explain cellular mitosis.</p>
        <span class="learnosity-response question-demo4-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q5">Plain text answer, with copy, cut &amp; paste</h3>
        <p>Write a haiku poem in German.</p>
        <span class="learnosity-response question-demo5-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q6">Spoken response</h3>
        <p>Describe a typical day in your life.</p>
        <span class="learnosity-response requires-flash question-demo6-<?php echo $uniqueResponseIdSuffix ?>"></span>
        <div class="alert alert-error no-flash"><strong>Aww!</strong> We can't load this question because Flash isn't available.</div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q7">Cloze (fill in the blanks)</h3>
        <p>Complete the multiplication table below.</p>
        <span class="learnosity-response question-demo7-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q8">Cloze (fill in the blanks) with drop down menus</h3>
        <p>Fill in the blanks</p>
        <span class="learnosity-response question-demo8-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q9">Cloze (fill in the blanks) with drag and drop</h3>
        <p>Simplify the following, expressing your answers with positive indices.</p>
        <span class="learnosity-response question-demo9-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q10">Cloze Text Expanding (Extended Fill in the blanks)</h3>
        <p>Fill in the blanks.</p>
        <span class="learnosity-response question-demo10-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q11">Draw / highlight on a background image</h3>
        <p>Circle one of the flower's anthers in the picture.</p>
        <span class="learnosity-response question-demo11-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q12">Label an image (add text)</h3>
        <p>Name the states on the map</p>
        <span class="learnosity-response question-demo12-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q13">Label an image (with drop down menus)</h3>
        <p>Select the correct State names on the map.</p>
        <span class="learnosity-response question-demo13-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q14">Label an image (with drag and drop)</h3>
        <p>Indicate whether each of the highlighted countries currently has a male or a female <strong>Head of State</strong>.</p>
        <span class="learnosity-response question-demo14-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q15">Order a list</h3>
        <p>Sort these historical events chronologically, from earliest to latest.</p>
        <span class="learnosity-response question-demo15-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q16">Order buttons</h3>
        <p>Sort these Beatles albums by release date (earliest first).</p>
        <span class="learnosity-response question-demo16-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q17">Order paragraphs</h3>
        <p>Move the paragraphs into the correct order.</p>
        <span class="learnosity-response question-demo17-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q18">Order words or sentences within a paragraph</h3>
        <p>Rearrange the sentences into the correct order.</p>
        <span class="learnosity-response question-demo18-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q19">Text Highlight</h3>
        <p>Select all the <strong>adjectives</strong> in the text.</p>
        <span class="learnosity-response question-demo19-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q20">Token Highlight</h3>
        <p>Select all the <strong>relevant sections</strong> in the text.</p>
        <span class="learnosity-response question-demo20-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q21">Match Lists</h3>
        <p>Match each city to its parent nation.</p>
        <span class="learnosity-response question-demo21-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q22">Sort List</h3>
        <p>Sort these historical events chronologically, from earliest to latest.</p>
        <span class="learnosity-response question-demo22-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q23">Categories (Drag and Drop)</h3>
        <p>Drag each triangle to the correct category.</p>
        <span class="learnosity-response question-demo23-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q24">Plot Points</h3>
        <p>Plot a simple cubic curve on the graph.</p>
        <span class="learnosity-response question-demo24-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q25">Plot Lines</h3>
        <p>Plot the line \( y = x + 1 \)</p>
        <span class="learnosity-response question-demo25-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 id="q26">Math Formula</h3>
        <p><span class="label label-info">Hint</span>  \(x(x+4) +3\), \(x^2 +4x +3\) and \(3 + x^2 +4x \) would all be acceptable.</p>
        <span class="learnosity-response question-demo26-<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>
<hr>

<!-- Tell the API where to place the submit button if using "renderSubmitButton" attribute -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <span class="learnosity-submit-button"></span>
    </div>
</div>

<?php
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
