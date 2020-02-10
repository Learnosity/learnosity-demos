<?php
include_once '../env_config.php';
include_once 'includes/header.php';
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

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
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'dr1_no_changes_unless_you_know_the_impact',
        'dr2_no_changes_unless_you_know_the_impact',
        'dr3_no_changes_unless_you_know_the_impact'

    ],
    'config' => [
        'questions_api_init_options' => [
            'show_distractor_rationale' => [
                'per_question' => $per_question,
                'per_response' => $per_response
            ]
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

$Init1 = new Init('items', $security, $consumer_secret, $request1);
$Init2 = new Init('items', $security, $consumer_secret, $request2);
$signedRequest = $Init1->generate();
$signedRequest2 = $Init2->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <p>
            Distractor Rationale provides feedback to educators and students on their response. <br>
            Try choosing an incorrect answer for the questions below and choosing different options to see distractor rationale in action.<br>
            Learnosity provides two out-of-the-box ways for displaying Distractor Rationale in MCQ questions: <br>
            configuring activity initialisation options or using the public method. <br>
            For other MCQ questions or if you would like to implement further hints and feedback, you can write code to display Distractor Rationale and other metadata.<br>
            <li>Demo 1: Display Distractor Rationale (using initialisation options <a href="#demo1">link below</a> </li>
            <li>Demo 2: Display Distractor Rationale with additional custom logic using public methods  <a href="#demo2">link below</a></li>
            <li>Demo 3: Build your own Distractor Rationale display <a href="https://demos.learnosity.com/assessment/distractors.php">link</a></li>
        </p>
    </div>
</div>

    <div class="section pad-sml">
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="height: 85px">
            <div style="position:absolute; right: 10px;">
                <label for="per_question">per_question:</label>

                <select name="per_question" id="per_question" class="btn btn-default dropdown-toggle">
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
                <br>
                <label for="per_response"> per_response:</label>

                <select name="per_response" id="per_response">
                    <option value="always" <?php echo $per_response === 'always' ? 'selected' : null; ?>>always (default)</option>
                    <option value="never" <?php echo $per_response === 'never' ? 'selected' : null; ?>>never</option>
                </select>
            </div>
            <br>
            <div style="position:absolute; right: 10px; top: 80px;">
                <label for="updateStateType">&nbsp;</label>
                <input type="submit" name="updateStateType" value="Update" style="background-color: #eaeaea; border: none"/>
            </div>
        </form>

        <h3 id="demo1">Demo 1: Display Distractor Rationale using initialisation options</h3>
        This is the simplest way to display Distractor Rationale, by configuring activity initialisation options. Learnosity offers a number of options for when Distractor Rationale displays. You can see how these different options will behave with the dropdown options below.
        <hr/>
        <p>
            <span class="learnosity-item" data-reference="dr1_no_changes_unless_you_know_the_impact"></span>
            <span class="learnosity-item" data-reference="dr2_no_changes_unless_you_know_the_impact"></span>
            <span class="learnosity-item" data-reference="dr3_no_changes_unless_you_know_the_impact"></span>
        </p>
    </div>

    <div class="section pad-sml">
        <h3 id="demo2">Demo 2: Display Distractor Rationale with additional custom logic using public methods</h3>
        In this demo, the Distractor Rationale is only shown the second time an answer is checked. Allow the student an opportunity to correct their response, and show the Distractor Rationale feedback on the second attempt
        <hr/>
        <p><span class="learnosity-item" data-reference="dr4_no_changes_unless_you_know_the_impact"></span></p>
        <div style="height: 60px">
            <button
                type="button"
                class="lrn_btn lrn_validate"
                onclick=checkAnswer()
            >
                <span>Check Answer</span>
            </button>
        </div>
    </div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var initializationObject = <?php echo $signedRequest; ?>;
    var itemsApp = LearnosityItems.init(initializationObject);
    var initializationObject2 = <?php echo $signedRequest2; ?>;
    var itemsApp2 = LearnosityItems.init(initializationObject2);

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
    button {
        background-color: #eaeaea;
        border: none;
        line-height: 1.5em;
        padding: 0.6em 1.2em;
        float: right;
        font-weight: 500;
    }

</style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';



