<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>

<div class='jumbotron'>
    <h1>Question Editor API - Extended Initialisation</h1>
    <p>Our editor. Your item bank platform.<p>
    <div class='row'>
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/questioneditorapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="../../reporting/reports/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="alert alert-info" id="example-description">Description here</div>

<!-- Container for the question editor api to load into -->
<script src="//questioneditor.learnosity.com/"></script>
<div class="learnosity-question-editor"></div>
<script>
    var initOptions = {
        configuration: {
            questionsApiVersion: 'v2'
        },
        template_defaults: true
    };
    LearnosityQuestionEditor.init(initOptions);
</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
