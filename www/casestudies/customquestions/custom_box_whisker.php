<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = [
    'user_id'      => $studentid,
    'domain'       => $_SERVER['SERVER_NAME'],
    'consumer_key' => $consumer_key
];

$request = '{
  "id": "custom-box-whisker",
  "name": "Custom Box Whisker",
  "type": "local_practice",
  "state": "initial",
  "session_id": "' . $session_id . '",
  "questions": [
    {
      "response_id": "custom-box-whisker-response-1",
      "type": "custom",
      "js": {
        "question":"//' . $_SERVER['HTTP_HOST'] . '/casestudies/customquestions/custom_box_whisker_q_js.php",
        "scorer":"//' . $_SERVER['HTTP_HOST'] . '/casestudies/customquestions/custom_box_whisker_s.js"
      },
      "css": "//' . $_SERVER['HTTP_HOST'] . '/casestudies/customquestions/custom_box_whisker.css",
      "stimulus": "Draw a <b>box &amp; whisker</b> chart for the following: <b>6, 2, 5, 3, 6, 10, 11, 6</b>",
      "params_line_min": 0,
      "params_line_max": 17,
      "params_step": 0.5,
      "params_mark_small": 0,
      "params_mark_big": 1,
      "params_width": 600,
      "params_height": 150,
      "params_range_1": 2,
      "params_range_2": 14,
      "params_quartile_1": 4,
      "params_median": 6,
      "params_quartile_3": 10,
      "params_box1_color": "#bbbbbb",
      "params_box2_color": "#999999",
      "valid_range_1": 2,
      "valid_range_2": 11,
      "valid_quartile_1": 4,
      "valid_median": 6,
      "valid_quartile_3": 8.5,
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
        <h1>Custom Question - Box Whisker</h1>
        <p>Demostrates the implementation of a Custom question with an interactive and more complex UI.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="question-container">
            <span class="learnosity-response question-custom-box-whisker-response-1"></span>
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
            var question = questionsApp.question('custom-box-whisker-response-1');

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
