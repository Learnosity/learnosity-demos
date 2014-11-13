<?php

include_once '../../config.php';
include_once 'includes/header.php';

$request = [
    'base_question_type' => [
        'hidden'   => [],
        'attribute_groups' => [
            [
                'reference' => 'basic',
                'name'      => 'Basic'
            ],
            [
                'reference' => 'formatting',
                'name'      => 'Formatting'
            ],
            [
                'reference' => 'validation',
                'name'      => 'Validation'
            ],
            [
                'reference' => 'metadata',
                'name'      => 'Metadata'
            ],
            [
                'reference' => 'advanced',
                'name'      => 'Advanced'
            ]
        ],
    ],
    'template_defaults' => true,
    'widget_type'       => 'response',
    'widget_json'       => [
        'options' => [
            [
                'label' => '[Choice A]',
                'value' => '0'
            ],
            [
                'label' => '[Choice B]',
                'value' => '1'
            ],
            [
                'label' => '[Choice C]',
                'value' => '2'
            ],
            [
                'label' => '[Choice D]',
                'value' => '3'
            ]
        ],
        'stimulus' => '<p>This is the question the student will answer</p>',
        'type' => 'mcq',
        'validation' => [
            'scoring_type' => 'exactMatch',
            'valid_response' => [
                'score' => 1,
                'value' => ['']
            ]
        ]
    ],
    'ui' => [
        'public_methods' => [],
        'layout'             => '2-column',
        'question_tiles'     => false,
        'documentation_link' => false,
        'change_button'      => true,
        'source_button'      => true,
        'fixed_preview'      => true
    ],
    'configuration'     => [
        'questionsApiVersion' => 'v2'
    ]
];

$removeOverrideFields = ['widget_type'];

include_once 'utils/settings-override.php';

$signedRequest = $request;
// Cleanup JSON object to make the preview more readable
unset($signedRequest['accordion-order']);
$signedRequest = json_encode($signedRequest);

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API – Edit Question</h1>
        <p>Setup the Question Editor to directly load a question, bypassing the question tiles screen.<p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <script src="//questioneditor.learnosity.com?v2"></script>
    <div class="learnosity-question-editor"></div>
</div>

<script>
    var init, questionEditorApp;

    init = <?php echo $signedRequest; ?>;

    questionEditorApp = LearnosityQuestionEditor.init(init);
</script>

<?php
    include_once 'views/modals/settings-questioneditor.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
