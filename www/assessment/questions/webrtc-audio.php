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
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "beta_flags": {
        "use_webrtc": true,
        "reactive_views": true
    },
    "questions": [
        {
            "response_id": "demo6-'.$uniqueResponseIdSuffix.'",
            "type": "audio",
            "description": "The student needs to speak about a typical day in their life."
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
    <h1>Questions API – WebRTC Audio Demo</h1>
    <p>Learnosity's audio question types work across all popular browsers and devices (see the <a href="https://docs.learnosity.com/faqs/system" target="new">system requirements</a>).</p>
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
        $('button.save-review').on('click', function() {
            $(this).removeClass('save-review').text($(this).attr('data-saving-text'));
            LearnosityApp.save();
        });
    });
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">WebRTC Audio Demo</h2>

    <div class="row">
        <div class="col-md-8">
            <h3 id="q6">Spoken response</h3>
            <p>Describe a typical day in your life.</p>
            <span class="learnosity-response question-demo6-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
    </div>
    <hr>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
