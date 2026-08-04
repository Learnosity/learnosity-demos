<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


//session ids for student and teacher sessions

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$feedback_session_id = filter_input(INPUT_GET, 'feedback_session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'user_id'      => 'demos-site',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id' => 'report-1',
            'type' => 'session-detail-by-item',
            'user_id' => 'demos-site',
            'session_id' => $session_id
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Reporting Review</h1>
        <p>Finally the student can review any teacher feedback.</p>
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
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <div class="lrn float-end">
                    <span class="learnosity-save-button"></span>
            </div>
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
        // showing the teacher feedback.
        document.querySelectorAll('.lrn_widget').forEach(function (widget) {
            wrapWithDiv(widget, 'row');
            wrapWithDiv(widget, 'col-md-6');
        });

        itemsApp.getQuestions(function(questions) {
            Object.values(questions).forEach(function (element) {
                //if(element.metadata.rubric_reference !== undefined) {
                    var itemId = element.response_id + '_' + 'feedback_type_4';

                    var span = document.createElement('span');
                    span.className = 'learnosity-item';
                    span.dataset.reference = itemId;
                    document.getElementById(element.response_id).closest('.row').appendChild(span);
                    wrapWithDiv(span, 'col-md-6');

                    itemReferences.push({
                        'id' : itemId,
                        'reference' : 'feedback_type_4'
                    });
                //}
            });
        });

        console.log(itemReferences);

        var itemsActivity = {
          'domain': location.hostname,
          'request': {
            'user_id': 'demos-site',
            'rendering_type': 'inline',
            'name': 'Items API demo - feedback activity.',
            'state': 'review',
            'activity_id': 'Demo_Activity',
            'session_id': '<?php echo $feedback_session_id; ?>',
            'items': itemReferences,
            'type': 'feedback'
          }
        };

        postForm("endpoint.php", itemsActivity).then(function (data) {
          console.log("endpoint response", data);
          itemsApp = LearnosityItems.init(data);
        }).catch(function (error) { console.error(error); });
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
