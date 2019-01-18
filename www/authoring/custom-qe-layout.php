<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'widgetType'=> 'response',
                    'ui' => [
                        'layout'=> [
                            'edit_panel'=> [
                                'mcq'=> [
                                    [
                                        'layout'=> 'custom_mcq_layout'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <style>
        .panel-title {
            padding-left: 20px;
        }
        .panel-group {
            margin-top: 20px;
        }
        .panel.panel-default {
            min-height: 0px;
        }
        #accordion .panel {
            border-radius: 0;
        }
        #accordion .panel-heading {
            background: #666;
            border-radius: 0;
        }
        #accordion .panel-heading a {
            color: white;
        }
        #accordion .panel-heading a:hover {
            color: #ccc;
        }
    </style>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Customize the Question Editing Layout</h2>
            <p>Our editor. Your item bank. You can customize the Question Editor's layout to suit your authoring and design needs. For more information, refer to <a href="https://support.learnosity.com/hc/en-us/articles/360000755258-Adding-a-Custom-Editor-Layout-for-a-Question-Type" target="blank">the docs page</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>

    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks
        var callbacks = {
            readyListener: function () {
                // navigate to new MCQ question to demonstrate the layout
                authorApp.navigate(
                    'items/new/widgets/new/' + encodeURIComponent(JSON.stringify({
                        widgetTemplate: {
                            template_reference: '9e8149bd-e4d8-4dd6-a751-1a113a4b9163'
                        }
                    }))
                );
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

    </script>

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

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
