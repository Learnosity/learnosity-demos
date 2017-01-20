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
    'activity_template_id'=> 'TEXTHELP_ACTIVITY',
    'type' => "submit_practice",
    'state' => "initial",
    'activity_id' => 'Activity_Test',
    'name' => "Test Assessment",
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'summary_report.php?session_id='. $session_id
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>TextHelp - Learnosity integration</h1>
        <p>This demo shows how Texthelp's SpeechStream product can be integrated into a Learnosity assessment with ease.</p>
        <p><a href="https://www.texthelp.com/en-us/products/speechstream">SpeechStream</a> is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their products. This feature is used by students with learning disabilities, such as dyslexia, struggling readers, English language learners, auditory learners, and students with mild vision impairments. Note that this is licensed directly from Texthelp, and not included in a Learnosity license.
        </p>
        <p>The SpeechStream Toolbar will appear when the assessment is started and each Item will be read as soon as it loads.</p>
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

            // Log the current item.
            assessApp.on('item:load', function () {

                setTimeout('$rw_tagSentences()',500);

                $(".lrn-accessibility-label").attr('ignore', '1');

                $(".test-title-text").attr('ignore', '1');

                $(".subtitle").attr('ignore', '1');
                $(".item-count").attr('ignore', '1');
                $(".timer").attr('ignore', '1');
                $(".lrn_sort_gripper").attr('ignore', '1');
                $(".lrn-choicematrix-column-title").attr('ignore', '1');

                setTimeout('$rw_speakFirstSentence()',500);
                console.log('Reading');
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
