<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = $_GET['session_id'];
$activity_id = 'Demo_Activity';

$security = [
    'user_id'      => $studentid,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id'         => 'report-1',
            'type'       => 'session-detail-by-item',
            'user_id'    => $studentid,
            'session_id' => $session_id
        )
    ),
    'configuration' => array(
        'questionsApiVersion' => 'v2',
        'itemsApiVersion' => 'v1'
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Reporting Feedback</h1>
        <p>Using Reports API on the left side you can see the student answers.</p>
        <p>On the right side of the page the teacher can provide additional subjective feedback to the student, alongside the existing objective scoring.</p>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="col-md-6">
            <h1>Student Review</h1>
        </div>

    </div>
    <span class="learnosity-report" id="report-1"></span>

</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>


reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

</script>


<?php
    include_once 'includes/footer.php';
