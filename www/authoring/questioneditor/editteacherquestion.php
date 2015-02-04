<?php

include_once '../../config.php';
include_once 'includes/header.php';

$request = array(
    'base_question_type' => array(
        'hidden'   => ["duplicate_responses", "instant_feedback", "feedback_attempts", "validation.penalty", "validation.scoring_type", "validation.alt_responses", "validation.valid_response.score"],
        'attribute_groups' => array(
            array(
                'reference' => 'basic',
                'name'      => 'Basic'
            ),
            array(
                'reference' => 'validation',
                'name'      => 'Validation'
            ),
        ),
    ),
    'template_defaults' => true,
    'widget_type'       => 'response',
    'widget_json'       => array(
        'stimulus_list' => ["Stem A", "Stem B", "Stem C"],
        'possible_responses' => ["Option 1", "Option 2", "Option 3"],
        'stimulus' => '<p>Enter your question here</p>',
        'type' => 'association',
        'validation' => array(
            'scoring_type' => 'exactMatch',
            'valid_response' => array(
                'score' => 1,
                'value' => array('', '', '')
            )
        )
    ),
    'ui' => array(
        'public_methods'     => array(),
        'layout'             => '2-column',
        'question_tiles'     => false,
        'documentation_link' => false,
        'change_button'      => false,
        'source_button'      => false,
        'fixed_preview'      => true,
        'advanced_group'     => true,
        'search_field'       => true
    ),
    'configuration'     => array(
        'questionsApiVersion' => 'v2'
    )
);

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
        <h1>Question Editor API – Teacher Templates</h1>
        <p>Create templates suitable for teacher authoring.<p>
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
