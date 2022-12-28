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
    'user_id'      => 'demos-site',
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

$request = '{
  "id": "custom-clock",
  "name": "Custom Clock",
  "type": "local_practice",
  "state": "initial",
  "session_id": "' . $session_id . '",
  "questions": [
    {
      "response_id": "custom-clock-response-1",
      "type": "custom",
      "stimulus": "Oh no! The hands on the clock have gotten all messed up! Help fix the clock by moving the hands to show what time it is! <br><strong>Drag the hands to show 4:30 on the clock.</strong>",
      "js": {
        "question": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_q.js",
        "scorer": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock_s.js"
      },
      "css": "//' . $_SERVER['HTTP_HOST'] . '/usecases/customquestions/custom_clock.css",
      "instant_feedback": true,
      "valid_response" : {
        "hourHandAngle": 45, 
        "minHandAngle": 90
      },
      "score":1
    }
  ]
}';


$init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

?>

<style>
    .custom-score {
        font-size: 17px;
        margin-top: 5px;
    }
</style>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/articles/360000758817-Creating-Custom-Questions" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

        </ul>
    </div>
    <div class="overview">
        <h1>Custom Question - Clock</h1>
        <p>Demonstrates the implementation of a Custom question with an interactive and more complex UI.</p>
        <a href="https://github.com/Learnosity/custom-questions-skeleton/tree/master/demos/clock">View full question sourcecode here</a>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="question-container">
            <span class="learnosity-response question-custom-clock-response-1"></span>
            <div class="client-save-wrapper">
                <span class="learnosity-save-button"></span>
            </div>
            <div class="custom-score">
                <strong>Score: </strong><span id="question_score">0</span> / <span id="question_max_score">0</span>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url_questions; ?>"></script>
<script>

    var questionsApp = window.questionsApp = LearnosityApp.init(<?php echo $signedRequest; ?>,  {
        errorListener: window.widgetApiErrorListener,
        readyListener: function () {
            var question = questionsApp.question('custom-clock-response-1');

            updateScores(question);

            question.on('changed', function (r) {
                updateScores(question);
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
