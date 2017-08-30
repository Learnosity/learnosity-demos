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

$uniqueResponseIdSuffix = Uuid::generate();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "submit_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "' . $courseid . '",
    "beta_flags": {
        "reactive_views": true
    },
    "questions": [
        {
            "response_id": "demoaudio_1-' . $uniqueResponseIdSuffix . '",
            "type": "audio",
            "description": "The <strong>student</strong> needs to talk about themselves",
            "show_download_link": true,
            "ui_style": "block"
        }
    ]
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<style>
    .good {
        background-color:#E7F4E1;
    }

    .bad {
        background-color:#FBDDDD;
    }
</style>
<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/responsetypes.php#audio" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Advanced Audio Analysis</h1>
    <p>Using Learnosity's Questions API public methods, we can provide a level of analysis of recorded audio, to ensure the recorded sample is of the required quality before submitting.<p>
</div>

<!-- Container for the questions api to load into -->
<script src="<?php echo $url_questions; ?>"></script>
<script>
    function checkQuality() {
        $('.good,.bad').removeClass("good bad");
        if (parseFloat($('.numberOfClippingSamples').html(), 10) > parseFloat($('.numberOfClippingSamples_inp').val(), 10)) {
            $('.numberOfClippingSamples').addClass('bad');
            $('.numberOfClippingSamples_result').addClass('bad').html('Too Loud');
        } else {
            $('.numberOfClippingSamples').addClass('good');
            $('.numberOfClippingSamples_result').addClass('good').html('Acceptable');
        }
        if (parseFloat($('.maxRmsEnergy').html(), 10) < parseFloat($('.maxRmsEnergy_inp').val(), 10)) {
            $('.maxRmsEnergy').addClass('bad');
            $('.maxRmsEnergy_result').addClass('bad').html('Too Quiet');
        } else {
            $('.maxRmsEnergy').addClass('good');
            $('.maxRmsEnergy_result').addClass('good').html('Acceptable');
        }
        if (parseFloat($('.minRmsEnergy').html(), 10) > parseFloat($('.minRmsEnergy_inp').val(), 10)) {
            $('.minRmsEnergy').addClass('bad');
            $('.minRmsEnergy_result').addClass('bad').html('Background Noise');
        } else {
            $('.minRmsEnergy').addClass('good');
            $('.minRmsEnergy_result').addClass('good').html('Acceptable');
        }
    }

    $('.checkQualityInputs input').on("change", checkQuality);

    var eventOptions = {
            readyListener: function () {
                audioQuestion = lrnActivity.question('demoaudio_1-' + '<?= $uniqueResponseIdSuffix ?>');
                audioQuestion.on('recording:stopped', function () {
                audioQuality = audioQuestion.response.audioQualityCheck();
                console.log(audioQuality);
                $('.numberOfClippingSamples').html(audioQuality.detail.numberOfClippingSamples);
                $('.maxRmsEnergy').html(audioQuality.detail.maxRmsEnergy);
                $('.minRmsEnergy').html(audioQuality.detail.minRmsEnergy);
                checkQuality();
                });
            }
        },
    lrnActivity = LearnosityApp.init(<?php echo $signedRequest; ?>, eventOptions);
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">Demos</h2>

    <div class="row">
        <div class="col-md-6">
            <h3>Analyse Audio</h3>
            <p>Record a sample to analyse the audio quality.</p>
            <span class="learnosity-response question-demoaudio_1-<?php echo $uniqueResponseIdSuffix ?>"></span>
        </div>
        <div class="col-md-6">
            <div class="hints">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Number of Clipping Samples</th>
                            <th>Min RMS Threshold</th>
                            <th>Max RMS Threshold</th>
                        </tr>
                    </thead>
                    <tbody class="checkQualityInputs">
                        <tr>
                            <td>Description</td>
                            <td>A measure of distortion of recording within the clip. Samples with greater number of clipping samples than set below will be marked as "bad".</td>
                            <td>A measure of whether a recorded sample is too quiet. Samples with a lower max RMS than set below will be marked as "bad".</td>
                            <td>A measure of whether there is too much background noise.  Samples with a higher min RMS than set below will be marked as "bad".</td>
                        </tr>
                        <tr>
                            <td>Thresholds</td>
                            <td><input type="number" class="numberOfClippingSamples_inp" value="40"></td>
                            <td><input type="number" class="maxRmsEnergy_inp" value="0.08"></td>
                            <td><input type="number" class="minRmsEnergy_inp" value="0.025"></td>
                        </tr>
                        <tr>
                            <td>Returned Value</td>
                            <td class="numberOfClippingSamples"></td>
                            <td class="maxRmsEnergy"></td>
                            <td class="minRmsEnergy"></td>
                        </tr>
                        <tr>
                            <td>Result</td>
                            <td class="numberOfClippingSamples_result"></td>
                            <td class="maxRmsEnergy_result"></td>
                            <td class="minRmsEnergy_result"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
