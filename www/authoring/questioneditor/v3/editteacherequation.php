<?php

include_once '../../../config.php';
include_once 'includes/header.php';

?>
    <link type="text/css" rel="stylesheet" href="css/prettify.css">
    <script src="lib/prettify.js"></script>
    <style>
        .panel-title {
            padding-left: 20px;
        }
        .panel-group {
            margin-top: 20px;
        }
        #accordion .panel {
            border-radius: 0;
        }
        #accordion .panel-heading {
            background: #666;
            border-radius: 0;
        }
        #accordion .panel-heading a {
            color: #fff;
        }
        #accordion .panel-heading a:hover {
            color: #eee;
        }
    </style>
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authoring/questioneditor" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h1>Question Editor API</h1>
            <p>Teacher's are busy and we need to give them the simplest authoring experience. You can customise the question's layout to suit your design needs. For more information, refer to <a href="http://docs.learnosity.com/authoring/questioneditor/editlayout">the docs page</a>.<p>
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





        <!--  Custom MCQ layout -->
        <script type="text/template" data-lrn-qe-layout="custom_formulaV2_layout">
<div class="lrn-qe-edit-form">
    <span data-lrn-qe-label="stimulus"></span>
    <span data-lrn-qe-input="stimulus" class="lrn-qe-ckeditor-lg"></span>

    <div data-lrn-qe-loop="validation.valid_response.value[*]">
        <div class="lrn-qe-row-flex">
            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-12 lrn-qe-col-md-9">
                <span data-lrn-qe-label="validation.valid_response.value[*].value"></span>
                <span data-lrn-qe-input="validation.valid_response.value[*].value"></span>
            </div>
            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-12 lrn-qe-col-md-3">
                <span data-lrn-qe-label="validation.valid_response.value[*].options.ignoreOrder"></span>
                <span data-lrn-qe-input="validation.valid_response.value[*].options.ignoreOrder"></span>
            </div>
        </div>
    </div>
</div>
        </script>
        <!--/ Custom Layout -->

        <div>
            <button class="btn btn-info btn-review-edit-layout">View HTML Markup</button>
            <button class="btn btn-info btn-view-toggle-preview">Edit/Preview</button>
        </div>


        <div class="my-question-editor">
            <div class="view_edit" style="display: none">
                <span data-lrn-qe-layout-edit-panel></span>
            </div>
            <div class="view_preview" >
                <!-- ML - needs to be styled better
                 <span data-lrn-qe-layout-live-score></span> -->
                <span data-lrn-qe-layout-preview-panel></span>
            </div>
        </div>


    </div>

    <div class="modal fade qe-edit-layout-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Global layout HTML</h4>
                </div>
                <div class="modal-body">
                    <pre class="prettyprint"></pre>
                </div>
            </div>
        </div>
    </div>
    <script>
        var widget_json = {
                "is_math": true,
                "stimulus": "<p>Expand the following equation:</p><p>\\(3\\left(1+4\\right)\\)</p>",
                "type": "formulaV2",
                "validation": {
                    "scoring_type": "exactMatch",
                    "valid_response": {
                        "score": 1,
                        "value": [{
                            "method": "equivLiteral",
                            "value": "15",
                            "options": {
                               "allowThousandsSeparator": true,
                                "ignoreOrder": false,
                                "inverseResult": false,
                                "ignoreTrailingZeros": true,
                                "setThousandsSeparator": [","],
                                "setDecimalSeparator": "."
                            }
                        }]
                    }
                },
                "ui_style": {
                    "type": "block-keyboard"
                },
                "math_renderer": "mathquill"
            },
            initOptions = {
                widgetType: 'response',
                configuration :{
                    consumer_key : '<?php echo $consumer_key; ?>'
                },
                widget_json: widget_json,
                rich_text_editor: {
                    type: 'wysihtml'
                },
                ui: {
                    layout: {
                        edit_panel: {
                            formulaV2: [{
                                layout: 'custom_formulaV2_layout'
                            }]
                        },
                        global_template: 'custom'
                    }
                },
                question_types: {
                    mcq: {dependency:['options','metadata.distractor_rationale_response_level']}
                },
                label_bundle:{
                    debug: false,
                    stimulus: "Question:",
                    options: "Options:",
                    'validation.valid_response.value.value':'Correct answer:'
                }
            },
            qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');

        qeApp.on('widget:ready', function () {
        });

        $(function () {
            var $reviewModal = $('.qe-edit-layout-modal'),
                editLayoutContent = $('[data-lrn-qe-layout="custom_formulaV2_layout"]').html();



            $('.btn-review-edit-layout').on('click', function () {
                $reviewModal
                    .find('.prettyprint')
                    .text(editLayoutContent);
                prettyPrint();
                $reviewModal.modal('show');
            })

            // $('.btn-view-question-source').on('click', function () {

            //     $reviewModal
            //         .find('.prettyprint')
            //         .text(JSON.stringify(qeApp.getWidget()));
            //     prettyPrint();
            //     $reviewModal.modal('show');
            // })

            var view_edit = $('.view_edit');
            var view_preview = $('.view_preview');
            var edit_mode = false;

            $('.btn-view-toggle-preview').on('click', function () {
                if(edit_mode){
                    view_edit.hide();
                    view_preview.show();
                    qeApp.updatePreview();
                    edit_mode = false;
                }else{
                    view_edit.show();
                    view_preview.hide();
                    edit_mode = true;
                }

            })


        });
    </script>
<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
