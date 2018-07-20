<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_template_id' => 'demo-activity-1',
    'activity_id'          => 'my-demo-activity',
    'name'                 => 'Demo Activity',
    'session_id'           => Uuid::generate(),
    'user_id'              => $studentid,
    'config'               => array(
        'configuration' => array(
            'submit_failed_options' => array(
                'mailto' => true,
                'download' => true
            )
        ),
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/items" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Failed Submission</h1>
        <p>Simulates submitting an activity where the network connection isn't available.</p>
        <p>Students get 3 attempts to submit a test before being presented with options to manually
        retrieve their encoded assessment data.</p>
        <p>They also have the chance to keep submitting their activity.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        activity     = <?php echo $signedRequest; ?>,
        itemsApp     = LearnosityItems.init(activity, eventOptions),
        submitNumber = 0;

        function init () {
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
        }
</script>

<?php
    include_once 'views/modals/settings-items-failed-submit.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
