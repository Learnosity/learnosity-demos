<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = [
    "consumer_key"    => $consumer_key ,
    "domain"          => $domain
];

$request = [
    'rendering_type' => "assess",
    'user_id' => "demo_student",
    'session_id' => $session_id,
    'activity_template_id'=> 'TexttoSpeech_Testing_Activity',
    'type' => "submit_practice",
    'activity_id' => 'Activity_Test',
    'name' => "Test Assessment",
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'summary_report.php?session_id='. $session_id
        ],
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    ]
];

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

        <h1>Partner:  Texthelp Integration</h1>
        <p>This demo shows how Texthelp's SpeechStream product can be integrated into a Learnosity assessment with ease.</p>
        <p><a href="https://www.texthelp.com/en-us/products/speechstream">SpeechStream</a> is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their products. This feature is used by students with learning disabilities, such as dyslexia, struggling readers, English language learners, auditory learners, and students with mild vision impairments.</p>
        <a href='https://www.texthelp.com' target='_blank' title='Learn about solutions from our partner Texthelp'><img src='https://www.texthelp.com/CMSTemplates/Texthelp/Includes/build/assets/images/logo.png' alt='Texthelp Logo' class='pull-right' /></a>
        <p>If you have a Texthelp licence - it integrates effortlessly with Learnosity.</p>
        <p>The SpeechStream Toolbar will appear when the assessment is started.</p>
    </div>
</div>

<div class="section">

    <!-- TextHelp start point indicator -->
    <span id="start"></span>
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>

</div>

<!-- Load Learnosity -->
<script src="<?php echo $url_items; ?>"></script>
<!-- Load the TextHelp library -->
<script type="text/javascript" src="//learnositytoolbar.speechstream.net/learnosity/standardconfig.js"></script>

<script>

    var initOptions = <?php echo $signedRequest; ?>

    var itemsApp = LearnosityItems.init(initOptions, {
        readyListener: function () {
            console.log("Listener fired");

            var assessApp = itemsApp.assessApp();

            assessApp.on('test:start', function() {

                // When the assessment starts we find the elements within the assessment wrapper that we want the Texthelp reader to ignore and add the 'ignore' attribute to them.


                // Initiate Texthelp only when the Learnoisty assessment starts
                TexthelpSpeechStream.addToolbar('1','1');
            });

        }

    });

    // This is called by the toolbar when it has loaded and finished processing.
    function $rw_toolbarLoadedCallback() {

        // Set the start point for the TextHelp reader
        $rw_setStartPoint("start");
    }

</script>

<?php
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
