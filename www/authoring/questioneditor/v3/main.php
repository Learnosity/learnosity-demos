<?php

include_once '../../../config.php';
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
            <h1>Question Editor API V3 - Beta</h1>
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
        <script src="<?php echo $url_questioneditor_v3; ?>"></script>
        <div class="margin-bottom-small">
            <button type="button" class="lrn-question-button btn btn-default">Question</button>
            <button type="button" class="lrn-feature-button btn btn-default">Feature</button>
            <div class="display-inline-block">
                <div class="radio">
                    <label>
                        <input type="radio" name="globallayout" value="edit">Single page layout (edit)
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="globallayout" value="edit_preview">Two columns layout (edit_preview)
                    </label>
                </div>
            </div>

        </div>
        <div class="lrn-change-button-wrapper hide margin-bottom-small">
            <button type="button" class="lrn-change-button btn btn-primary">Change</button>
        </div>
        <div class="my-question-editor"></div>
    </div>
    <script>


        var initOptions = {
            configuration: {
                questionsApiVersion: 'v2'
            },
            widgetType: 'response'
        };
        var changeButtonWrapper = document.querySelector('.lrn-change-button-wrapper');

        var qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');
        qeApp.on('widget:changed', function () {
            changeButtonWrapper.classList.remove('hide');
        });
        qeApp.on('editor:ready', function () {

        });

        document.querySelector('.lrn-question-button')
            .addEventListener('click', function () {
                qeApp.reset('response');
            });

        document.querySelector('.lrn-feature-button')
            .addEventListener('click', function () {
                qeApp.reset('feature');
            });

        var changeButton = document.querySelector('.lrn-change-button');
        changeButton.addEventListener('click', function () {
            qeApp.reset();
            changeButtonWrapper.classList.add('hide');
        });
    </script>

<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
