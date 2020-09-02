<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$activity_id = 'Demo_Activity';

$security = [
    'user_id'      => 'demo_student',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'reports' => array(
        array(
            'id'         => 'report-1',
            'type'       => 'session-detail-by-item',
            'user_id'    => 'demo_student',
            'session_id' => $session_id
        )
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
