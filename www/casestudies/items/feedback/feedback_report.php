<?php
//external config for key/secret etc.
include_once '../../../config.php';
include_once 'includes/header.php';

//use SDK
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//session ids for student and teacher sessions
$session_id = $_GET['session_id'];
$feedback_session_id = $_GET['feedback_session_id'];


//security object
$security = [
'user_id'      => $studentid,
'domain'       => $domain,
'consumer_key' => $consumer_key,
];

//request object
$request = array(
  "reports" => array(
    array(
      "id" => "report-1",
      "type" => "session-detail-by-item",
      "user_id" => $studentid,
      "session_id" => $session_id
      )
    ),
  "configuration" => array(
    "questionsApiVersion" => "v2",
    "itemsApiVersion" => "v1"
    )
  );



//initialize Reports API
$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();


include_once 'utils/settings-override.php';
?>

<div class="jumbotron section">
  <div class="toolbar">
    <ul class="list-inline">
      <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
      <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
      <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
    </ul>
  </div>
  <div class="overview">
    <h1>Items API – Assessment and Feedback</h1>
    <p>Teacher and Peer feedback is an integral part to any product. Once your teacher has saved their feedback, you can present this to teacher and student for their review and further learning.</p>
    <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
  </div>
</div>

<div class="section">
  <!-- Container for the items api to load into -->
  <div class="row">
    <div class="col-md-7"><h1>Student Report</h1></div>
    <div class="col-md-5">
      <h1>Teacher Feedback</h1>
    </div>
  </div>
  <span class="learnosity-report" id="report-1"></span>
  <hr>
  <div class="row">
    <div class="col-md-7"></div>
    <div class="col-md-5">
      <span class="learnosity-save-button"></span>
    </div>
  </div>
</div>
</div>

<script src="//reports.learnosity.com"></script>
<script>

var init = function() {

  var itemReferences = [];
  var report1 = reportsApp.getReport('report-1');

  report1.on('ready:itemsApi', function(itemsApp) { 

        //build columns in report.
        $('.lrn_widget').wrap("<div class=\"row\"></div>").wrap("<div class=\"col-md-7\"></div>");

        itemsApp.getQuestions(function(questions) {

          $.each(questions, function(index, element) {
            if(element.metadata.rubric_reference !== undefined) {

              var itemId = element.response_id + "_" + element.metadata.rubric_reference;

              $("<span class=\"learnosity-item\" data-reference=\""+ itemId +"\">")
              .appendTo($('#' + element.response_id).closest('.row'))
              .wrap("<div class=\"col-md-5\"></div>");

              itemReferences.push({
                "id" : itemId,
                "reference" : element.metadata.rubric_reference
              });
            }
          });
        });

        console.log(itemReferences);

        var itemsActivity = {
          "domain": location.hostname,
          "request": {
            "user_id": "<?php echo $studentid; ?>",
            "rendering_type": "inline",
            "name": "Items API demo - feedback activity.",
            "state": "review",
            "activity_id": "feedback_test_1",
            "session_id": "<?php echo $feedback_session_id; ?>",
            "course_id": "commoncore",
            "items": itemReferences,
            "type": "feedback"
          }
        };

        $.post("endpoint.php", itemsActivity, function(data, status) {
          console.log("endpoint response", data);
          itemsApp = LearnosityItems.init(data);
        });
      });
};

var eventOptions = {
  readyListener : init
};

reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

function toggleModalClass () {
  $('.modal-backdrop').css('display', 'none');
}
</script>

<?php
include_once 'views/modals/settings-items.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
