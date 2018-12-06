<?php

// This page generates two simple reports based on the resukts of the Tecthelp assessment demo

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

// Use the session_id from the previous page
$session_id = $_GET['session_id'];

$request = array(
    'reports' => array(
        array(
            'id'          => 'session-summary',
            'type'        => 'sessions-summary',
            'user_id'     => 'demo_student',
            'session_ids' => array(
                $session_id
            )
        ),
        array(
            'id' => 'session-detail-by-item',
            'type' => 'session-detail-by-item',
            'user_id' => 'demo_student',
            'session_id' => $session_id
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

        </ul>
    </div>
    <div class="overview">
        <h1>TextHelp - Learnosity integration</h1>
        <p>Simple reports page based on the TextHelp assessment questions.</p>
    </div>
</div>

<div class="section">

<!-- The Texthelp reader will ignore everything prior to this when $rw_setStartPoint is called below -->
    <span id="start"></span>

    <h4>Sessions Summary</h4>
    <div id="session-summary"></div>

    <h4>Session Detail By Question</h4>
    <div id="session-detail-by-item"></div>

    <div class="text-center" style="padding:40px;">
        <a class="btn btn-primary" href=itemsapi_texthelp.php>Start Again</a>
    </div>
</div>

<!--  Lead the Learnosity Reports API -->
<script src="<?php echo $url_reports; ?>"></script>

<!-- Load the TextHelp library -->
<script type="text/javascript" src="//learnositytoolbar.speechstream.net/learnosity/standardconfig.js"></script>

<script>

    var eventOptions = {
            readyListener: init
    },
    reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);
    function init () {
        console.log('Starting Texthelp now');
        TexthelpSpeechStream.addToolbar('1','1');
    }

    // This is called by the toolbar when it has loaded and finished processing.
    function $rw_toolbarLoadedCallback() {

        // Set the start point for the TextHelp reader
        $rw_setStartPoint("start");

        // Change the Session Summary report HTML to make it more readable
        // Replace '#' with 'Number' as the reader does not read the hash symbol. It would othewrwise read "Total of items", "of items correct" etc
        $(".lrn-report-area").each(function(i,e) {
          var updated_html =  $(e).html().replace("#", "Number");
          $(e).html(updated_html);
        });

        // Ignore the following parts of the report
        // This is the circle that shows the score for each item, typical content might be '1/91'
        $(".lrn-circle").attr('ignore', '1');
        // The response Index is the number of the response for question types such as ordered lists
        $(".lrn_responseIndex").attr('ignore', '1');
        // No need to read the header or column options in Choice Matrix tables
        $(".lrn-choicematrix-column-title").attr('ignore', '1');
        $(".lrn_choicematrix_cell").attr('ignore', '1');

    }

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
