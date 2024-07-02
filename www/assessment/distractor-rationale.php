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

/**
 * Demo 1 on this page is interactive, the end-user can select different
 * options used to initialize the Items API via form drop down elements.
 */
$per_question = 'incorrect';
$per_response = 'always';


$updateStateType = filter_input(INPUT_POST, 'updateStateType', FILTER_SANITIZE_FULL_SPECIAL_CHARS, [ 'default' => null ]);
if (!is_null($updateStateType)) {
    $per_question = filter_input(INPUT_POST, 'per_question', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $per_response = filter_input(INPUT_POST, 'per_response', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Initialization options for Demo 1
$request1 = [
    'name' => 'Items API demo - distractor rationale',
    'rendering_type' => 'assess',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-1'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-2'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-3'
        ],
    ],
    'config' => [
        'regions' => 'main',
        'configuration' => [
            'onsave_redirect_url' => $_SERVER['REQUEST_URI'],
            'onsubmit_redirect_url' => $_SERVER['REQUEST_URI'],
            'decouple_submit_from_review' => true
        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => [
                'per_question' => $per_question,
                'per_response' => $per_response
            ]
        ],
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false,
            'show_intro' => false
        ]
    ]
];

// Initialization options for Demo 2, using Items API inline rendering mode
$request2 = [
    'name' => 'Items API demo - assess activity2',
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        [
            'id' => 'dr4_no_changes_unless_you_know_the_impact',
            'reference' => 'dr4_no_changes_unless_you_know_the_impact'
        ]
    ]
];

// Initialization options for Demo 3
$request3 = [
    'activity_id' => 'distractorsdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => 'act1',
            'reference' => 'act1'
        ],
        [
            'id' => 'act2',
            'reference' => 'act2'
        ],
        [
            'id' => 'act3',
            'reference' => 'act3'
        ],
        [
            'id' => 'act4',
            'reference' => 'act4'
        ],
        [
            'id' => 'act5',
            'reference' => 'act5'
        ],
        [
            'id' => 'act6',
            'reference' => 'act6'
        ],
        [
            'id' => 'act8',
            'reference' => 'act8'
        ]
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
            Distractor Rationale provides feedback to educators and students on their response. Learnosity provides two ways
            for Authors to associate distractor rationale: <code>per_question</code> or <code>per_response</code>. Distractor
            rationale <em>per question</em> is intended as feedback for an entire question, whereas distractor rationale <em>per
            response</em> allows Authors to write unique feedback against each possible response.
        </p>
        <p>
            Learnosity provides two approaches to display distractor rationale:
        </p>
        <ol>
            <li><p>Initialization options</p></li>
            <li><p>JavaScript method</p></li>
        </ol>
        <p>
            Currently, we provide out of the box support for Multiple choice, Cloze with drop down, Cloze with drag & drop, Cloze with text.
            If you would like to implement further hints and feedback, you can write custom code to display Distractor Rationale and other metadata.
        </p>
        <ul>
            <li><p><a href="#demo1">Demo 1: Display Distractor Rationale (using initialization options)</a></p></li>
            <li><p><a href="#demo2">Demo 2: Display Distractor Rationale with additional custom logic using methods</a></p></li>
            <li><p><a href="#demo3">Demo 3: Build your own Distractor Rationale display</a></p></li>
        </ul>
    </div>
</div>

<div class="section pad-sml">
    <h3 id="demo1">Demo 1: Display Distractor Rationale using initialization options</h3>
    <p>This is the simplest way to display Distractor Rationale, by configuring Items API initialization options. Learnosity
    offers a number of ways to render Distractor Rationale to the end user. You can see how these different options behave
    using the dropdown elements below.</p>
    <hr>
    <form method="post">
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

        <input type="submit" name="updateStateType" value="Update" class="updateButton">
    </form>
    <div id="learnosity_assess"></div>
</div>

<div class="section pad-sml">
    <h3 id="demo2">Demo 2: Display Distractor Rationale with additional custom logic using public methods</h3>
    <p>In this demo, the Distractor Rationale is only shown the second time an answer is checked. Allowing the student
    to correct their response, and show the Distractor Rationale feedback on the second attempt. Rationale is rendered
    using the <a href="https://reference.learnosity.com/questions-api/methods/question/validate">validate()</a> method.</p>
    <hr>
    <p><span class="learnosity-item" data-reference="dr4_no_changes_unless_you_know_the_impact"></span></p>
    <!-- Display a custom button under the question. On click, we call a JavaScript method to render the distractor rationale -->
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
    <p>You can also render Distractor Rationale using a custom UI. Authors create distractor rationale as normal in the
    Authoring tools, from there, a developer can render the content according to their design guidelines.</p>
    <p>This demo uses the <a href="https://reference.learnosity.com/questions-api/methods/question/mapValidationMetadata">mapValidationMetadata()</a> method
    to map the authored Distractor Rationale to the MCQ response options.</p>
    <p>You can also use the <a href="https://reference.learnosity.com/questions-api/methods/learnosityApp/renderMath">renderMath()</a>
    method to render any LaTeX or MathML elements that have been created in the Distractor Rationale.</p>
    <p>For a deeper example of how to implement custom distractor rationale, refer to <a href="https://help.learnosity.com/hc/en-us/articles/360000754818-Tutorial-202-Displaying-Distractor-Rationale">
    this tutorial.</a></p>
    <hr>
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
    var initializationObject2 = <?php echo $signedRequest2; ?>;
    var initializationObject3 = <?php echo $signedRequest3; ?>;

    /**
     * Method used to trigger distractor rationale for Demo 2
     * If the student clicks 'Check Answer' more than once, render
     * the distractor rationale via a method
     */
    function checkAnswer() {
        let demo2Question = itemsApp2.questions()[Object.keys(itemsApp2.questions())[0]];

        demo2Question.validate({
            feedbackAttempts: true
        });

        let feedbackAttemptsCount = demo2Question.getResponse().feedbackAttemptsCount;

        if (feedbackAttemptsCount > 1) {
            demo2Question.validate({
                showDistractorRationale: true
            });
        }
    }

    // Callbacks used for Demo 3
    var callbacks = {
        readyListener: function () {

            $.each(itemsApp3.questions(), function (index, question) {
                question.on('validated', function () {
                    var outputHTML = '';
                    var map, qid;
                    if (question.isValid()) {
                        return;
                    }

                    if (question.mapValidationMetadata('distractor_rationale_response_level') != false) {
                        map = question.mapValidationMetadata('distractor_rationale_response_level');
                        $.each(map.incorrect, function (i, data) {
                            /*  Each item in the `map.incorrect` array is an object that contains a `value` property that
                                holds the response value; an `index` property that refers to the shared index of both the
                                response area and the metadata; and a `metadata` property containing the metadata value.
                            */

                            var distractor = data.metadata;

                            outputHTML += '<li>' + distractor + '</li>';
                        });
                        if (outputHTML) {
                            outputHTML = '<ul>' + outputHTML + '</ul>';
                        }
                    } else if(question.getMetadata().distractor_rationale) {
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

    // Host page rendering logic for Demo 3
    function renderDistractor (id, content) {
        var template;
        if ($("#" + id + "_distractor").length) {
            $("#" + id + "_distractor").html(content).fadeIn();
        } else {
            template = "<div id=\"" + id + "_distractor\" class=\"distractor-rationale alert alert-danger\">" + content + "</div>";
            $("#" + id).append(template);
        }

        // renderMath() Renders all LaTeX or MathML elements on the page with MathJax.
        itemsApp.questionsApp().renderMath();
    }

    // Hide distractor when another attempt is made, used for Demo 3
    function removeDistractor (id) {
        $("#" + id + '_distractor').fadeOut();
    }

    var itemsApp = LearnosityItems.init(initializationObject);
    var itemsApp2 = LearnosityItems.init(initializationObject2);
    var itemsApp3 = LearnosityItems.init(initializationObject3, callbacks);
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
