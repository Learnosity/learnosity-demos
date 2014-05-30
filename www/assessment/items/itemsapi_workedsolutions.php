<?php

include_once '../../config.php';
include_once 'includes/header.php';
include_once 'Learnosity/Sdk/Request/Init.php';
include_once 'Learnosity/Sdk/Utils/Utilities/Uuid.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = Uuid::generateUuid();

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => $session_id,
    'course_id'      => $courseid,
    'items'          => array('workedsolutions_1', 'workedsolutions_2', 'workedsolutions_3'),
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
    ItemsAPI = LearnosityItems.init(activity, options);

    /**
     * Method called from the Questions API ready listener
     */
    function initApp() {
        var metadata = getMetadata();
        var question_ids = getObjectKeys(metadata);
        // Render a button next to each question for users to see a hint (if available)
        // for that question
        for (var i = 0; i < question_ids.length; i++) {
            var id = question_ids[i];
            var btnHint = '<p><button type="button" class="btn btn-default btn-sm ' + id + '" onclick="renderHint(\'' + id + '\')">Hint</button></p>';
            $('#'+id).closest('div.row').append(btnHint);
        }
    }

    /**
     * Render any hint(s) retrieved from the question metadata
     * @param  {string} question_id The question to render a hint for
     */
    function renderHint(question_id) {
        // get hints container..
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
    }

    /**
     * Retrieves the metadata object from the Questions API
     * Optionally returns data for a specific key
     * @param  {string} key Optional key to filter by
     * @return {object}     Either the entire metadata object, or a subset (if key is passed)
     */
    function getMetadata(key) {
        var metadata;
        ItemsAPI.getMetadata(function(obj) {
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
    <h1>Items API – Worked Solutions</h1>
    <p>Store basic HTML in the Questions API metadata property to be rendered by the host
    environment for displaying rich hints to users.<p>
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
<p><span class="learnosity-item" data-reference="workedsolutions_1"></span></p>
<h2>Question 2</h2>
<p><span class="learnosity-item" data-reference="workedsolutions_2"></span></p>
<h2>Question 3</h2>
<p><span class="learnosity-item" data-reference="workedsolutions_3"></span></p>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
