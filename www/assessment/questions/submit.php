<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => $studentid
);

$session_id = Uuid::generate();

// retrieve responseId from GET parameter and switch to review state if questions have been submitted
if (isset($_GET['state']) && $_GET['state'] === 'review') {
    $state =  'review';
    $uniqueResponseIdSuffix = $_GET['uniqueResponseIdSuffix'];
} else {
    $state =  'initial';
    $uniqueResponseIdSuffix = Uuid::generate();
}

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "submit_practice",
    "state": "'.$state.'",
    "session_id": "' . $session_id . '",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "questions": [
        {
            "response_id": "demo1-'.$uniqueResponseIdSuffix.'",
            "options": [{
                "label": "Red",
                "value": "0"
            }, {
                "label": "Violet",
                "value": "1"
            }, {
                "label": "Blue",
                "value": "2"
            }, {
                "label": "Orange",
                "value": "3"
            }],
            "stimulus": "<p><span>Which of these colours has the smallest wavelength?</span></p>\n",
            "type": "mcq",
            "ui_style": {},
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": ["1"]
                }
            }
        },
         {
            "response_id": "demo2-'.$uniqueResponseIdSuffix.'",
            "stimulus": "<p><span>Who is the Mayor of New York City?</span></p>\n",
            "type": "shorttext",
            "validation": {
                "alt_responses": [{
                    "score": 0.5,
                    "value": "Mike Bloomberg"
                }],
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": "Michael Bloomberg"
                }
            }
        }
    ]
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Question Types</h1>
    <p>Rich Question Types can be embedded on any page with the Learnosity <b>Questions API</b>.
    Every question is highly configurable to suit the assessment purpose, be it formative or summative.<p>
    <p>Try a few questions and then submit at the bottom of the page</p>
</div>

<!-- Container for the questions api to load into -->
<script src="<?php echo $url_questions; ?>"></script>
<script>
    $(function(){
        var options = {
                saveSuccess: function(response_ids) {
                    $('button.finish').text('Going to Review...');
                    window.location = $('a#reviewButton').attr('href');
                }
            };
        window.questionsApp = LearnosityApp.init(<?php echo $signedRequest; ?>, options);

        // submit questions..
        $('button.submit').on('click', function() {
            LearnosityApp.submit({
                success: function (response_ids) {
                    // Receives a list of the submitted user responses as [response_id]
                    console.log("submit has been successful", response_ids);
                    console.log('Retrieve responses from the Data API with this session_id: <?php echo $session_id ?>');
                }
            });
        });
    });
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">Question Types Submit</h2>

    <div class="row">
        <div class="col-md-12">
            <span class="learnosity-response question-demo1-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <span class="learnosity-response question-demo2-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>

    <div class="row">
        <div class="form-actions">
            <button class="btn btn-xlarge btn-primary submit finish">Submit</button>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
