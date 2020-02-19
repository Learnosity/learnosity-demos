<?php
include_once '../env_config.php';
include_once 'includes/header.php';
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$consumer_key = 'yis0TYCu7U9V4o7M';
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];
$per_question = 'incorrect';
$per_response = 'always';

if(isset($_POST['updateStateType'])) {
    $per_question = $_POST['per_question'];
    $per_response = $_POST['per_response'];
}

$request1 = [
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'organisation_id'=> 505,
    'items' => [
        'Sci-Demo-1',
        'Sci-Demo-2',
        'Sci-Demo-3',
    ],
    'config' => [
        'configuration' => [
            "onsave_redirect_url" => $_SERVER['REQUEST_URI'],
            "onsubmit_redirect_url" => $_SERVER['REQUEST_URI'],
        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => [
                'per_question' => $per_question,
                'per_response' => $per_response
            ]
        ],
        'navigation' => [
            'scroll_to_test' => false,
        ]
    ]
];

$request2 = [
    'name' => 'Items API demo - assess activity2',
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'dr4_no_changes_unless_you_know_the_impact'
    ]
];

$request3 = [
    'activity_id' => 'distractorsdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6',
        'act8'
    ]
];

$Init1 = new Init('items', $security, $consumer_secret, $request1);
$Init2 = new Init('items', $security, $consumer_secret, $request2);
$Init3 = new Init('items', $security, $consumer_secret, $request3);
$signedRequest = $Init1->generate();
$signedRequest2 = $Init2->generate();
$signedRequest3 = $Init3->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h2>Display Distractor Rationale</h2>
        <p>
            Distractor Rationale provides feedback to educators and students on their response. Learnosity provides two ways for Authors to associate distractor rationale: per question or per response. Distractor rationale per question is intended as feedback for an entire question, whereas distractor rationale per response allows Authors to write unique feedback against each possible response. 
        </p>
        <p>
        In Assessments and Reports, Learnosity provides two out-of-the-box methods for displaying distractor rationale for MCQ questions: 
        </p>
        <ol>
            <li><h4>configuring activity initialization options, or</h4></li>
            <li><h4>using the public method.</h4></li>
        </ol>
        <p>
        For questions other than MCQ or if you would like to implement further hints and feedback, you can write code to display Distractor Rationale and other metadata.
        </p>
        <ul>
            <li><h4><a href="#demo1">Demo 1: Display Distractor Rationale (using initialization options)</a></h4></li>
            <li><h4><a href="#demo2">Demo 2: Display Distractor Rationale with additional custom logic using public methods</a></h4></li>
            <li><h4><a href="#demo3">Demo 3: Build your own Distractor Rationale display</a></h4></li>

        </ul>
    </div>
</div>

    <div class="section pad-sml">
        <h3 id="demo1">Demo 1: Display Distractor Rationale using initialization options</h3>
        This is the simplest way to display Distractor Rationale, by configuring activity initialization options. Learnosity offers a number of options for when Distractor Rationale displays. You can see how these different options will behave with the dropdown options below.
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">

            <label for="per_question">per_question:</label>
            <select name="per_question" id="per_question">
                <option value="incorrect" <?php echo $per_question === 'incorrect' ? 'selected' : null; ?>>
                    incorrect (default)
                </option>
                <option value="correct" <?php echo $per_question === 'correct' ? 'selected' : null; ?>>
                    correct
                </option>
                <option value="always" <?php echo $per_question === 'always' ? 'selected' : null; ?>>
                    always
                </option>
                <option value="never" <?php echo $per_question === 'never' ? 'selected' : null; ?>>
                    never
                </option>
            </select>

            <label for="per_response"> per_response:</label>
            <select name="per_response" id="per_response">
                <option value="always" <?php echo $per_response === 'always' ? 'selected' : null; ?>>always (default)</option>
                <option value="never" <?php echo $per_response === 'never' ? 'selected' : null; ?>>never</option>
            </select>

            <input type="submit" name="updateStateType" value="Update" class="updateButton"/>
        </form>
        <hr/>
        <div id="learnosity_assess"></div>
    </div>

    <div class="section pad-sml">
        <h3 id="demo2">Demo 2: Display Distractor Rationale with additional custom logic using public methods</h3>
        In this demo, the Distractor Rationale is only shown the second time an answer is checked. Allow the student an opportunity to correct their response, and show the Distractor Rationale feedback on the second attempt
        <hr/>
        <p><span class="learnosity-item" data-reference="dr4_no_changes_unless_you_know_the_impact"></span></p>
        <div style="height: 60px">
            <button
                type="button"
                class="checkAnswerButton"
                onclick=checkAnswer()
            >
                <span>Check Answer</span>
            </button>
        </div>
    </div>

    <div class="section pad-sml">
        <h3 id="demo3">Demo 3: Build your own Distractor Rationale display</h3>
        You can use the <a href="https://reference.learnosity.com/questions-api/methods#learnosityApp-RenderMath">renderMath()</a> method to render any Latex or MathML elements in the distractor rationale.
        <br>For an example of how to implement distractor rationale, refer to <a href="https://support.learnosity.com/hc/en-us/articles/360000754818-Tutorial-202-Displaying-Distractor-Rationale">this tutorial.</a>
        <hr/>
        <p>
            <span class="learnosity-item" data-reference="act1"></span>
            <span class="learnosity-item" data-reference="act2"></span>
            <span class="learnosity-item" data-reference="act3"></span>
            <span class="learnosity-item" data-reference="act4"></span>
            <span class="learnosity-item" data-reference="act5"></span>
            <span class="learnosity-item" data-reference="act6"></span>
            <span class="learnosity-item" data-reference="act8"></span>
        </p>
    </div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var initializationObject = <?php echo $signedRequest; ?>;
    var itemsApp = LearnosityItems.init(initializationObject);
    var initializationObject2 = <?php echo $signedRequest2; ?>;
    var itemsApp2 = LearnosityItems.init(initializationObject2);

    //optional callbacks for ready
    var callbacks = {
        readyListener: function () {

            $.each(itemsApp3.questions(), function (index, question) {
                question.on('validated', function () {
                    var outputHTML = '';
                    var map, qid;
                    if (question.isValid()) {
                        return;
                    }


                    if(question.mapValidationMetadata('distractor_rationale_response_level') != false){
                        map = question.mapValidationMetadata('distractor_rationale_response_level');
                        $.each(map.incorrect, function (i, data) {
                            /*  Each item in the `map.incorrect` array is an object that contains a `value` property that
                                holds the response value; an `index` property that refers to the shared index of both the
                                response area and the metadata; and a `metadata` property containing the metadata value. */

                            var distractor = data.metadata;

                            outputHTML += '<li>' + distractor + '</li>';
                        });
                        if (outputHTML) {
                            outputHTML = '<ul>' + outputHTML + '</ul>';
                        }
                    }else if(question.getMetadata().distractor_rationale){
                        outputHTML = question.getMetadata().distractor_rationale;
                    }

                    if (!outputHTML) {
                        outputHTML = 'Have you answered all possible responses?';
                    }
                    qid = question.getQuestion().response_id;
                    renderDistractor(qid, outputHTML);
                });
            });

            $.each(itemsApp3.questions(), function (index, question) {
                question.on('changed', function () {
                    removeDistractor(this.getQuestion().response_id);
                });
            });

        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    var initializationObject3 = <?php echo $signedRequest3; ?>;
    var itemsApp3 = LearnosityItems.init(initializationObject3, callbacks);

    // Host page rendering logic
    function renderDistractor (id, content) {
        var template;
        if ($("#" + id + "_distractor").length) {
            $("#" + id + "_distractor").html(content).fadeIn();
        } else {
            template = "<div id=\"" + id + "_distractor\" class=\"distractor-rationale alert alert-danger\">" + content + "</div>";
            $("#" + id).append(template);
        }

        // renderMath() Renders all Latex or MathML elements on the page with MathJax.
        itemsApp.questionsApp().renderMath();
    }
    function removeDistractor (id) {
        $("#" + id + '_distractor').fadeOut();
    }

    function checkAnswer() {
        let demo2Question = itemsApp2.questions()[Object.keys(itemsApp2.questions())[0]];
        demo2Question.validate({feedbackAttempts: true});

        let feedbackAttemptsCount = itemsApp2.getResponses()[Object.keys(itemsApp2.getResponses())[0]].feedbackAttemptsCount;

        if (feedbackAttemptsCount > 1) {
            demo2Question.validate({'showDistractorRationale': true});
        }
    }
</script>

<style>
    form {
        height: 50px;
        padding-top: 15px;
    }
    label {
        font-size: 16px;
    }
    .checkAnswerButton {
        background-color: #eaeaea;
        border: none;
        line-height: 1.5em;
        padding: 0.6em 1.2em;
        float: right;
        font-weight: 500;
        font-family: LearnosityMath, "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .updateButton {
        color: #ffffff;
        background-color: #ef3232;
        width: 82px;
        height: 36px;
        border-radius: 8px;
        border: none;
        font-weight: 700;
    }
    select {
        width: 160px;
        height: 36px;
        margin-right: 20px;
    }

</style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';



