<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API</h1>
        <p>Features are reusable question and/or stimulus UI widgets that you can embed in an assessment.<p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <script src="<?php echo $url_questioneditor; ?>"></script>
    <div class="learnosity-question-editor"></div>
</div>

<script>
    var initObjects, questionEditorApp;

    initObjects = {
        widget_type: 'feature'
    };

    questionEditorApp = LearnosityQuestionEditor.init(initObjects);
</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
