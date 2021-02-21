<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$session_id = Uuid::generate();

$security = [
    'user_id'      => 'demo_student_123',
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

$init = new Init('questions', $security, $consumer_secret, [
    'id'                   => 'custom-shorttext',
    'name'                 => 'Custom Short Text',
    'type'                 => 'local_practice',
    'state'                => 'initial',
    'session_id'           => $session_id
]);

$request = '{
  "response_id": "custom-shorttext-response-' . $session_id . '",
  "type": "custom",
  "js": {
    "question":"//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_shorttext_q.js",
    "scorer":"//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_shorttext_s.js"
  },
  "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_shorttext.css",
  "stimulus": "What is the capital of Australia?",
  "valid_response": "Canberra",
  "score": 1
}';

?>

<style>
    .custom-score {
        position: absolute;
        font-size: 17px;
        margin-top: 5px;
    }
    .editor{
        margin-bottom: 15px;
    }
</style>

<div class="jumbotron section">
     <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/articles/360000758817-Creating-Custom-Questions" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

        </ul>
    </div>
    <div class="overview">
        <h1>Custom Question - Short Text</h1>
        <p>Here is a demo which shows an example custom implementation of the Short Text question type. You can rewrite the question JSON to define your own custom questions.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="col-md-6">
            <h2 class="page-heading">Question JSON</h2>
            <div id="editor" class="editor"><?php echo htmlspecialchars($request);?></div>
        </div>
        <div class="col-md-6">
            <h2 class="page-heading">Preview</h2>
            <div id="custom_question_wrapper"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-primary pull-right" id="render_custom_question">Render JSON</button>
        </div>
        <div class="col-md-6">
            <div class="custom-score"><strong>Score: </strong> <span id="question_score">0</span> / <span id="question_max_score">0</span></div>
            <button class="btn btn-primary pull-right" id="validate_question">Check Answer</button>
        </div>
    </div>
</div>

<script src="<?php echo $url_questions; ?>"></script>
<script src="/static/vendor/ace/ace-builds/src-min-noconflict/ace.js"></script>

<script>
    var activity = <?php echo $init->generate(); ?>;
    var editor = ace.edit('editor');
        editor.setTheme('ace/theme/kuroir');
        editor.getSession().setMode('ace/mode/json');
        editor.setShowPrintMargin(false);
        editor.setOptions({
            maxLines: 25
        });
        editor.navigateFileEnd();
        editor.focus();


    $(function(){

        function init() {
            var json;

            try {
                json = JSON.parse(editor.getValue());
            } catch (e) {
                console.error('JSON is invalid');
                return;
            }

            $('#custom_question_wrapper').html(
                '<span class="learnosity-response question-'+json.response_id+'"></span>'
            );

            activity.questions = [json];

            var questionsApp = window.questionsApp = LearnosityApp.init(activity, {
                errorListener: window.widgetApiErrorListener,
                readyListener: function () {
                    var question = questionsApp.question(json.response_id);

                    updateScores(question);

                    question.on('changed', function (r) {
                        updateScores(question);
                    });

                    $('#validate_question').off().click(function() {
                        questionsApp.validateQuestions();
                    });
                }
            });
        }

        function updateScores(question) {
            var score = question.getScore();
            $('#question_score').html((score && score.score) || 0);
            $('#question_max_score').html((score && score.max_score) || 0);
        }

        init();

        $('#render_custom_question').click(init);

    });

</script>

<?php
    include_once 'includes/footer.php';
