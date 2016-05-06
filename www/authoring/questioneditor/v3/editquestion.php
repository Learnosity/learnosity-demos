<?php

include_once '../../../config.php';
include_once 'includes/header.php';

$request = array(
    'configuration' => array(
        'consumer_key' => $consumer_key
    ),
    'widget_type' => 'response',
    'ui' => array(
        'layout' => array(
            'global_template' => 'edit'
        )
    )
);

$questionJsonMcq = array(
    'options' => array(
        array(
            'label' => '[Choice A]',
            'value' => '0'
        ),
        array(
            'label' => '[Choice B]',
            'value' => '1'
        ),
        array(
            'label' => '[Choice C]',
            'value' => '2'
        ),
        array(
            'label' => '[Choice D]',
            'value' => '3'
        )
    ),
    'stimulus' => '<p>This is the question the student will answer</p>',
    'type' => 'mcq',
    'validation' => array(
        'scoring_type' => 'exactMatch',
        'valid_response' => array(
            'score' => 1,
            'value' => array('')
        )
    )
);

$questionJsonChoiceMatrix = array(
    'stimulus' => '<p>[This is the stem.]</p>',
    'type' => 'choicematrix',
    'options' => array('True', 'False'),
    'stems' => array('[Stem 1]', '[Stem 2]', '[Stem 3]', '[Stem 4]'),
    'validation' => array(
        'scoring_type' => 'exactMatch',
        'valid_response' => array(
            'score' => 1,
            'value' => array(null, null, null, null)
        )
    )
);

$questionJsonAssociation = array(
    'stimulus' => 'In this question, the student needs to match the cities to the parent nation.',
    'type' => 'association',
    'stimulus_list' => array('London', 'Dublin', 'Paris', 'Boston', 'Sydney'),
    'possible_responses' => array('United States', 'Australia', 'France', 'Ireland', 'England'),
    'validation' => array(
        'scoring_type' => 'exactMatch',
        'valid_response' => array(
            'score' => 1,
            'value' => array('England', 'Ireland', 'France', 'United States', 'Australia')
        )
    )
);

// load mcq as default
$request['widget_json'] = $questionJsonMcq;

include_once 'utils/settings-override.php';

$signedRequest = array_merge_recursive(array(), $request);

// remove variable for demo page internal use.
unset($signedRequest['question_type']);

$signedRequest = json_encode($signedRequest);

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings">
                <a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                    <span class="glyphicon glyphicon-list-alt"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object">
                <a href="#" data-toggle="modal" data-target="#initialisation-preview">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation">
                <a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation">
                    <span class="glyphicon glyphicon-book"></span>
                </a>
            </li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box">
                <a href="#">
                    <span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API – Edit Question</h1>
        <p>Setup the Question Editor to directly load a question, bypassing the question tiles screen. For more information refer to <a href="http://docs.learnosity.com/authoring/questioneditor/v3/initialisation#widget_json">the init options docs</a> and <a href="http://docs.learnosity.com/authoring/questioneditor/v3/publicmethods#setWidget">the setWidget</a> public method.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the question editor api to load into -->
    <script src="<?php echo /*$url_questioneditor_v3;*/ "https://questioneditor.vg.learnosity.com"; ?>"></script>
    <div class="my-question-editor"></div>
</div>

<script>
    var initOptions = JSON.parse(<?php echo json_encode($signedRequest)?>);

    var qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');
</script>

<?php
include_once 'views/modals/settings-questioneditor-v3.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
