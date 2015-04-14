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
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Teacher Scoring – Step 2</h1>
        <p>This template renders a student assessment in review, and loads interactive
        widgets for the teacher to save scoring against the student responses.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div class="row">
        <div class="col-md-7">
            <h1>Student Report</h1>
        </div>
        <div class="col-md-5">
            <h1>Teacher Scoring</h1>
        </div>
    </div>
    <span class="learnosity-report" id="report-1"></span>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2 pull-right">
            <div class="lrn">
                <button type="button" class="lrn_btn btn_save_simple_scores"><span>Save Scores</span></button>
            </div>
        </div>
    </div>
</div>

<script src="//reports.learnosity.com"></script>
<script>

var scoringObjects = [];

var init = function () {

    var itemReferences = [],
        report1 = reportsApp.getReport('report-1');

    report1.on('ready:itemsApi', function(itemsApp) {

        window.itemsApp = itemsApp;

        //build columns in report.
        $('.lrn_widget').wrap("<div class=\"row\"></div>").wrap("<div class=\"col-md-7\"></div>");

        itemsApp.getQuestions(function(questions) {
            $.each(questions, function(index, element) {
                if(element.metadata.rubric_reference !== undefined) {
                    var scoringItemId = element.metadata.rubric_reference;

                    $("<span class=\"learnosity-item\" data-reference=\""+ scoringItemId +"\">")
                    .appendTo($('#' + element.response_id).closest('.row'))
                    .wrap("<div class=\"col-md-5\"></div>");

                    itemReferences.push(scoringItemId);
                }
                // window.setScoringObjects({
                //     'studentItemReference': '',
                //     'teacherItemReference': scoringItemId
                // });
            });
        });

        var itemsActivity = {
            "domain": location.hostname,
            "request": {
                "user_id": "<?php echo $studentid; ?>",
                "rendering_type": "inline",
                "name": "Items API demo - teacher scoring activity.",
                "state": "initial",
                "activity_id": "scoring_test_1",
                "session_id": "<?php echo Uuid::generate(); ?>",
                "course_id": "commoncore",
                "items": itemReferences,
                "type": "local_practice"
            }
        };

        $.post('endpoint.php', itemsActivity, function(data, status) {
            window.itemsAppReview = LearnosityItems.init(data);
        });
    });
};

var eventOptions = {
    readyListener : init
};

var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

function saveScores () {
    var studentQuestions = itemsApp.getQuestions(),
        studentResponses = itemsApp.getResponses(),
        teacherScores = itemsAppReview.getResponses();

    window.alert('TODO - implement Data API save score to student record');

    // console.log(studentQuestions);
    // console.log(studentResponses);
    // console.log(teacherScores);
    // console.log(scoringObjects);
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

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
