<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = $_GET['session_id'];
$activity_id = 'Demo_Activity';

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
    <div class="overview">
        <h1>End to End Demo – Reporting Feedback</h1>
        <p>Using Reports API on the left side you can see the student answers.</p>
        <p>On the right side of the page the teacher can provide additional subjective feedback to the student, alongside the existing objective scoring.</p>
    </div>
</div>

<div class="section">
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
                    var itemId = element.response_id + '_' + 'feedback_type_4';

                    $('<span class="learnosity-item" data-reference="' + itemId + '">')
                        .appendTo($('#' + element.response_id).closest('.row'))
                        .wrap('<div class="col-md-6"></div>');

                    itemReferences.push({
                        'id' : itemId,
                        'reference' : 'feedback_type_4'
                    });
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
                    'activity_id': '<?php echo $activity_id; ?>',
                    'session_id': '<?php echo Uuid::generate(); ?>',
                    'items': itemReferences,
                    'type': 'feedback',
                    'config': {
                        'renderSaveButton' : true,
                        'questions_api_init_options': {
                            'beta_flags': {
                                'reactive_views': true
                            }
                        }
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
                            }, 1000);
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
