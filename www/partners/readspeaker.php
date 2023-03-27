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
    "consumer_key"    => $consumer_key ,
    "domain"          => $domain
];

$request = [
    'activity_id' => 'Activity_Test',
    'activity_template_id' => 'TexttoSpeech_Testing_Activity_2',
    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'type' => 'submit_practice',
    'name' => 'Test Assessment',
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'readspeaker.php'
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
        </ul>
    </div>
    <div class="overview">
        <h2>Text to Speech solution: ReadSpeaker</h2>
        <p>ReadSpeaker’s text-to-speech solutions provide Learnosity clients with the ability for their learners to listen to multiple formats of
        educational content in over 50 languages and 200+ voices. Their end-to-end technology allows control for real-time adjustments to
        provide a better user experience with constantly improving voices.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>

<!-- Load Learnosity -->
<script src="<?php echo $url_items; ?>"></script>

<!-- Load ReadSpeaker-->
<script src="//cdn1.readspeaker.com/script/11130/webReader/ReadSpeaker.Learnosity.js" type="text/javascript"></script>

<script>

    var initializationObject = <?php echo $signedRequest; ?>

    //optional callback for ready
    var eventOptions = {
        readyListener: function() {
            console.log("Items API has successfully initialized.");
            // Callback used to initialise ReadSpeaker toolbar once Learnosity assessment renders.
            window.rsCallbacks.readyListener();
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    var itemsApp = LearnosityItems.init(initializationObject, eventOptions);

</script>


<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
