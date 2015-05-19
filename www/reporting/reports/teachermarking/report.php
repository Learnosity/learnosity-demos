<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$sessionid = $_GET['session'];

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'reports' => array(
            array(
                'id'         => 'report-1',
                'type'       => 'session-detail-by-item',
                'user_id'    => 'demo_student',
                'session_id' => $sessionid
            )
        ),
    'configuration' => array(
        'questionsApiVersion' => 'v2',
        'itemsApiVersion' => 'v1'
    )
);

$init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Reports API – Constructed Response Marking</h1>
    </div>
</div>

<div class="section">
    <h3>Constructed Response</h3>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <!-- Container for the report to load into -->
            <span class="learnosity-report" id="report-1"></span>
        </div>
    </div>
</div>
<script src="<?php echo $url_reports; ?>"></script>
<script>
    var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
