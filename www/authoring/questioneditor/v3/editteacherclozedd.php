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
        <script type="text/template" data-lrn-qe-layout="custom_layout">
<div class="lrn-qe-edit-form">

    <!-- Stimulus -->
    <span data-lrn-qe-label="stimulus"></span>
    <span data-lrn-qe-input="stimulus"></span>

    <span data-lrn-qe-label="template"></span>
    <span data-lrn-qe-input="template"></span>

    <!-- Possible responses -->
    <span data-lrn-qe-label="possible_responses"></span>
    <div data-lrn-qe-loop="possible_responses[*]">
        <span data-lrn-qe-input="possible_responses[*]"></span>
        <!-- Use for interleaving distractors
        <span data-lrn-qe-input="metadata.distractor_rationale_response_level[*]"></div -->>
    </div>
    <span data-lrn-qe-action-add="possible_responses"></span>

    <!-- Validation -->
    <span data-lrn-qe-label="validation"></span>

    <span data-lrn-qe-input="validation.valid_response.value"></span>

    <!-- Basic options -->
    <div class="lrn-qe-row-flex">
        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
            <span data-lrn-qe-label="duplicate_responses"></span>
            <span data-lrn-qe-input="duplicate_responses"></span>
        </div>
    </div>

    <div class="lrn-qe-divider"></div>

    <!-- More options -->
    <label class="lrn-qe-form-label lrn-qe-margin-top-none" data-lrn-qe-adv-toggle>
        <span class="lrn-qe-i-arrow lrn-qe-inline-block"></span>
        <span class="lrn-qe-inline-block lrn-qe-text-bold"><label class="lrn-qe-label lrn-qe-form-label-name" data-lrn-qe-i18n-label="heading.moreOptions" value="More options" ></label></span>
    </label>

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
                "possible_responses": ["Chicago", "New York City", "Los Angeles"],
                "response_container": {
                    "pointer": "left"
                },
                "stimulus": "<p>Complete the following sentence:</p>\n",
                "template": "<p>The most populated city in the US is {{response}}, followed by {{response}}&nbsp;and {{response}}.</p>\n",
                "type": "clozeassociation",
                "validation": {
                    "scoring_type": "exactMatch",
                    "valid_response": {
                        "score": 1,
                        "value": ["New York City", "Los Angeles", "Chicago"]
                    }
                }

            },
            initOptions = {
                widgetType: 'response',
                widget_json: widget_json,
                rich_text_editor: {
                    type: 'wysihtml'
                },
                ui: {
                    layout: {
                        edit_panel: {
                            clozeassociation: [{
                                layout: 'custom_layout'
                            }]
                        },
                        global_template: 'custom'
                    },
                    editor: {
                        response_shortcut: 'singleunderscore'
                    }
                },
                question_types: {
                    clozeassociation: {dependency:['possible_responses','metadata.distractor_rationale_response_level']}
                },
                label_bundle:{
                    debug: false,
                    stimulus: "Question:",
                    options: "Options:",
                    template: "Template (use _ for new response location)",
                    'validation.valid_response.value.value':'Correct answer:'
                }
            },
            qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');

        qeApp.on('widget:ready', function () {
        });

        $(function () {
            var $reviewModal = $('.qe-edit-layout-modal'),
                editLayoutContent = $('[data-lrn-qe-layout="custom_layout"]').html();



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
