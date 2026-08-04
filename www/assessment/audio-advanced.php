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
                <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
                <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
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
                    <table class="table table-bordered table-sm">
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
                    document.querySelector('.numberOfClippingSamples').innerHTML = audioQuality.detail.numberOfClippingSamples;
                    document.querySelector('.maxRmsEnergy').innerHTML = audioQuality.detail.maxRmsEnergy;
                    document.querySelector('.minRmsEnergy').innerHTML = audioQuality.detail.minRmsEnergy;
                    checkQuality();
                });
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);

        function checkQuality() {
            document.querySelectorAll('.good,.bad').forEach(function (element) {
                element.classList.remove("good", "bad");
            });
            if (parseFloat(document.querySelector('.numberOfClippingSamples').innerHTML, 10) > parseFloat(document.querySelector('.numberOfClippingSamples_inp').value, 10)) {
                document.querySelector('.numberOfClippingSamples').classList.add('bad');
                document.querySelector('.numberOfClippingSamples_result').classList.add('bad');
                document.querySelector('.numberOfClippingSamples_result').innerHTML = 'Too Loud';
            } else {
                document.querySelector('.numberOfClippingSamples').classList.add('good');
                document.querySelector('.numberOfClippingSamples_result').classList.add('good');
                document.querySelector('.numberOfClippingSamples_result').innerHTML = 'Acceptable';
            }
            if (parseFloat(document.querySelector('.maxRmsEnergy').innerHTML, 10) < parseFloat(document.querySelector('.maxRmsEnergy_inp').value, 10)) {
                document.querySelector('.maxRmsEnergy').classList.add('bad');
                document.querySelector('.maxRmsEnergy_result').classList.add('bad');
                document.querySelector('.maxRmsEnergy_result').innerHTML = 'Too Quiet';
            } else {
                document.querySelector('.maxRmsEnergy').classList.add('good');
                document.querySelector('.maxRmsEnergy_result').classList.add('good');
                document.querySelector('.maxRmsEnergy_result').innerHTML = 'Acceptable';
            }
            if (parseFloat(document.querySelector('.minRmsEnergy').innerHTML, 10) > parseFloat(document.querySelector('.minRmsEnergy_inp').value, 10)) {
                document.querySelector('.minRmsEnergy').classList.add('bad');
                document.querySelector('.minRmsEnergy_result').classList.add('bad');
                document.querySelector('.minRmsEnergy_result').innerHTML = 'Background Noise';
            } else {
                document.querySelector('.minRmsEnergy').classList.add('good');
                document.querySelector('.minRmsEnergy_result').classList.add('good');
                document.querySelector('.minRmsEnergy_result').innerHTML = 'Acceptable';
            }
        }

        document.querySelectorAll('.checkQualityInputs input').forEach(function (input) {
            input.addEventListener("change", checkQuality);
        });

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
