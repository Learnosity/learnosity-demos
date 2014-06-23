<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'course_id'      => $courseid,
    'items'          => array('act1','act2','act3','act4','act5','act6'),
    'type'           => 'submit_practice',
    'config'         => array(
        'renderSubmitButton'  => true,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron">
    <h1>Items API – Inline</h1>
    <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_adaptive.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="act1"></span>
    <span class="learnosity-item" data-reference="act2"></span>
    <span class="learnosity-item" data-reference="act3"></span>
    <span class="learnosity-item" data-reference="act4"></span>
    <span class="learnosity-item" data-reference="act5"></span>
    <span class="learnosity-item" data-reference="act6"></span>
    <span class="learnosity-submit-button"></span>
</p>

<!-- Container for the items api to load into -->
<script src="//items.vg.learnosity.com/"></script>
<script src="itemsapi_distractors/response-level-map.js"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                //Patching functionality as awaiting a coming release of itemsInstance.questions()
                itemsInstance.questions = getQuestionResponseIds;

                $.each(itemsInstance.questions(), function(index, question) {
                    question.on("validated", function() {
                        var distractorQuestionLvl = this.getMetadata().distractor_rationale || "",
                            distractorResponseLvl = this.getMetadata().distractor_rationale_response_level || "",
                            validation = this.isValid("detailedWithPartials"),
                            question = this.getQuestion(),
                            outputHTML = "";

                        if(!validation.correct) {
                            if(distractorResponseLvl.length) {
                                var response = this.getResponse(),
                                    map = mapResponseLevel(question, response, validation),
                                    list = "";

                                $.each(distractorResponseLvl, function (index, distractor) {
                                    if (map[index] === false) { // Change here to render 'correct' distactor info or unattempted
                                        list += "<li>" + distractor + "</li>";
                                    }
                                });

                                outputHTML += list.length ? "<ul>" + list + "</ul>" : "";
                            } else if(distractorQuestionLvl.length) {
                                outputHTML += distractorQuestionLvl;
                            }

                            renderDistractor(question.response_id, outputHTML);
                        }
                    });
                });

                $.each(itemsInstance.questions(), function(index, question) {
                    question.on("changed", function() {
                        removeDistractor(this.getQuestion().response_id);
                    });
                });
            }
        },
        itemsInstance = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

        // Host page rendering logic
        function renderDistractor (id, content) {
            if($("#" + id + "_distractor").length) {
                $("#" + id + "_distractor").html(content).fadeIn();
            } else {
                var template = "<div id=\"" + id + "_distractor\" class=\"distractor-rationale alert alert-danger\">" + content + "</div>";
                $("#" + id).append(template);
            }
        }

        function removeDistractor (id) {
            $("#" + id + '_distractor').fadeOut();
        }

        // Patch effort, itemsInstance.questions() will be released replacing this.
        function getQuestionResponseIds () {
            var questions = [];
            itemsInstance.getQuestions(function (questionsJSON) {
                $.each(questionsJSON, function (index, value) {
                    questions.push(itemsInstance.question(index));
                });
            });
            return questions;
        }

</script>

<style>
    .distractor-rationale { margin: 6px 0 24px; }
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
