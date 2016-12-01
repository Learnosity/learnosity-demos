<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;

if ($_GET["session_id"]) {
    $session_id = $_GET["session_id"];
} elseif ($_POST["session_id"]) {
    $session_id = $_POST["session_id"];
}

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$reportsRequest = [ 'reports' =>
    $reports = [
        [
            'id' => 'sessions-summary-div',
            'type' => 'session-summary',
            'user_id' => $studentid,
            'session_ids' => [ $session_id ],
        ],
        [
            'id' => 'session-detail-by-item-div',
            'type' => 'session-detail-by-item',
            'user_id' => $studentid,
            'session_id' => $session_id,
        ],
    ],
];

$reportsInit = new Init('reports', $security, $consumer_secret, $reportsRequest);
$signedRequest = $reportsInit->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1 id="session-head">Session Report</h1>
<?php if (isset($session_id)) { ?>
        <p>Report for session <?php print($session_id); ?></p>
<?php } else { ?>
        <p>Use this page to look-up the report for an existing session.<p>
        <form>
            <label for="session_id">Session ID:</label>
            <input name="session_id">
            <input type="submit" value="Get report">
        </form>
<?php } ?>
    </div>
</div>

<?php if (isset($session_id)) { ?>
<div class="section">
<h2>Session summary</h2>
<div id="sessions-summary-div"></div>
</div>

<div class="section">
<h2>Detailed report by question (Reports API)</h2>
<div id="session-detail-by-item-div"></div>
</div>

<script src="<?php echo $url_reports; ?>"></script>

<script>
var initOpts = <?php echo $signedRequest ?>;
var reportsApp = LearnosityReports.init(initOpts);
function onReportsReady() {
    var sessList = reportsApp.getReport("other-sessions");
    sessList.on('click:session', function (data) {
        console.log(
            'A session in the report was clicked: ' + data.session_id
        );
        window.location = window.location.protocol + "//" + window.location.host + window.location.pathname +  "?studentid=<?php print($studentid); ?>&sessid=" + data.session_id;
    });
}
</script>
<?php } ?>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
