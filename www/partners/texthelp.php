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
    'activity_template_id'=> 'TexttoSpeech_Testing_Activity',

    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'type' => 'submit_practice',
    'name' => 'Test Assessment',
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'texthelp.php'
        ],
        'region_overrides' => [
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'custom_button',
                    'options' => [
                        'name' => 'SpeechStream',
                        'label' => 'SpeechStream',
                        'icon_class' => 'lrn_btn SpeechStream_btn'
                    ]
                ],
                [
                    'type' => 'verticaltoc_element'
                ]
            ]
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
        <h2>Using Third-Party Assistive Tools: TextHelp</h2>
        <p>This demo shows how Texthelp's SpeechStream product can be integrated into a Learnosity assessment with ease.</p>
        <p><a href="https://www.texthelp.com/en-us/products/speechstream">SpeechStream</a> is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their products. This feature is used by students with learning disabilities, such as dyslexia, struggling readers, English language learners, auditory learners, and students with mild vision impairments.</p>
        <a href='https://www.texthelp.com' target='_blank' title='Learn about solutions from our partner Texthelp'><img src='../static/images/texthelp-logo.png' alt='Texthelp Logo' class='pull-right' /></a>
        <p>If you have a Texthelp license - it integrates effortlessly with Learnosity.</p>
        <p>The SpeechStream Toolbar will appear in the upper right corner of the screen, when the assessment is started.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- TextHelp start point indicator -->
    <span id="start"></span>
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>

<!-- Load Learnosity -->
<script src="<?php echo $url_items; ?>"></script>
<!-- Load the TextHelp library -->
<script type="text/javascript" src="https://configuration.speechstream.net/learnosity/v217/config.js"></script>

<script>

    var initializationObject = <?php echo $signedRequest; ?>

    var itemsApp = LearnosityItems.init(initializationObject, {
        readyListener: function () {
            console.log("Listener fired");
            var assessApp = itemsApp.assessApp();
            assessApp.on('test:start', function() {
                // When the assessment starts, Texthelp’s SpeechStream will parse through the DOM
                // and dynamically ignore certain specified ‘classes’ that are listed in SpeechStream’s configuration file,
                // which were previously identified as not to be read aloud.
                TexthelpSpeechStream.addToolbar();
            });
            assessApp.on('button:SpeechStream:clicked', function(){
                showSpeechStreamBar();
            });
        }
    });

    // This is called by the toolbar when it has loaded and finished processing.
    function $rw_toolbarLoadedCallback() {
        // Set the start point for the TextHelp reader
        $rw_setStartPoint("start");
    }

    var showSpeechStream = true;

    function showSpeechStreamBar(){
        showSpeechStream = !showSpeechStream;
        window.texthelp.SpeechStream.ui.toolbar.toolbar.setVisibility(showSpeechStream);
        $rw_stopSpeech();
        $rw_enableClickToSpeak(false);
    }

</script>

<style>
    .lrn.lrn-assess .lrn-region:not(.lrn-items-region) .lrn_btn.SpeechStream_btn{
        padding: 0.4em 0.9em 0.4em 0.7em;
    }
    @media all and (max-width: 991px) {
        .lrn.lrn-assess .lrn-region:not(.lrn-items-region) .lrn_btn.SpeechStream_btn{
            padding: 0.75em 0.25em;
        }
    }
    button.lrn_btn.SpeechStream_btn:before{
        content: '';
        background-image: url('../static/images/speechstream-logo.png');
        background-size: contain;
        float: left;
        padding: 6px;
        height: 26px;
        width: 23px;
    }
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
