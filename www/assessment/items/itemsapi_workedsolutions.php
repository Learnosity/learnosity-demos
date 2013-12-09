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
<script>
    var activity = <?php echo $signedRequest; ?>;
    // Set a local variable from the init() method to access the public methods available
    ItemsAPI = LearnosityItems.init(activity);
    /**
     * Retrieves the question metadata from the public API (Questions API)
     * and displays a sample_answer to an HTML element. Useful to provide
     * a 'hint' to a user to assist them in answering a question.
     * @param  string question_id   The id of the question in the metadata object
     * @param  string host_el       An id on the host page to write a hint into
     * @param  numeric hint_index   Hints may be strings or arrays, if they're arrays
     *                              which index do you want to retrieve?
     * @return void
     */
    function getMetadata(question_id, host_el, hint_index) {
        var hostMeta = {
            'id':    question_id,
            'el':    host_el,
            'index': (typeof hint_index === 'undefined') ? null : hint_index
        };
        // Hide any previously rendered hints
        hideHints();
        ItemsAPI.getMetadata(function(obj) {
            var hint = obj[hostMeta.id];
            if (hostMeta.index === null) {
                hint = hint.hint;
            } else {
                hint = hint.hint[hostMeta.index];
            }
            $('#'+hostMeta.el).html(hint).show();
        });
    }
    /**
     * Hides any elements with a class of 'hint'
     * @return {[type]} [description]
     */
    function hideHints() {
        $('.hint').each(function(index, el) {
            $(el).hide();
        });
    }
</script>

<div class="jumbotron">
    <h1>Items API – Worked Solutions</h1>
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
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="./../assess/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="workedsolutions_1"></span>
</p>
<div class="jumbotron">
    <p>
        <span class="glyphicon glyphicon-info-sign"></span>
        Inline help is available to students by clicking the buttons below
    </p>
    <div class="row">
        <div class="col-lg-3">
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_1', 'hint_a', 0)">Hint (a) – 1</button>
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_1', 'hint_a', 1)">Hint (a) – 2</button>
        </div>
        <div class="col-lg-3">
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_2', 'hint_b', 0)">Hint (b) – 1</button>
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_2', 'hint_b', 1)">Hint (b) – 2</button>
        </div>
        <div class="col-lg-3">
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_3', 'hint_c', 0)">Hint (c) – 1</button>
            <button type="button" class="btn btn-default" onclick="getMetadata('<?= $session_id; ?>_workedsolutions_1_3', 'hint_c', 1)">Hint (c) – 2</button>
        </div>
    </div>
</div>

<?php
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
