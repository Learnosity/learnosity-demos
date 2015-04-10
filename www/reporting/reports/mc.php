<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$consumer_key = 'Marsh8ffEdSxqTTv';
$consumer_secret = 'DDrfQAZDgKhSgoXmB0VRysQA5XhzYiTUTsKG4FcM';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$report = array(
    'reports' => array(
            array(
                'id'         => 'report-1',
                'type'       => 'lastscore-by-tag-by-user',
                'users' => array(
                    array('id' => '56', 'name' => 'Ray Allen'),
                    array('id' => '56', 'name' => 'Jenson Button')
                ),
                'activity_id' => '9',
                'hierarchy' => 'DOK'
            )
        ),
    'configuration' => array(
        'questionsApiVersion' => 'v2',
        'itemsApiVersion' => 'v1'
    )
);

$initReport = new Init('reports', $security, $consumer_secret, $report);
$signedReportRequest = $initReport->generate();

?>

<div class="section">
    <hr>
    <div class="row">
        <div class="col-md-9">
            <!-- Container for the report to load into -->
            <span class="learnosity-report" id="report-1"></span>
        </div>
    </div>
</div>
<script src="//reports.learnosity.com"></script>
<script>
    var reportsApp = LearnosityReports.init(<?php echo $signedReportRequest; ?>);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
