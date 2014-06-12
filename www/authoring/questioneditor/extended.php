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
            reference: 'mcq',
            name: 'Overridden MCQ Name'
        }, {
            reference: 'custom',
            name: 'My Custom Group'
        }],
        question_type_templates: {
            association: [{
                defaults: {
                    type: 'association',
                    feedback_attempts: 5,
                    instant_feedback: true,
                    stimulus: '<p>Question stimulus goes here.</p>',
                    validation: {
                        partial_scoring: true,
                        penalty_score: -0.5,
                        valid_score: 1
                    }
                },
                group_reference: 'custom',
                name: 'My custom association'
            }],
            clozetext: [{
                group_reference: 'custom',
                hidden: [
                    'character_map', 'description', 'feedback_attempts',
                    'instant_feedback', 'is_math', 'max_length',
                    'metadata', 'response_container', 'spellcheck', 'stimulus_review'
                ],
                name: 'My custom clozetext'
            }],
            mcq: [{
                defaults: {
                    options: [
                        { label: 'Dublin', value: '1' },
                        { label: 'Bristol', value: '2' },
                        { label: 'Liverpool', value: '3' },
                        { label: 'London', value: '4' }
                    ]
                },
                description: 'Multiple Choice question with block style and predefined options.',
                group_reference: 'custom',
                name: 'My Block Style MCQ',
                ui_style: {
                    type: 'block',
                    columns: 1,
                    choice_label: 'upper-alpha'
                }
            }]
        },
        widget_type: 'response'
    };
    LearnosityQuestionEditor.init(initOptions);
</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
