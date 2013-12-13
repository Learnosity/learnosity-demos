<?php

include_once '../../config.php';
include_once '../../../src/utils/uuid.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

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
    'items'          => array('workedsolutions_1'),
    'type'           => 'submit_practice',
    'config'         => array(
        'renderSubmitButton' => false
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
<script src="http://items.learnosity.com/"></script>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
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
            var btnHint = '<p class="lrn_widget"><button type="button" class="btn btn-default btn-sm" onclick="renderHint(\'' + id + '\')">Hint</button></p>';
            $('#'+id).closest('div.row').append(btnHint);
        }
    }

    /**
     * Render any hint(s) retrieved from the question metadata
     * @param  {string} question_id The question to render a hint for
     */
    function renderHint(question_id) {
        var metadata = getMetadata(question_id);
        // Add the hint from a questions metadata and render into the div#hints element
        $('#hints').addClass('alert alert-warning').empty().html(metadata.hint);
        // Render any LaTeX that might have been in the hint
        MathJax.Hub.Queue(['Typeset', MathJax.Hub, 'hints']);
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
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="./../assess/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- HTML element to load item(s) into -->
<h2>Question 1</h2>
<p><span class="learnosity-item" data-reference="workedsolutions_1"></span></p>

<?php
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
