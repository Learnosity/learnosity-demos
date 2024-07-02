<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

//simple api request object for Items API
$request = [
    'activity_id' => 'advancedaudiodemo',
    'name' => 'Items API demo - advanced audio',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => 'demoaudio_1',
            'reference' => 'demoaudio_1'
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Provide Advanced Audio Features</h2>
            <p>Using Learnosity's Questions API public methods, we can provide a level of analysis of recorded audio, to ensure the recorded sample is of the required quality before submitting.</p>
        </div>
    </div>

    <div class="section">

        <div class="row">
            <div class="col-md-6">
                <h3>Analyse Audio</h3>
                <span class="learnosity-item" data-reference="demoaudio_1"></span>
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

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                audioQuestions = itemsApp.questions();
                audioQuestion = audioQuestions[Object.keys(audioQuestions)[0]];
                audioQuestion.on('recording:stopped', function () {
                    audioQuality = audioQuestion.response.audioQualityCheck();
                    console.log(audioQuality);
                    $('.numberOfClippingSamples').html(audioQuality.detail.numberOfClippingSamples);
                    $('.maxRmsEnergy').html(audioQuality.detail.maxRmsEnergy);
                    $('.minRmsEnergy').html(audioQuality.detail.minRmsEnergy);
                    checkQuality();
                });
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);

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

    </script>

    <style>
        .good {
            background-color:#E7F4E1;
        }

        .bad {
            background-color:#FBDDDD;
        }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
