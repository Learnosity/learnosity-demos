<?php

// This page generates two simple reports based on the resukts of the Tecthelp assessment demo
include_once '../../config.php';
include_once 'includes/header.php';

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
            'type'        => 'session-summary',
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
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>TextHelp - Learnosity integration</h1>
        <p>Simple reports page based on the TextHelp assessment questions.</p>
    </div>
</div>

<div class="section">
    <h4>Sessions Summary</h4>
    <div id="session-summary"></div>

    <h4>Session Detail By Question</h4>
    <div id="session-detail-by-item"></div>
</div>

<script src="<?php echo $url_reports; ?>"></script>

<script>

    var eventOptions = {
            readyListener: init
        },
        reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);
        function init () {        
    }

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
