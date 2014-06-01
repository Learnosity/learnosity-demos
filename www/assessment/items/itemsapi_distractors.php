<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = Uuid::generate();

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => $session_id,
    'course_id'      => $courseid,
    'items'          => array('act1', 'act2', 'act3','act4','act5','act6'),
    'type'           => 'submit_practice',
    'config'         => array(
        'questionsApiVersion' => 'v2',
        'renderSubmitButton'  => false
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script>
    var options = {
            readyListener: initApp
        },
        ItemsAPI,
        metadata,
        activity = <?php echo $signedRequest; ?>;

    // Set a local variable from the init() method to access the public methods available
    lrnActivity = LearnosityItems.init(activity, options);

    /**
     * Method called from the Questions API ready listener
     */
    function initApp() {
        metadata = getMetadata();
        var question_ids = getObjectKeys(metadata);
        console.log(metadata);
        // attach an onclick function to each questions "check answer"
        // to display any distractor rationale for wrong answers
        for (var i = 0; i < question_ids.length; i++) {
            var question_id = question_ids[i];
            console.log('#' + question_id);
            $('#' + question_id + " .lrn_btn").click({id : question_id}, function(event) {
                renderDistractorRationale(event.data.id);
            });

        }
    }

    /**
     * Render any distractor rationale retrieved from the question metadata
     * @param  {string} question_id The question to render a distratctor rationale for
     */
    function renderDistractorRationale(question_id) {
        // get hints container..

        lrnActivity.attemptedQuestions(function (responseIds) {


            //check if question has been attempted
            if($.inArray(question_id, responseIds) !== -1) {
                var q_meta = metadata[question_id];


                //hide and reset contents of display box until needed
                $('#' + question_id + "_dr").hide().text("");


                lrnActivity.validItems(function (responseObj) {



                    //if question isn't in the valid list, get distractor rationale and display
                    if(!checkIfValid(responseObj, question_id)) {


                        if(!q_meta.hasOwnProperty("distractor_rationale_response_level")) {
                            //response level metadata takes precedence
                            appendContent(question_id + "_dr", $('#' + question_id).parents().eq(1), q_meta.distractor_rationale, "alert alert-danger");

                        } else {

                            //do comparison to see if the answer is correct or not.
                            //This should hopefully disappear once we get 'detailedWithPartial' support into validItems.
                            lrnActivity.getQuestions(function(questions) {

                                lrnActivity.getResponses(function(responses) {
                                    question_validation = questions[question_id].validation.valid_response.value;
                                    question_response = responses[question_id].value;
                                    question_options = questions[question_id].options;
                                    evaluateAnswers(question_id, question_validation, question_response, question_options, questions[question_id].type, q_meta);

                                });
                            });
                        }
                        if($('#' + question_id + "_dr").text() !== "") {
                            $('#' + question_id + "_dr").show();
                        }
                        MathJax.Hub.Queue(['Typeset', MathJax.Hub, question_id + "_dr"]);

                    }
                });
            }
        });

        function evaluateAnswers (q_id, validation, response, options, type, metadata) {
            switch(type) {
                case 'mcq' :
                    $.each(options, function(id, value) {
                        if($.inArray(value.value, response) !== -1 && ($.inArray(value.value, validation)) === -1) {
                            appendContent(q_id + "_dr", $('#' + q_id).parents().eq(1), metadata.distractor_rationale_response_level[id], "alert alert-danger");
                        }
                    });
                    break;
                case 'clozeassociation' :
                case 'association' :
                case 'clozetext' :
                    console.log('validation', validation);
                    console.log('response', response);
                    $.each(validation, function(id, value) {
                        if(value != response[id] && (response[id] !== undefined && response[id] !== null)) {
                            appendContent(q_id + "_dr", $('#' + q_id).parents().eq(1), metadata.distractor_rationale_response_level[id], "alert alert-danger");
                        }
                    });
                    break;
            }
        }


        function checkIfValid(responses, question_id) {
            for(var key in responses) {
                if(responses[key].hasOwnProperty(question_id)) {
                    return responses[key][question_id];
                }
            }
            return false;
        }

        /**
         * Create or append a div
         * and store all relevant distract
         * @param  {string} key Optional key to filter by
         * @return {object}     Either the entire metadata object, or a subset (if key is passed)
         */

        function appendContent (id, handle, content, classes) {
            if($("#" + id).length == 0) {
                handle.append($("<div>").attr('id', id).addClass(classes).append(content + "<br>"));
            } else {
                $("#" + id).addClass(classes).append(content + "<br>");
            }
        }

    }

    /**
     * Retrieves the metadata object from the Questions API
     * Optionally returns data for a specific key
     * @param  {string} key Optional key to filter by
     * @return {object}     Either the entire metadata object, or a subset (if key is passed)
     */
    function getMetadata(key) {
        var metadata;
        lrnActivity.getMetadata(function(obj) {
            metadata = obj;
        });
        if (typeof key === 'undefined') {
            return metadata;
        } else {
            return metadata[key];
        }
    }

    /**
     * Utility function to return all keys in a passed object
     * @param  {object} obj Object to return keys from
     * @return {array}      Array of object keys
     */
    function getObjectKeys(obj) {
        var keys = [];
        for(var key in obj) {
            if(obj.hasOwnProperty(key)) {
                keys.push(key);
            }
        }
        return keys;
    }
</script>

<div class="jumbotron">
    <h1>Items API – Distractor Rationale</h1>
    <p>Store distractor rationale in the Questions API metadata property to be rendered by the host
    environment for displaying context to wrong answers.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="<?php echo $env['www'] ?>assessment/assess/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- HTML element to load item(s) into -->
<h2>Question 1</h2>
<p><span class="learnosity-item" data-reference="act1"></span></p>
<h2>Question 2</h2>
<p><span class="learnosity-item" data-reference="act2"></span></p>
<h2>Question 3</h2>
<p><span class="learnosity-item" data-reference="act3"></span></p>
<h2>Question 4</h2>
<p><span class="learnosity-item" data-reference="act4"></span></p>
<h2>Question 5</h2>
<p><span class="learnosity-item" data-reference="act5"></span></p>
<h2>Question 6</h2>
<p><span class="learnosity-item" data-reference="act6"></span></p>
<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
