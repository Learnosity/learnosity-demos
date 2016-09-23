<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

if ($_GET["session_id"]) {
    $session_id = $_GET["session_id"];
} elseif ($_POST["session_id"]) {
    $session_id = $_POST["session_id"];
} else {
    $session_id = 'fd09e334-875f-42c1-838c-aa90aba2bab1';
}

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'reports' => array(
        array(
            'id'         => 'report-detail',
            'type'       => 'session-detail-by-item',
            'user_id'    => $studentid,
            'session_id' => $session_id,
        )
    ),
    'configuration' => array(
        'questionsApiVersion' => 'v2'
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
        <h1>Reports API</h1>
        <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
    </div>
</div>

<div class="section">
    <span class="learnosity-report" id="report-detail"></span>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        var report = reportsApp.getReport('report-detail');

        report.on('ready:itemsApi', function (api) {
            console.log(api.getItemsMetadata());
        });
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
