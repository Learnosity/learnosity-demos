<?php
    include_once '../../../config.php';
    include_once 'includes/header.php';

    use LearnositySdk\Request\Init;
    use LearnositySdk\Utils\Uuid;

    $session_id = Uuid::generate();

    $security = [
    'user_id'      => $studentid,
    'domain'       => $_SERVER['SERVER_NAME'],
    'consumer_key' => $consumer_key,
    'timestamp'    => gmdate('Ymd-Hi')
    ];
    $init = new Init('questions', $security, $consumer_secret, [
        'id'                   => 'custom-mathcore',
        'name'                 => 'Custom Mathcore',
        'course_id'            => $courseid,
        'type'                 => 'local_practice',
        'state'                => 'initial',
        'session_id'           => $session_id
        ]);

?>

<style>    
    .custom-score {
        position: absolute;
        font-size: 17px;
        margin-top: 5px;
    } 
</style>

<div class="jumbotron section">       
    <div class="overview">
        <h1>Custom Question - Mathcore</h1>
        <p>Math Custom question using Learnosity Mathcore</p>
    </div>
</div>

<div class="section">        
    <div class="row">
        <div class="question-container">
            <span class="learnosity-response question-custom-mathcore-response-1"></span>
            <div class="custom-score"><strong>Score: </strong> <span id="question_score">0</span> / <span id="question_max_score">0</span></div>            
            <button class="btn btn-primary pull-right" id="validate_question">Check Answer</button>
        </div>
    </div>
</div>    

<script src="//questions.learnosity.com"></script>
<script>
    var activity = <?php echo $init->generate(); ?>;

    var customQuestionJson = {
        "response_id": "custom-mathcore-response-1",
        "type": "custom",
        "js": "//<?php echo $_SERVER['HTTP_HOST'] ?>/casestudies/items/customquestions/custom_mathcore.js",
        "css": "//<?php echo $_SERVER['HTTP_HOST'] ?>/casestudies/items/customquestions/custom_mathcore.css",
        "stimulus": "Simplify following expression: <b>\\(2x^2 + 3x - 5 + 5x - 4x^2 + 20\\)</b>",
        "is_math": true,
        "score": 1,
        "specs": [{
                    "method": "isSimplified"
                  }, {
                    "method": "equivSymbolic",
                    "value": "2x^2 + 3x - 5 + 5x - 4x^2 + 20"
        }]
    };

    activity.questions = [customQuestionJson];

    var questionsApp = window.questionsApp = LearnosityApp.init(activity,  {
        errorListener: window.widgetApiErrorListener,
        readyListener: function () {
            var question = questionsApp.question(customQuestionJson.response_id);

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
    include_once 'includes/footer.php';
