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
        <h1>Question Editor API - Simple Layouts</h1>
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
    <script src="<?php echo $url_questioneditor_v3; ?>"></script>
    <div class="learnosity-question-editor"></div>
</div>

<script>
    var initOptions = {
        configuration: {
            consumer_key: '<?php echo $consumer_key; ?>'
        },
        ui: {
            layout: {
                mode: 'simple'
            }
        },
        rich_text_editor: {
            type: 'wysihtml'
        },
        widget_type: 'response'
    };

    var qeApp = LearnosityQuestionEditor.init(initOptions);
</script>

<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
