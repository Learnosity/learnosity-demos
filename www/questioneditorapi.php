<?php

include_once 'config.php';
include_once '../src/utils/RequestHelper.php';
include_once '../src/includes/header.php';

?>

<div class="jumbotron">
    <h1>Question Editor API</h1>
    <p>Our editor. Your item bank platform.<p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questioneditorapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Online docs
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="questionsapi.php">Continue</a></p></div>
    </div>
</div>

<!-- Container for the question editor api to load into -->
<span class="learnosity-response-editor"></span>
<script src="http://responseeditor.learnosity.com/"></script>
<script>
    LearnosityResponseEditor.init({
        widgetType: 'response',
        ui: {
            columns: [{
                tabs: ["edit", "advanced"],
                width: "50%"
            }, {
                tabs: ["preview", "layout"],
                width: "50%"
            }],
            fixedPreview: {
               marginTop: 50
            }
        }
    });
</script>

<?php include_once '../src/includes/footer.php';
