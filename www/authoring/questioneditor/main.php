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
        <h1>Question Editor API V2</h1>
        <p>Our editor. Your item bank platform.<p>
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
    <script src="<?php echo $url_questioneditor; ?>"></script>
    <div class="learnosity-question-editor"></div>
</div>
<script>


    var initOptions = {
            configuration: {
                questionsApiVersion: 'v2'
            },
            widgetType: 'response',
            ui: {
                public_methods: ['getResponses'],
                layout: '2-column',
                fixedPreview: {
                    marginTop: 50
                }
            }
        };

    var qeApp = LearnosityQuestionEditor.init(initOptions);

</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
