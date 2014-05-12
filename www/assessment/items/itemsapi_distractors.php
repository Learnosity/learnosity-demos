<?php

include_once '../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$session_id = UUID::generateUuid();

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
    'session_id'     => $session_id,
    'course_id'      => $courseid,
    'items'          => array('act1', 'act2', 'act3','act4','act5','act6'),
    'type'           => 'submit_practice',
    'config'         => array(
        'questionsApiVersion' => 'v2',
        'renderSubmitButton'  => false
    )
);

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

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
        var metadata = getMetadata();
        var question_ids = getObjectKeys(metadata);
        // Render a button next to each question for users to see a hint (if available)
        // for that question
        for (var i = 0; i < question_ids.length; i++) {
            var question_id = question_ids[i];
            console.log('#' + question_id);
            $('#' + question_id + " .lrn_btn").click({id : question_id}, function(event) {
                renderDistractorRationale(event.data.id);
            });

        }
    }

    /**
     * Render any hint(s) retrieved from the question metadata
     * @param  {string} question_id The question to render a hint for
     */
    function renderDistractorRationale(question_id) {
        // get hints container..

        lrnActivity.attemptedQuestions(function (responseIds) {

            if($.inArray(question_id, responseIds) !== -1) {
                var metadata = getMetadata(question_id);
                $('#' + question_id + "_dr").hide().text("");
                lrnActivity.validItems(function (responseObj) {
                    
                    if(!checkIfValid(responseObj, question_id)) {
                        if(!metadata.hasOwnProperty("distractor_rationale_response_level")) {
                            appendContent(question_id + "_dr", $('#' + question_id).parents().eq(1), metadata.distractor_rationale, "alert alert-danger");
                            
                        } else {

                            lrnActivity.getQuestions(function(questions) {

                                lrnActivity.getResponses(function(responses) {
                                    question_validation = questions[question_id].validation.valid_response.value;
                                    question_response = responses[question_id].value;
                                    question_options = questions[question_id].options;
                                    evaluateAnswers(question_id, question_validation, question_response, question_options, questions[question_id].type, metadata);
                                
                                });
                            });
                        }
                        $('#' + question_id + "_dr").show();
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
                        if(value != response[id] && response[id] !== undefined) {
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


        function appendContent (id, handle, content, classes) {
            console.log("Here!", content);
            if($("#" + id).length == 0) {
                console.log("uh oh, empty!");
            handle.append($("<div>").attr('id', id).addClass(classes).append(content + "<br>"));
        } else {
            $("#" + id).addClass(classes).append(content + "<br>");
        }
        }
        
/*
        var hintsElem = $('#'+question_id).parents('div.item-content').siblings();
        $(hintsElem).attr('id', 'hints_' + question_id);

        // clear hints container..
        hintsElem.empty();

        var metadata = getMetadata(question_id);
        var hintHtml = $.parseHTML(metadata.sample_answer || metadata.hint);
        var hints = $(hintHtml).find('div.hint');

        // check how many times the hint button has been clicked..
        var hintsClicked = $('#'+question_id).data('hintsClicked');
        if (hintsClicked === undefined) {
            $('#' + question_id).data('hintsClicked', 1);
        } else if (hintsClicked < hints.length) {
            $('#' + question_id).data('hintsClicked', hintsClicked + 1);
        }

        // Add the hint(s) from questions metadata and render into the div#hints element
        for (var i = 0; i < $('#'+question_id).data('hintsClicked'); i++) {
            hintsElem.addClass('alert alert-warning').append(hints[i]);
        };

        $('button.' + question_id).text('Hint (' + (hints.length - $('#'+question_id).data('hintsClicked')) + ' left) ' )

        // Render any LaTeX that might have been in the hint
        MathJax.Hub.Queue(['Typeset', MathJax.Hub, 'hints_' + question_id]);
        */
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
