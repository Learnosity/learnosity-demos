<?php

include_once '../../config.php';
include_once 'includes/header.php';

use \LearnositySdk\Request\Init;
use \LearnositySdk\Request\DataApi;
use \LearnositySdk\Utils\Uuid;

$sessionId = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$reportsRequest = [ 'reports' =>
    $reports = [
        [
            'id' => 'sessions-summary-div',
            'type' => 'sessions-summary',
            'user_id' => $studentid,
            'session_ids' => [ $sessionId ],
        ],
        [
            'id' => 'session-detail-by-item-div',
            'type' => 'session-detail-by-item',
            'user_id' => $studentid,
            'session_id' => $sessionId,
        ],
    ],
];

$reportsInit = new Init('reports', $security, $consumer_secret, $reportsRequest);
$signedRequest = $reportsInit->generate();

$dataRequest =  [
    'session_id' => [ $sessionId ],
];
$dataAction = 'get';

$dataApi = new DataApi();
$adaptiveReportUrl = "{$url_data}/sessions/reports/adaptive";
$dataOutput = $dataApi->request(
    $adaptiveReportUrl,
    $security,
    $consumer_secret,
    $dataRequest,
    $dataAction
);

?>

<div class="jumbotron section">
    <h1>Items API - Adaptive Session Reports</h1>
    <p>In addition to the standard reports, each adaptive activity can provide more information in a custom report. </p>
    <p><small>Note: You might need to refresh this page after the submission has been processed for data to show up
        here. A few seconds' wait should be sufficient.</small></p>
</div>
<div class="section">
    <h2>Session summary (<a href="/analytics/reports/">Reports API</a>)</h2>
    <div id="sessions-summary-div"></div>
</div>

<div class="section">
<h2>Report Data (<a href="/analytics/data/">Data API</a>)</h2>
<h3>Request for <?php print($adaptiveReportUrl); ?></h3>
<pre>
<?php print(json_encode($dataRequest, JSON_PRETTY_PRINT)); ?>
</pre>
<h3>Response</h3>
<pre>
<?php print(json_encode(json_decode($dataOutput->getBody()), JSON_PRETTY_PRINT)); ?>
</pre>
</div>

<div class="section">
    <h2>Detailed report by question (<a href="/analytics/reports/">Reports API</a>)</h2>
    <div id="session-detail-by-item-div"></div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>
    var initOpts = <?php echo $signedRequest ?>;
    var reportsApp = LearnosityReports.init(initOpts);
</script>
