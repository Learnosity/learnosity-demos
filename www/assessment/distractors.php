<?php
header("Location: /assessment/distractor-rationale.php", true, 301);
exit();
//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


//simple api request object for Items API
$request = [
    'activity_id' => 'distractorsdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'act1'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act2'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act3'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act4'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act5'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act6'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act8'
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Display Distractor Rationale and Feedback</h2>
            <p>
                Distractor rationale are hints shown to a student when they select an incorrect answer.
                <br>Try choosing an incorrect answer for the questions below to see distractor rationale in action.
                <br>You can specify distractor rationale in the author API and then write code to display them.
                <br>You can use the <a href="https://reference.learnosity.com/questions-api/methods/learnosityApp/renderMath">renderMath()</a> method to render any Latex or MathML elements in the distractor rationale.
                <br>For an example of how to implement distractor rationale, refer to <a href="https://support.learnosity.com/hc/en-us/articles/360000754818-Tutorial-202-Displaying-Distractor-Rationale">this tutorial.</a>
            <p>
        </div>
    </div>

    <div class="section pad-sml">
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

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {

                $.each(itemsApp.questions(), function (index, question) {
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

                $.each(itemsApp.questions(), function (index, question) {
                    question.on('changed', function () {
                        removeDistractor(this.getQuestion().response_id);
                    });
                });

            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);

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
    </script>

    <style>
        .distractor-rationale { margin: 6px 0 24px; }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
