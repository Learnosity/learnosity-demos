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
        'id'                   => 'custom-shorttext',
        'name'                 => 'Custom Short Text',
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

<script src="//questions.learnosity.com"></script>
<script>
    var activity = <?php echo $init->generate(); ?>;

    var customQuestionJson = {
        "response_id": "custom-shorttext-response-1",
        "type": "custom",
        "js": "//<?php echo $_SERVER['HTTP_HOST'] ?>/casestudies/items/customquestions/custom_shorttext.js",
        "css": "//<?php echo $_SERVER['HTTP_HOST'] ?>/casestudies/items/customquestions/custom_shorttext.css",
        "stimulus": "What is the capital of Australia?",
        "valid_response": "Canberra",
        "score": 1
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
