<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//session ids for student and teacher sessions

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$feedback_session_id = filter_input(INPUT_GET, 'feedback_session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'user_id'      => 'demo_student',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id' => 'report-1',
            'type' => 'session-detail-by-item',
            'user_id' => 'demo_student',
            'session_id' => $session_id
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Student Feedback Review – Step 3</h1>
        <p>This template is for students to review any teacher/marker feedback.</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
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
        <div class="col-md-6"></div>
        <div class="col-md-6">
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
        // showing the teacher feedback.
        document.querySelectorAll('.lrn_widget').forEach(function (widget) {
            wrapWithDiv(widget, 'row');
            wrapWithDiv(widget, 'col-md-6');
        });

        itemsApp.getQuestions(function(questions) {

          Object.values(questions).forEach(function (element) {
            if(element.metadata.rubric_reference !== undefined) {

              var itemId = element.response_id + '_' + element.metadata.rubric_reference;

              var span = document.createElement('span');
              span.className = 'learnosity-item';
              span.dataset.reference = itemId;
              document.getElementById(element.response_id).closest('.row').appendChild(span);
              wrapWithDiv(span, 'col-md-6');

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
            'user_id': 'demo_student',
            'rendering_type': 'inline',
            'name': 'Items API demo - feedback activity.',
            'state': 'review',
            'activity_id': 'feedback_test_1',
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
