<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>

<div class='jumbotron'>
    <h1>Question Editor API - Extended Initialisation</h1>
    <p>Our editor. Your item bank platform.<p>
    <div class='row'>
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/questioneditorapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="../../reporting/reports/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="alert alert-info" id="example-description">Description here</div>

<!-- Container for the question editor api to load into -->
<script src="//questioneditor.vg.learnosity.com/?latest"></script>
<div class="learnosity-question-editor"></div>
<script>
    var initOptions = {
        configuration: {
            questionsApiVersion: 'v2'
        },
        question_type_groups: [{
            reference: 'match',
            name: 'Classify, Match & Order'
        }, {
            reference: 'cloze',
            name: 'Fill in the Blanks (Cloze)'
        }, {
            reference: 'mcq',
            name: 'Multiple Choice'
        }],
        question_types: {
            association: {
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/association.png'
            },
            clozetext: {
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/clozet.png'
            },
            mcq: {
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/mcqdefault.png'
            }
        },
        question_type_templates: {
            association: [{
                name: 'Match List',
                description: 'Match reponses with list',
                group_reference: 'match',
                defaults: {
                is_math: true,
                possible_responses: [
                    '[Choice A]',
                    '[Choice B]',
                    '[Choice C]'
                ],
                stimulus: '<p>[This is the STEM.]</p> ',
                stimulus_list: [
                    '[Stem 1]',
                    '[Stem 2]',
                    '[Stem 3]'
                ],
                type: 'association'
                },
                hidden: [
                    'description',
                    'is_math'
                ],
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/association.png'
            }],
            clozetext: [{
                name: 'Cloze Text',
                description: 'Fill in the blanks.',
                group_reference: 'cloze',
                defaults: {
                stimulus: '[This is the STEM.]',
                template: 'Risus {{response}}, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum. Nunc diam enim, porta sed eros vitae. {{response}} dignissim, et tincidunt turpis facilisis. Curabitur eu nulla justo. Curabitur vulputate ut nisl et bibendum.',
                type: 'clozetext'
                },
                hidden: [
                'description'
                ],
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/clozet.png'
            }],
            mcq: [{
                name: 'MCQ Standard',
                description: 'Standard Multiple Choice Question',
                group_reference: 'mcq',
                defaults: {
                    is_math: true,
                    options: [{
                        value: '0',
                        label: '[Choice A]'
                    }, {
                        value: '1',
                        label: '[Choice B]'
                    }, {
                        value: '2',
                        label: '[Choice C]'
                    }, {
                        value: '3',
                        label: '[Choice D]'
                    }],
                    stimulus: '[This is the STEM.]',
                    type: 'mcq'
                },
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/mcqdefault.png',
                hidden: [
                    'description',
                    'penalty_score',
                    'is_math'
                ]
            }, {
                name: 'MCQ Multi Response',
                description: 'Multiple Choice Question with multiple responses',
                group_reference: 'mcq',
                defaults: {
                    is_math: true,
                    multiple_responses: true,
                    options: [{
                        value: '0',
                        label: '[Choice A]'
                    }, {
                        value: '1',
                        label: '[Choice B]'
                    }, {
                        value: '2',
                        label: '[Choice C]'
                    }, {
                        value: '3',
                        label: '[Choice D]'
                    }],
                    stimulus: '[This is the STEM.]',
                    type: 'mcq'
                },
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/mcqmulti.png',
                hidden: [
                    'multiple_responses',
                    'description',
                    'penalty_score',
                    'is_math'
                ]
            }, {
                name: 'MCQ Block UI',
                description: 'Multiple Choice Question with Block UI',
                group_reference: 'mcq',
                defaults: {
                    is_math: true,
                    options: [{
                        value: '0',
                        label: '[Choice A]'
                    }, {
                        value: '1',
                        label: '[Choice B]'
                    }, {
                        value: '2',
                        label: '[Choice C]'
                    }, {
                        value: '3',
                        label: '[Choice D]'
                    }],
                    stimulus: '[This is the STEM.]',
                    type: 'mcq',
                    ui_style: {
                        choice_label: 'upper-alpha',
                        type: 'block'
                    }
                },
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/mcqblock.png',
                hidden: [
                    'description',
                    'penalty_score',
                    'is_math'
                ]
            }, {
                name: 'MCQ Horizontal - 2 Column',
                description: 'Multiple Choice Question column format',
                group_reference: 'mcq',
                defaults: {
                    is_math: true,
                    options: [{
                        value: '1',
                        label: '[Choice A]'
                    }, {
                        value: '2',
                        label: '[Choice B]'
                    }, {
                        value: '3',
                        label: '[Choice C]'
                    }, {
                        value: '4',
                        label: '[Choice D]'
                    }],
                    stimulus: '[This is the Stem.]',
                    type: 'mcq',
                    ui_style: {
                        columns: 2,
                        type: 'horizontal'
                    }
                },
                image: '//dw6y82u65ww8h.cloudfront.net/questiontypes/tiles/mcqcolumn.png',
                hidden: [
                    'description',
                    'penalty_score',
                    'is_math'
                ]
            }]
        },
        template_defaults: false,
        widget_type: 'response'
    };
    LearnosityQuestionEditor.init(initOptions);
</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
