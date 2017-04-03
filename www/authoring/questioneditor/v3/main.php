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
<div class="section">
    <!-- Container for the question editor api to load into -->
    <script src="https://questioneditor.vg.learnosity.com/?latest"></script>
    <div class="margin-bottom-small">
        <button type="button" class="lrn-question-button btn btn-default">Question</button>
        <button type="button" class="lrn-feature-button btn btn-default">Feature</button>
    </div>

    <div class="learnosity-question-editor"></div>
</div>
<script type="text/template" data-lrn-qe-layout="mcq_1">
    <div class="lrn-qe-edit-form">
        <span data-lrn-qe-label="stimulus"></span>
        <span data-lrn-qe-input="stimulus" class="lrn-qe-ckeditor-lg"></span>

        <span data-lrn-qe-label="options"></span>
        <div data-lrn-qe-loop="options[*]">
            <span data-lrn-qe-input="options[*]"></span>
        </div>
        <span data-lrn-qe-action-add="options"></span>

        <!-- Validation -->
        <span data-lrn-qe-label="validation"></span>
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

        <div class="lrn-qe-row-flex">
            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                <span data-lrn-qe-label="multiple_responses"></span>
                <span data-lrn-qe-input="multiple_responses"></span>
            </div>
            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                <span data-lrn-qe-label="shuffle_options"></span>
                <span data-lrn-qe-input="shuffle_options"></span>
            </div>
        </div>

        <div class="lrn-qe-divider"></div>

        <!-- More options -->
        <!-- <label class="lrn-qe-form-label lrn-qe-margin-top-none" data-lrn-qe-adv-toggle>
            <span class="lrn-qe-i-arrow lrn-qe-inline-block"></span>
        <span class="lrn-qe-inline-block lrn-qe-text-bold">
            <label class="lrn-qe-label lrn-qe-form-label-name" data-lrn-qe-i18n-label="heading.moreOptions" value="More options" ></label>
        </span>
        </label> -->

        <div <!-- data-lrn-qe-adv-content -->>
            <div class="lrn-qe-row-flex">
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="instant_feedback"></span>
                    <span data-lrn-qe-input="instant_feedback"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="feedback_attempts"></span>
                    <span data-lrn-qe-input="feedback_attempts" class="lrn-qe-form-control-sm"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="validation.scoring_type"></span>
                    <span data-lrn-qe-input="validation.scoring_type"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="validation.rounding"></span>
                    <span data-lrn-qe-input="validation.rounding"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="validation.penalty"></span>
                    <span data-lrn-qe-input="validation.penalty" class="lrn-qe-form-control-sm"></span>
                </div>
            </div>

            <div class="lrn-qe-row-flex">
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="is_math"></span>
                    <span data-lrn-qe-input="is_math"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="math_renderer"></span>
                    <span data-lrn-qe-input="math_renderer"></span>
                </div>
            </div>

            <!-- Layout -->
            <div class="lrn-qe-form-label lrn-qe-h4 lrn-qe-section-header">
                <label class="lrn-qe-label lrn-qe-form-label-name" data-lrn-qe-i18n-label="heading.layout" value="Layout:" ></label>
            </div>

            <div class="lrn-qe-row-flex">
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="ui_style.type"></span>
                    <span data-lrn-qe-input="ui_style.type"></span>
                </div>

                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="ui_style.columns"></span>
                    <span data-lrn-qe-input="ui_style.columns" class="lrn-qe-form-control-sm"></span>
                </div>

                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="ui_style.orientation"></span>
                    <span data-lrn-qe-input="ui_style.orientation"></span>
                </div>

                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="ui_style.choice_label"></span>
                    <span data-lrn-qe-input="ui_style.choice_label"></span>
                </div>

                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="ui_style.fontsize"></span>
                    <span data-lrn-qe-input="ui_style.fontsize"></span>
                </div>
            </div>

            <!-- Details -->
            <div class="lrn-qe-form-label lrn-qe-h4 lrn-qe-section-header">
                <label class="lrn-qe-label lrn-qe-form-label-name" data-lrn-qe-i18n-label="heading.details" value="Details:" ></label>
            </div>

            <div class="lrn-qe-row-flex">
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="metadata.acknowledgements"></span>
                    <span data-lrn-qe-input="metadata.acknowledgements"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="metadata.distractor_rationale"></span>
                    <span data-lrn-qe-input="metadata.distractor_rationale"></span>
                </div>

                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="metadata.rubric_reference"></span>
                    <span data-lrn-qe-input="metadata.rubric_reference"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="stimulus_review"></span>
                    <span data-lrn-qe-input="stimulus_review"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="instructor_stimulus"></span>
                    <span data-lrn-qe-input="instructor_stimulus"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="metadata.sample_answer"></span>
                    <span data-lrn-qe-input="metadata.sample_answer"></span>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6" data-lrn-qe-layout-wrapper>
                    <span data-lrn-qe-label="description"></span>
                    <span data-lrn-qe-input="description"></span>
                </div>
            </div>

            <span data-lrn-qe-label="metadata.distractor_rationale_response_level"></span>
            <div data-lrn-qe-loop="metadata.distractor_rationale_response_level[*]">
                <div data-lrn-qe-label="metadata.distractor_rationale_response_level[*]"></div>
                <div data-lrn-qe-input="metadata.distractor_rationale_response_level[*]"></div>
            </div>
            <span data-lrn-qe-action-add="metadata.distractor_rationale_response_level"></span>
        </div>
        <div class="lrn-qe-divider"></div>
    </div>
</script>
<script>
    var initOptions = {
        configuration: {
            consumer_key: '<?php echo $consumer_key; ?>'
        },
        rich_text_editor: {
            type: 'ckeditor'
        },
        widget_type: 'response',
        base_question_type: {
            exclude_options: {
                'validation.scoring_type': ['partialMatchV2'],
                'ui_style.fontsize': ["large", "xlarge"]
            }
        },
        ui: {
            layout: {
                global_template: 'edit_preview',
                edit_panel: {
                    mcq: [{
                        layout: 'mcq_1'
                    }]
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
