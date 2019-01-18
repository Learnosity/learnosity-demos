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
    'activity_id' => 'failedsubmissiondemo',
    'name' => 'Items API - Failed Submission',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'demos-site',
    'activity_template_id' => 'demo-activity-1',
    'config' => [
        'configuration' => [
            'submit_failed_options' => [
                'mailto' => true,
                'download' => true
            ]
        ],
        'title' => 'Demo activity - failed submission',
        'subtitle' => 'Walter White',
        'regions' => 'main'
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Handling Submission Failures and Preserving Responses</h2>
            <p>This demo simulates submitting an activity where the network connection isn't available.</p>
            <p>Students get 3 attempts to submit a test before being presented with options to manually
            retrieve their encoded assessment data.</p>
            <p>They also have the chance to keep submitting their activity.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>,
            submitNumber = 0;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                itemsApp.assessApp().on('test:save:error', function (e) {
                    console.log('test:save:error');
                    console.log(e);
                });
                itemsApp.assessApp().on('test:submit:error', function (e) {
                    console.log('test:submit:error');
                    console.log(e);
                });

                itemsApp.assessApp().questionsApp().submit = function (settings) {
                    submitNumber++;
                    settings.error({message: 'error'});
                    if (!$('#alert-submit-error').length && submitNumber < 3) {
                        $('#test-save-submit .modal-dialog').append(
                            '<div class="alert alert-info" role="alert" style="margin-top: 20px" id="alert-submit-error">Make sure you <em>Try again</em> twice</div>'
                        );
                    }
                    if (submitNumber >= 3) {
                        $('#alert-submit-error').hide();
                    }
                };
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/settings-items-failed-submit.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
