<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = [
    'user_id'      => $studentid,
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

$request = '{
  "id": "custom-shorttext",
  "name": "Custom Short Text",
  "type": "local_practice",
  "state": "initial",
  "session_id": "' . $session_id . '",
  "questions": [
    {
      "response_id": "custom-shorttext-response-1",
      "type": "custom",
      "js": "//'. $_SERVER['HTTP_HOST'] .'/casestudies/customquestions/custom_shorttext.js",
      "css": "//'. $_SERVER['HTTP_HOST'] .'/casestudies/customquestions/custom_shorttext.css",
      "stimulus": "What is the capital of Australia?",
      "valid_response": "Canberra",
      "score": 1
    }
  ],
    "beta_flags": {
        "reactive_views": true
    }
}';


$init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

?>

<style>
    .custom-score {
        position: absolute;
        font-size: 17px;
        margin-top: 5px;
    }
</style>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/questions/knowledgebase/customquestions" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Custom Question - Short Text</h1>
        <p>Here is a demo which shows an example custom implementation of the Short Text question type.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="question-container">
            <span class="learnosity-response question-custom-shorttext-response-1"></span>
            <div class="custom-score"><strong>Score: </strong> <span id="question_score">0</span> / <span id="question_max_score">0</span></div>
            <button class="btn btn-primary pull-right" id="validate_question">Check Answer</button>
        </div>
    </div>
</div>

<script src="<?php echo $url_questions; ?>"></script>
<script>

    var questionsApp = window.questionsApp = LearnosityApp.init(<?php echo $signedRequest; ?>,  {
        errorListener: window.widgetApiErrorListener,
        readyListener: function () {
            var question = questionsApp.question('custom-shorttext-response-1');

            updateScores(question);

            question.on('changed', function (r) {
                updateScores(question);
            });

            $('#validate_question').off().click(function() {
                questionsApp.validateQuestions();
            });
        }
    });

    function updateScores(question) {
        var score = question.getScore();
        $('#question_score').html((score && score.score) || 0);
        $('#question_max_score').html((score && score.max_score) || 0);
    }

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
