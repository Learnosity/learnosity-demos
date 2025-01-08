<?php
use LearnositySdk\Request\Init;

$lastScoreBIBUReportConfigCutScore1 = array_merge($lastScoreBIBUReportConfig, ['id' => "lastscore-by-item-by-user-cutscore1"]);
$InitLastScoreBIBUCutScore1 = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBIBUReportConfigCutScore1
    ],
]);
?>

<!--visualization checkboxes-->
<style>
    /* Styles for the checkbox when checked */
    .lsbibu-report input[type="checkbox"].highlight-band-fail-switch:checked {
        background-color:#34C759;
        width: 38px;
        height:23px;
        border-color: #34C759;
    }
    /* Styles for the checkbox when not checked */
    .lsbibu-report input[type="checkbox"].highlight-band-fail-switch:not(:checked) {
        width: 38px;
        height:23px;
    }
    .lsbibu-report .lrn-cut-score-switch {
        margin-bottom: 15px;
    }
    .lsbibu-report .switch-input {
        display: none;
    }
    .lsbibu-report .switch-label {
        display: block;
        width: 40px;
        height: 24px;
        background-color: gray;
        border-radius: 15px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .lsbibu-report .switch-label:before {
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
    .lsbibu-report .switch-input:checked + .switch-label {
        background-color: #34C759;
    }
    .lsbibu-report .switch-input:checked + .switch-label:before {
        left: calc(100% - 22px);
    }
    .lsbibu-report .switch-text {
        margin-left: 50px;
        width: 100px;
        display: inline-block
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable {
        position: relative;
        vertical-align: middle;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable:hover {
        text-decoration: underline;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable:hover::before {
        content: '';
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        box-shadow: 0 0 0 1px #696969;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table > tbody > tr > td.lrn-report-clickable:focus {
        border: 2px solid #333333;
    }
</style>
<!--visualization performance band fail styles-->
<style id="band-fail-styles">
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="fail"] {
        background-color: #FBE3E3;
        border: 1px solid #DADADA;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="fail"] .lrn-report-user {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
        position: relative;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="fail"] .lrn-report-user::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 4px;
        background-color: #DD002F;
    }

    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="fail"] .lrn-report-score {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
    }
</style>

<div class="lsbibu-report"  id="lsbibu-report-cutscore1" style="display: none">
    <div class="form-check form-switch lrn-cut-score-switch">
        <input type="checkbox" id="highlight-band-fail" class="switch-input highlight-band-fail-switch" checked>
        <label for="highlight-band-fail" class="switch-label"><span class="switch-text">Show failing</span></label>
    </div>
    <div class="learnosity-report" id="lastscore-by-item-by-user-cutscore1"></div>
</div>

<script>
    // last score by item by user report with cut score demo 1
    const callbacksCutScore1 = {
        readyListener: function () {
            const report = reportsAppCutScore1.getReport('lastscore-by-item-by-user-cutscore1');
            report.on('load:data', function(data) {
                console.log("cut score 1 load data:-------- ", data);
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
            processScoresCutScore1(data);
        }
    };

    function processScoresCutScore1(data) {
        let performanceBand = 'none';
        let voiceOverMessage = '';

        if (data.percentageItemsCorrect < 50) {
            performanceBand = 'fail';
            voiceOverMessage = 'Highlighted as failed';
        }

        const customDomData = {
            performance: performanceBand,
        };
        data.domData = customDomData;
        data.voiceOverMessage = voiceOverMessage;
    }

    const reportsAppCutScore1 = LearnosityReports.init(<?= $InitLastScoreBIBUCutScore1->generate(); ?>, callbacksCutScore1);

    initCustomControlsCutScore1();

    //add button handler for visualization checkboxes
    function initCustomControlsCutScore1() {
        window.failStyles = document.getElementById('band-fail-styles');
        document.getElementById('highlight-band-fail').addEventListener('click', applyVisualizationCutScore1);
    }

    //show/hide borders to high and/or low scores
    function applyVisualizationCutScore1() {
        if (document.getElementById('highlight-band-fail').checked) {
            document.body.appendChild(window.failStyles);
        }
        else {
            window.failStyles.remove();
        }
    }
</script>
