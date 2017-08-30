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
            <p>Our editor. Your item bank platform. You can customise the question's layout to suit your design needs. For more information, refer to <a href="http://docs.learnosity.com/authoring/questioneditor/editlayout">the docs page</a>.<p>
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


        <!--  Custom layout -->
        <script type="text/template" data-lrn-qe-layout="custom_mcq_layout">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Basic Options
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <div class="lrn-qe-ui">
                    <span data-lrn-qe-label="stimulus" value="Compose question:" class="lrn-qe-lg-ckeditor"></span>
                    <span data-lrn-qe-input="stimulus" class="lrn-qe-lg-ckeditor"></span>

                    <span data-lrn-qe-label="options" class=" mts"></span>
                    <div data-lrn-qe-loop="options[*]">
                        <span data-lrn-qe-input="options[*]"></span>
                    </div>
                    <span data-lrn-qe-action-add="options"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Validation
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <div class="lrn-qe-tabs" data-lrn-qe-tabs>
                    <ul class="lrn-qe-tab-header">
                        <li class="lrn-qe-tab-trigger" data-lrn-qe-tab-trigger>
                            <span data-lrn-qe-label="validation.valid_response"></span>
                        </li>
                        <li data-lrn-qe-loop="validation.alt_responses[*]" class="lrn-qe-tab-trigger"
                            data-lrn-qe-tab-trigger>
                            <span data-lrn-qe-label="validation.alt_responses[*]"></span>
                        </li>
                        <li>
                            <span data-lrn-qe-action-add="validation.alt_responses" class="lrn-qe-tabs-add"></span>
                        </li>
                    </ul>

                    <div class="lrn-qe-tab-item" data-lrn-qe-tab-item>
                        <div class="lrn-qe-tab-sub-content">
                            <span data-lrn-qe-input="validation.valid_response.score" class="lrn-qe-inline-block lrn-qe-text-center lrn-qe-form-control-xs lrn-qe-margin-left-sm"></span>
                            <span data-lrn-qe-label="validation.valid_response.score" class="lrn-qe-inline-block lrn-qe-margin-left-sm"></span>
                        </div>
                        <span data-lrn-qe-input="validation.valid_response.value"></span>
                    </div>

                    <!-- Placeholder for alternate responses if the author uses them -->
                    <div data-lrn-qe-loop="validation.alt_responses[*]" class="lrn-qe-tab-item"
                         data-lrn-qe-tab-item data-lrn-qe-layout-listeners="add,remove">
                        <div class="lrn-qe-tab-sub-content">
                            <span data-lrn-qe-action-remove="validation.alt_responses[*]" class="lrn-qe-tab-remove"></span>
                            <span data-lrn-qe-input="validation.alt_responses[*].score" class="lrn-qe-inline-block lrn-qe-text-center lrn-qe-form-control-xs lrn-qe-margin-left-sm"></span>
                            <span data-lrn-qe-label="validation.alt_responses[*].score" class="lrn-qe-inline-block lrn-qe-margin-left-sm"></span>
                        </div>
                        <span data-lrn-qe-input="validation.alt_responses[*].value"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Other Options
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="lrn-qe-ui">
                    <div class="lrn-qe-row-flex">
                        <div class="lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="multiple_responses"></span>
                            <span data-lrn-qe-input="multiple_responses"></span>
                        </div>
                        <div class="lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="shuffle_options"></span>
                            <span data-lrn-qe-input="shuffle_options"></span>
                        </div>
                    </div>

                    <div class="lrn-qe-row-flex">
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="instant_feedback"></span>
                            <span data-lrn-qe-input="instant_feedback"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="feedback_attempts" value="Number of attempted allowed"></span>
                            <span data-lrn-qe-input="feedback_attempts" class="lrn-qe-form-control-sm"></span>
                        </div>
                    </div>

                    <div class="lrn-qe-row-flex">
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="validation.penalty"></span>
                            <span data-lrn-qe-input="validation.penalty"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="is_math"></span>
                            <span data-lrn-qe-input="is_math"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="math_renderer"></span>
                            <span data-lrn-qe-input="math_renderer"></span>
                        </div>
                    </div>

                    <div class="lrn-divider"></div>

                    <!-- Layout -->
                    <span data-lrn-qe-label="ui_style" value="Layout:" class="lrn-h3"></span>

                    <div class="lrn-qe-row-flex">
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="ui_style.type" value="Layout style"></span>
                            <span data-lrn-qe-input="ui_style.type"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="ui_style.fontsize"></span>
                            <span data-lrn-qe-input="ui_style.fontsize"></span>
                        </div>

                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="ui_style.choice_label"></span>
                            <span data-lrn-qe-input="ui_style.choice_label"></span>
                        </div>

                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="ui_style.columns"></span>
                            <span data-lrn-qe-input="ui_style.columns" class="lrn-qe-form-control-sm"></span>
                        </div>

                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="ui_style.orientation"></span>
                            <span data-lrn-qe-input="ui_style.orientation"></span>
                        </div>
                    </div>

                    <div class="lrn-divider"></div>

                    <!-- Details -->
                    <span data-lrn-qe-label="metadata" value="Details:" class="lrn-h3"></span>
                    <div class="lrn-qe-row-flex">
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="metadata.acknowledgements"></span>
                            <span data-lrn-qe-input="metadata.acknowledgements"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="metadata.distractor_rationale" value="Distractor rationale (Global)"></span>
                            <span data-lrn-qe-input="metadata.distractor_rationale"></span>
                        </div>

                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="metadata.rubric_reference"></span>
                            <span data-lrn-qe-input="metadata.rubric_reference"></span>
                        </div>
                        <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <span data-lrn-qe-label="stimulus_review"></span>
                            <span data-lrn-qe-input="stimulus_review"></span>
                        </div>
                    </div>

                    <span data-lrn-qe-label="metadata.distractor_rationale_response_level"></span>
                    <div class="lrn-qe-row-flex">
                        <div data-lrn-qe-loop="metadata.distractor_rationale_response_level[*]" class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
                            <div data-lrn-qe-label="metadata.distractor_rationale_response_level[*]" value="Distractor {{index}}"></div>
                            <div data-lrn-qe-input="metadata.distractor_rationale_response_level[*]"></div>
                        </div>
                    </div>
                    <span data-lrn-qe-action-add="metadata.distractor_rationale_response_level"></span>
                </div>
            </div>
        </div>
    </div>
</div>
        </script>
        <!--/ Custom Layout -->

        <div>
            <button class="btn btn-info btn-review-edit-layout">Review HTML Markup</button>
        </div>
        <div class="my-question-editor"></div>
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
                "description": "",
                "feedback_attempts": "unlimited",
                "is_math": false,
                "metadata": {
                    "acknowledgements": "",
                    "distractor_rationale": "",
                    "rubric_reference": "",
                    "sample_answer": ""
                },
                "multiple_responses": false,
                "options": [{
                    "label": "[Choice A]",
                    "value": "0"
                }, {
                    "label": "[Choice B]",
                    "value": "1"
                }, {
                    "label": "[Choice C]",
                    "value": "2"
                }, {
                    "label": "[Choice D]",
                    "value": "3"
                }],
                "shuffle_options": false,
                "stimulus": "<p>[This is the stem.]</p>",
                "stimulus_review": "",
                "type": "mcq",
                "ui_style": {
                    "fontsize": "normal",
                    "type": ""
                },
                "validation": {
                    "alt_responses": [{
                        "score": 1,
                        "value": ["1"]
                    }],
                    "penalty": 0,
                    "scoring_type": "exactMatch",
                    "valid_response": {
                        "score": 1,
                        "value": ["0"]
                    }
                }
            },
            initOptions = {
                widgetType: 'response',
                widget_json: widget_json,
                ui: {
                    layout: {
                        edit_panel: {
                            mcq: [{
                                layout: 'custom_mcq_layout'
                            }]
                        }
                    }
                },
                dependencies: {
                    questions_api: {
                        init_options: {
                            beta_flags: {
                                reactive_views: true
                            }
                        }
                    }
                }
            },
            qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');

        qeApp.on('widget:ready', function () {
        });

        $(function () {
            var $reviewModal = $('.qe-edit-layout-modal'),
                editLayoutContent = $('[data-lrn-qe-layout="custom_mcq_layout"]').html();

            $reviewModal
                .find('.prettyprint')
                .text(editLayoutContent);
            prettyPrint();

            $('.btn-review-edit-layout').on('click', function () {
                $reviewModal.modal('show');
            })
        });
    </script>
<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
