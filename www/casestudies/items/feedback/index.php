<?php

include_once '../../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <h1>Case Study – Teacher Feedback</h1>
    <div class="section-intro">
        <p>Although the majority of Learnosity question types are auto-scorable, some (like open
        response or audio recording) require teacher/marker attention.<p>
        <p>This can take shape as feedback for the student, or providing an actual score to
        be saved with the original student response.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Rich Feedback</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates reviewing a student assessment, and providing
                    Learnosity tools to enable rich teacher feedback.<p>
                    <p>In this example, no scoring is applied to the student responses. Only
                    feedback from the teacher for the student to review.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./rich-feedback/">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Simple Scoring</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates reviewing a student assessment, and providing
                    Learnosity tools enabling the teacher to apply a score to each student response.<p>
                    <p>In this example, scoring is applied to student responses via
                    the Data API.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./simple-scoring/">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
