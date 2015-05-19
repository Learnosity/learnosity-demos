<?php

include_once '../../../../config.php';
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

$request = array(
    'reports' => array(
        array(
            'id'         => 'report-1',
            'type'       => 'session-detail-by-item',
            'user_id'    => $studentid,
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
        <h1>Teacher Scoring – Step 2</h1>
        <p>This template renders a student assessment in review, and loads interactive
        widgets for the teacher to save scoring against the student responses.</p>
        <p>This way, scores can be access via the Reports or Data APIs.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div class="row">
        <div class="col-md-6">
            <h1>Student Review</h1>
        </div>
        <div class="col-md-6">
            <h1>Teacher Scoring</h1>
        </div>
    </div>
    <span class="learnosity-report" id="report-1"></span>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <div class="lrn pull-right">
                <button type="button" class="ladda-button btn_save_simple_scores" data-style="expand-right"><span class="ladda-label">Save Scores</span></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>

var scoringObjects = [];

var init = function () {

    var itemReferences = [],
        report1 = reportsApp.getReport('report-1');

    report1.on('ready:itemsApi', function(itemsApp) {

        window.itemsApp = itemsApp;

        // Build the 2 columns, left is Reports API (student in review) and the right is Items API
        // for the teacher to add custom scores. On save() we send the scores to the Data API.
        $('.lrn_widget').wrap('<div class="row"></div>').wrap('<div class="col-md-6"></div>');

        itemsApp.getQuestions(function(questions) {
            $.each(questions, function(index, element) {
                if(element.metadata.rubric_reference !== undefined) {
                    var scoringItemId = element.metadata.rubric_reference;

                    $('<span class="learnosity-item" data-reference="' + scoringItemId + '">')
                        .appendTo($('#' + element.response_id).closest('.row'))
                        .wrap('<div class="col-md-6"></div>');

                    itemReferences.push(scoringItemId);
                    window.setScoringObjects(scoringItemId, element);
                }
            });
        });

        var itemsActivity = {
            'domain': location.hostname,
            'request': {
                'user_id': '<?php echo $studentid; ?>',
                'rendering_type': 'inline',
                'name': 'Items API demo - teacher scoring activity.',
                'state': 'initial',
                'activity_id': '<?php echo $activity_id; ?>',
                'session_id': '<?php echo Uuid::generate(); ?>',
                'course_id': 'commoncore',
                'items': itemReferences,
                'type': 'local_practice'
            }
        };

        $.post('endpoint.php', itemsActivity, function(data, status) {
            window.itemsAppTeacherScoring = LearnosityItems.init(data);
        });
    });
};

var eventOptions = {
    readyListener : init
};

var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

var scoringObjects = {};

function setScoringObjects (scoringItemId, question) {
    scoringObjects[scoringItemId] = question;
}

function saveScores () {

    // Spinning button
    var ladda = Ladda.create($('.ladda-button')[0]);
    ladda.start();

    var teacherItems = itemsAppTeacherScoring.getItems(),
        teachersResponses = itemsAppTeacherScoring.getResponses(),
        questions = [],
        responses = [],
        request,
        endpoint;
    $.each(itemsAppTeacherScoring.attemptedItems(), function (index, ref) {
        // Retrieve the teacher score
        var response_id = teacherItems[ref].response_ids[0],
            newResponseObject = scoringObjects[ref];

        responses.push({
            'response_id': newResponseObject.response_id,
            'score': teachersResponses[response_id].value
        });
    });

    request = {
        'sessions': [
            {
                'session_id': '<?php echo $session_id; ?>',
                'user_id': '<?php echo $studentid; ?>',
                'responses': responses
            }
        ]
    };
    endpoint = '<?php echo $url_data; ?>/latest/sessions/responses/scores';

    $.ajax({
        url: '/xhr.php',
        data: {'request': JSON.stringify(request), 'endpoint': endpoint, 'action': 'update'},
        dataType: 'json',
        type: 'POST'
    })
    .error(function(xhr, status, data) {
        console.log(xhr.responseText, null, null);
    })
    .success(function(data, status, xhr) {
        // The only reason we wait 5 seconds _after_ the Data API update is due to a latency
        // retrieving responses that have been immediately set/updated
        window.setTimeout(function () {
            window.location = './feedback_report.php?session_id=<?php echo $session_id; ?>&activity_id=<?php echo $activity_id; ?>';
        }, 7000);
    });
}

$(function() {
    $('.btn_save_simple_scores').on('click', saveScores);
});

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

<script src="<?php echo $env['www'] ?>static/vendor/ladda/spin.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/ladda/ladda.min.js"></script>

<?php
    include_once 'includes/footer.php';

