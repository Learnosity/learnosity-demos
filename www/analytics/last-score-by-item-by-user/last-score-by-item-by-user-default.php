<?php
use LearnositySdk\Request\Init;

$lastScoreBIBUReportConfigDefault = array_merge($lastScoreBIBUReportConfig, ['id' => "lastscore-by-item-by-user-default"]);
$InitLastScoreBIBUDefault = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBIBUReportConfigDefault
    ],
]);
?>
<div class="lsbibu-report" id="lsbibu-report-default">
    <div class="learnosity-report" id="lastscore-by-item-by-user-default"></div>
</div>

<script>
    const reportsAppDefault = LearnosityReports.init(<?= $InitLastScoreBIBUDefault->generate(); ?>);
</script>

