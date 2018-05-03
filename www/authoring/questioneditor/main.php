<?php

include_once '../../config.php';
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
        <h1>Question Editor API</h1>
        <p>This demo shows the Question Editor API loaded with barebones config. Refer to <a href="http://docs.learnosity.com/authoring/questioneditor/quickstart">the Quick Start guide</a> and <a href="http://docs.learnosity.com/authoring/questioneditor/initialisation">the Initialisation Options docs</a>.<p>
    </div>
</div>

<!--
********************************************************************
*
* Nav for different Question Editor API examples
*
********************************************************************
-->
<div class="section" id="qe-main-container">
    <!-- Container for the question editor api to load into -->
    <script src="<?php echo $url_questioneditor_v3; ?>"></script>
    <div class="margin-bottom-small">
        <button type="button" class="lrn-question-button btn btn-default">Question</button>
        <button type="button" class="lrn-feature-button btn btn-default">Feature</button>
    </div>

    <div class="learnosity-question-editor"></div>
</div>

<script>
    var initOptions = {
        configuration: {
            consumer_key: '<?php echo $consumer_key; ?>',
            main_container_selector: '#qe-main-container'
        },
        rich_text_editor: {
            type: 'ckeditor'
        },
        widget_type: 'response',
        dependencies: {
            questions_api: {
                init_options: {
                    beta_flags: {
                        reactive_views: true
                    }
                }
            }
        }
    };

    var qeApp = LearnosityQuestionEditor.init(initOptions);

    document.querySelector('.lrn-question-button')
        .addEventListener('click', function () {
            qeApp.reset('response');
        });

    document.querySelector('.lrn-feature-button')
        .addEventListener('click', function () {
            qeApp.reset('feature');
        });
</script>

<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
