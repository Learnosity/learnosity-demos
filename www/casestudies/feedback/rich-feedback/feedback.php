<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = $_GET['session_id'];
$activity_id = $_GET['activity_id'];

$security = [
    'user_id'      => $studentid,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

// Load the student assessment using the Reports API
// This allows the teacher to review the student responses
// in the left column
$request = array(
    'reports' => array(
        array(
            'id' => 'report-1',
            'type' => 'session-detail-by-item',
            'user_id' => $studentid,
            'session_id' => $session_id
        )
    ),
    'configuration' => array(
        'questionsApiVersion' => 'v2',
        'itemsApiVersion' => 'v1'
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Teacher Feedback – Step 2</h1>
        <p>This template renders a student assessment in <em>review</em>, and loads interactive
        widgets (including rubrics) for the teacher to save feedback for the student to see.</p>
        <p>The feedback widgets can leverage any Learnosity question type, and are authored
        just like student questions (inside the author site or using the <a href="/authoring/author">Author API</a>).</p>
    </div>
</div>

<div class="section">
    <!-- Containers for the reports api to load into -->
    <div class="row">
        <div class="col-md-6">
            <h1>Student Review</h1>
        </div>
        <div class="col-md-6">
            <h1>Teacher Feedback</h1>
        </div>
    </div>
    <span class="learnosity-report" id="report-1"></span>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2 pull-right">
            <span class="learnosity-save-button"></span>
        </div>
    </div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>

var init = function() {

    var itemReferences = [];
    var report1 = reportsApp.getReport('report-1');

    report1.on('ready:itemsApi', function(itemsApp) {

        // Build the 2 columns, left is Reports API (student in review) and the right is Items API
        // for the teacher to add feedback.
        $('.lrn_widget').wrap('<div class="row"></div>').wrap('<div class="col-md-6"></div>');

        itemsApp.getQuestions(function(questions) {

            $.each(questions, function(index, element) {
                if(element.metadata.rubric_reference !== undefined) {
                    var itemId = element.response_id + '_' + element.metadata.rubric_reference;

                    $('<span class="learnosity-item" data-reference="' + itemId + '">')
                        .appendTo($('#' + element.response_id).closest('.row'))
                        .wrap('<div class="col-md-6"></div>');

                    itemReferences.push({
                        'id' : itemId,
                        'reference' : element.metadata.rubric_reference
                    });
                }
            });
        });

        console.log(itemReferences);

        var itemsActivity = {
            'domain': location.hostname,
            'request': {
                'user_id': '<?php echo $studentid; ?>',
                'rendering_type': 'inline',
                'name': 'Items API demo - feedback activity.',
                'state': 'initial',
                'activity_id': 'feedback_test_1',
                'session_id': '<?php echo Uuid::generate(); ?>',
                'items': itemReferences,
                'type': 'feedback',
                'config': {
                    'renderSaveButton' : true
                }
            }
        };

        $.post('endpoint.php', itemsActivity, function(data, status) {
            console.log('endpoint response', data);
            itemsApp = LearnosityItems.init(data, {
                readyListener: function() {
                    $('.lrn_save_button').click(function() {
                        window.setTimeout(function() {
                            window.location = 'feedback_report.php?session_id=<?php echo $_GET['session_id']; ?>&feedback_session_id=' + itemsActivity.request.session_id;
                        }, 2000);
                    });
                }
            });
        });
    });
};

var eventOptions = {
    readyListener : init
};

reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

</script>

<style type="text/css">
    .lrn .row {
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .learnosity-report h3 {
        font-weight: 400;
    }
</style>

<?php
    include_once 'includes/footer.php';
