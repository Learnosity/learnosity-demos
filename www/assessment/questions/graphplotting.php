<?php

include_once '../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

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
    "questions": [
        {
            "response_id": "demograph_1-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "mode": "point",
            "axis_x": {
                "ticks_distance": 1,
                "draw_labels": false
            },
            "axis_y": {
                "ticks_distance": 1,
                "draw_labels": false
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "canvas": {
                "snap_to": 0.5,
                "x_min": -10,
                "x_max": 10,
                "y_min": -10,
                "y_max": 10
            },
            "ui_style": {
                "width": "500px",
                "height": "500px"
            },
            "annotation": {
                "title": "Graph Title",
                "label_top": "Y Axis Label",
                "label_bottom": "Y Axis Label",
                "label_left": "X Axis Label",
                "label_right": "X Axis Label"
            }
        },
        {
            "response_id": "demograph_2-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "mode": "line",
            "axis_x": {
                "ticks_distance": 1,
                "draw_labels": true
            },
            "axis_y": {
                "ticks_distance": 1,
                "draw_labels": true
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "canvas": {
                "snap_to": 0.5,
                "x_min": -8,
                "x_max": 8,
                "y_min": -8,
                "y_max": 8
            },
        },
        {
            "response_id": "demograph_3-'.$uniqueResponseIdSuffix.'",
            "type": "graphplotting",
            "mode": "all",
            "axis_x": {
                "ticks_distance": 0.5,
                "draw_labels": true
            },
            "axis_y": {
                "ticks_distance": 0.5,
                "draw_labels": true
            },
            "grid": {
                "x_distance": 1,
                "y_distance": 1
            },
            "canvas": {
                "snap_to": "ticks",
                "x_min": -5,
                "x_max": 5,
                "y_min": -5,
                "y_max": 5
            },
            "ui_style": {
                "margin": "20px"
            }
        }
    ]
}';

?>

<div class="jumbotron">
    <h1>Graph Plotting</h1>
    <p>One of the many question types provided by the Learnosity Questions API. The graph plotting type allows to draw or plot points on a coordinate grid.<p>
    <p>Try a few of the demos below.</p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="<?php echo $env['www'] ?>assessment/items/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the questions api to load into -->
<script src="//questions.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityApp.init(activity);
</script>


<!-- Main question content below here: -->
<h2 class="page-heading">Demos</h2>

<p>1. Plot four unique points on the coordinate grid that are each 5 units from the point (1,2). Each point must contain coordinates with integer values.</p>
<span class="learnosity-response question-demograph_1-<?php echo $uniqueResponseIdSuffix ?>"></span><hr>

<p>2. Draw the graph of the inverse of f(x) = x - 2 on the coordinate grid below.</p>
<span class="learnosity-response question-demograph_2-<?php echo $uniqueResponseIdSuffix ?>"></span><hr>

<p>3. Draw a point at (-2,1) and the line for f(x) = 2x + 1</p>
<span class="learnosity-response question-demograph_3-<?php echo $uniqueResponseIdSuffix ?>"></span>


<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
