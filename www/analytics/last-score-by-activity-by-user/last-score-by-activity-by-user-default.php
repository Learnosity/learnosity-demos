<?php
use LearnositySdk\Request\Init;

$lastScoreBABUReportConfigDefault = array_merge($lastScoreBABUReportConfig, ['id' => "lastscore-by-activity-by-user-default"]);
$InitLastScoreBABUDefault = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBABUReportConfigDefault
    ],
]);
?>
<div class="lsbabu-report" id="lsbabu-report-default">
    <div class="learnosity-report" id="lastscore-by-activity-by-user-default"></div>
</div>

<script>
    const reportsAppDefault1 = LearnosityReports.init(<?= $InitLastScoreBABUDefault->generate(); ?>);
</script>
