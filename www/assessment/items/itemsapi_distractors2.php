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

                // get full validation info (fully correct, and partial)
                lrnActivity.validItems(function (responseObj) {


                    var validationObj = checkIfValid(responseObj, question_id);
                    //if question isn't in the valid list, get distractor rationale and display
                    if(!validationObj.correct) {

                        if(!q_meta.hasOwnProperty("distractor_rationale_response_level")) {
                            //response level metadata takes precedence
                            appendContent(question_id + "_dr", $('#' + question_id).parents().eq(1), q_meta.distractor_rationale, "alert alert-danger");

                        } else {
                            //check partial info for distractor response validation
                            console.log(validationObj.partial);
                            $.each(validationObj.partial, function(id, value) {

                                console.log(id, value);
                                if (!value) {
                                    appendContent(question_id + "_dr", $('#' + question_id).parents().eq(1), q_meta.distractor_rationale_response_level[id], "alert alert-danger");
                                }
                            });
                        }
                        if($('#' + question_id + "_dr").text() !== "") {
                            $('#' + question_id + "_dr").show();
                        }
                        MathJax.Hub.Queue(['Typeset', MathJax.Hub, question_id + "_dr"]);

                    }
                }, "detailedWithPartials");
            }
        });

        function checkIfValid(responses, question_id) {
            for(var key in responses) {
                console.log(key, responses);
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

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Distractor Rationale</h1>
    <p>Store distractor rationale in the Questions API metadata property to be rendered by the host
    environment for displaying context to wrong answers.<p>
</div>

<div class="section">
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
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
