<?php

include_once '../../../config.php';
include_once 'includes/header.php';

$request = '{
    "configuration": {
        "consumer_key": "' . $consumer_key . '"
    },
    "widget_type": "response",
    "widget_json": {
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
        },
        "ui_style": {
            "height": "500px",
            "width": "500px"
        },
        "background_image": {
            "src": ""
        }
    },
    "widget_metadata": {
        "template_reference": "2b180c4d-9c5c-4257-b16a-a296b7b5b548"
    },
    "question_types": {
        "graphplotting": {
            "name" : "Cartesian Graph",
            "hidden": ["validation.ignore_repeated_shapes","canvas.x_min","canvas.y_min","heading.graphParameters"],
            "hidden_sections": ["more_options","graph_parameters.heading"]
        }
    },
    "ui": {
        "layout": {
            "global_template": "edit",
            "mode": "simple"
        }
    },
    "label_bundle": {
        "debug": false
    }
}';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
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
        <h1>Question Editor API – Cartesian Graph</h1>
        <p>Here is an example of a Cartesian Graphing question which has been defaulted to include X &amp; Y axes, snap to grid behaviour, X &amp; Y axes range etc. In this case the author need not worry about that, just add the question.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <div class="learnosity-question-editor"></div>
</div>

<script src="<?php echo $url_questioneditor_v3; ?>"></script>
<script>
    var initOptions = <?php echo $request ?>,
        domHook = 'learnosity-question-editor',
        eventOptions = {
            readyListener: function () {
                init();
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
include_once 'includes/footer.php';
