<?php
use LearnositySdk\Request\Init;

$lastScoreBABUReportConfigCutScore1 = array_merge($lastScoreBABUReportConfig, ['id' => "lastscore-by-activity-by-user-cutscore1"]);
$InitLastScoreBABUCutScore1 = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBABUReportConfigCutScore1
    ],
]);
?>

<!--visualization checkboxes-->
<style>
    /* Styles for the checkbox when checked */
     input[type="checkbox"].highlight-fail-band-switch:checked {
        background-color:#34C759;
        width: 38px;
        height:23px;
        border-color: #34C759;
    }
    /* Styles for the checkbox when not checked */
     input[type="checkbox"].highlight-fail-band-switch:not(:checked) {
        width: 38px;
        height:23px;
    }
    .lrn-cut-score-switch {
        margin-bottom: 15px;
    }
    .switch-input {
        display: none;
    }
    .switch-label {
        display: block;
        width: 40px;
        height: 24px;
        background-color: gray;
        border-radius: 15px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .switch-label:before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        transition: left 0.3s ease;
    }
    .switch-input:checked + .switch-label {
        background-color: #34C759;
    }
    .switch-input:checked + .switch-label:before {
        left: calc(100% - 22px);
    }
    .switch-text {
        margin-left: 50px;
        width: 100px;
        display: inline-block
    }
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable {
        position: relative;
        vertical-align: middle;
    }

    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable:hover::before {
        content: '';
        position: absolute;
        top: 1px;
        left: 1px;
        right: 1px;
        bottom: 1px;
        box-shadow: 0 0 0 1px #696969;
    }

    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable:focus {
        border: 2px solid #333333;
    }
</style>
<!--visualization performance band fail styles-->
<style id="band-fail-styles-last-score-by-activity">
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table > tbody > tr > td[data-custom_performance="fail_band"] {
        background-color: #FBE3E3;
        font-weight: 700;
    }

    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table > tbody > tr > td[data-custom_performance="fail_band"]::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        right: 2px;
        bottom: 2px;
        box-shadow: 0 0 0 2px #DD002F;
    }
</style>

<div class="lsbabu-report"  id="lsbabu-report-cutscore1" style="display: none">
    <div class="form-check form-switch lrn-cut-score-switch" >

    <input type="checkbox" id="highlight-fail-band" class="switch-input highlight-fail-band-switch" checked >
        <label for="highlight-fail-band" class="switch-label"><span class="switch-text">Show failing</span></label>
    </div>

    <div class="learnosity-report" id="lastscore-by-activity-by-user-cutscore1"></div>
</div>

<script>
    // last score by item by user report with cut score demo 1
    const callbacksLastScoreByActivityCutScore1 = {
        readyListener: function () {
            const report = reportsAppLastScoreByActivityCutscore1.getReport('lastscore-by-activity-by-user-cutscore1');
            report.on('load:data', function(data) {
                console.log("cut score 1 load data: ", data);
            });
            report.on("click:score", function(data) {
                console.log("click score: ", data);
            });
            report.on("click:user", function(data) {
                console.log("click user: ", data);
            });
        },
        errorListener: function (err) {
            console.log(err);
        },
        cutScoreMutator: function(data) {
            processLastScoreByActivityCutscore1(data);
        }
    };

    function processLastScoreByActivityCutscore1(data) {
        let performanceBand = 'none';
        let voiceOverMessage = '';

        if (data.percentageItemsCorrect <= 50) {
            performanceBand = 'fail_band';
            voiceOverMessage = 'Highlighted as failed';
        }

        const customDomData = {
            performance: performanceBand,
        };
        data.domData = customDomData;
        data.voiceOverMessage = voiceOverMessage;
    }

    const reportsAppLastScoreByActivityCutscore1 = LearnosityReports.init(<?= $InitLastScoreBABUCutScore1->generate(); ?>, callbacksLastScoreByActivityCutScore1);

    initCustomControlsCutScoreLastScoreByActivity1();

    //add button handler for visualization checkboxes
    function initCustomControlsCutScoreLastScoreByActivity1() {
        window.failStylesForLastScoreByActivity = document.getElementById('band-fail-styles-last-score-by-activity');
        document.getElementById('highlight-fail-band').addEventListener('click', applyVisualizationCutScoreLastScoreByActivity1);
    }

    //show/hide borders to high and/or low scores
    function applyVisualizationCutScoreLastScoreByActivity1() {
        if (document.getElementById('highlight-fail-band').checked) {
            document.body.appendChild(window.failStylesForLastScoreByActivity);
        }
        else {
            window.failStylesForLastScoreByActivity.remove();
        }
    }
</script>
