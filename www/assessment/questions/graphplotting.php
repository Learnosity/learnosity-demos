<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => 'demos-site'
);

$uniqueResponseIdSuffix = Uuid::generate();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "submit_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "beta_flags": {
        "reactive_views": true
    },
    "questions": [
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
            "response_id": "demograph_1-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "toolbar": {
                "default_tool": "vector",
                "tools": ["move", "point", ["line", "ray", "segment", "vector"], "circle", ["parabola", "sine"], "polygon", "label"]
            },
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
            "description": "The student needs to plot the line \\\( y = x + 1 \\\)",
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "instant_feedback": true,
            "is_math": true,
            "mode": "line",
            "response_id": "demograph_2-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "toolbar": {
                "default_tool": "vector",
                "tools": ["move", "point", ["line", "ray", "segment", "vector"], "circle", ["parabola", "sine"], "polygon", "label"]
            },
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
            "response_id": "demograph_3-'.$uniqueResponseIdSuffix.'",
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
            "response_id": "demograph_4-'.$uniqueResponseIdSuffix.'",
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
            "response_id": "demograph_5-'.$uniqueResponseIdSuffix.'",
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
            "response_id": "demograph_6-'.$uniqueResponseIdSuffix.'",
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/questions/questiontypes#graphplotting" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Graph Plotting</h1>
    <p>One of the many question types provided by the Learnosity Questions API. The graph plotting type allows to draw or plot points, lines, line segments, rays, vectors and circles on a coordinate grid. Graph Plotting question types can be computer scored.<p>
    <p>Try a few of the demos below.</p>
</div>

<!-- Container for the questions api to load into -->
<script src="<?php echo $url_questions; ?>"></script>
<script>
    LearnosityApp.init(<?php echo $signedRequest; ?>);
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">Demos</h2>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Points</h3>
            <p>Plot points at \((5,2)\), \((3,0)\), \((2,4)\) and \((-1,-5)\).</p>
            <span class="learnosity-response question-demograph_1-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Lines</h3>
            <p>Plot the line \( y = x + 1 \)</p>
            <span class="learnosity-response question-demograph_2-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Segments</h3>
            <p>Plot a line segment between the coordinates \((-5,-9)\) and \((4,7)\)</p>
            <span class="learnosity-response question-demograph_3-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Rays</h3>
            <p>Graph a Ray originating at \((4,0)\) in the direction towards \((7,-2)\)</p>
            <p><span class="label label-info">Hint</span> You'll need to use the <strong>Ray</strong> tool</p></p>
            <span class="learnosity-response question-demograph_4-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Circles</h3>
            <p>Plot the circle with centre co-ordinates \((5,4)\) and a radius of 2 units.</p>
            <span class="learnosity-response question-demograph_5-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <h3>Plot Vectors</h3>
            <p>Plot the vector originating at \((0,1)\) in the direction \(\binom{3}{4}\)</p>
            <span class="learnosity-response question-demograph_6-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
