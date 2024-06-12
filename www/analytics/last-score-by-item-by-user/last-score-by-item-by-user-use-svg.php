<?php
use LearnositySdk\Request\Init;

$lastScoreBIBUReportConfigUsesvg = array_merge($lastScoreBIBUReportConfig, ['id' => "lastscore-by-item-by-user-use-svg"]);
$InitLastScoreBIBUUsesvg = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBIBUReportConfigUsesvg
    ],
    'configuration' => [
     'useSVG' => true,
    ]
]);
?>

<div class="lsbibu-report" id="lsbibu-report-usesvg" style="display:none">
    <div class="learnosity-report" id="lastscore-by-item-by-user-use-svg"></div>
</div>

<script>
    const reportsAppUsesvg = LearnosityReports.init(<?= $InitLastScoreBIBUUsesvg->generate(); ?>);
</script>
