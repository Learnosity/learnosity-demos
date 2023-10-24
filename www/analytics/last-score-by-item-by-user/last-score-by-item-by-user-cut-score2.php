<?php
use LearnositySdk\Request\Init;

$lastScoreBIBUReportConfigCutScore2 = array_merge($lastScoreBIBUReportConfig, ['id' => "lastscore-by-item-by-user-cutscore2"]);

$InitLastScoreBIBUCutScore2 = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBIBUReportConfigCutScore2
    ],
]);
?>
<style>
    .lsbibu-report .form-check-input:checked{
        accent-color: #1877B1;
    }
    .lsbibu-report .form-check-input + label {
        margin-left: 6px;
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 150%;
        color: #333333;
    }
    .lsbibu-report .controls-container {
        margin-bottom: 20px;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table .lrn-report-section.lrn-report-score {
        vertical-align: middle;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="1"] .lrn-report-user,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="2"] .lrn-report-user,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="3"] .lrn-report-user,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="4"] .lrn-report-user {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
    }
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="1"] .lrn-report-score,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="2"] .lrn-report-score,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="3"] .lrn-report-score,
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="4"] .lrn-report-score {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
        position: relative;
    }
    .learnosity-report.lastscore-by-item-by-user .table-bordered tr[data-custom_performance="1"] .lrn-report-score::after,
    .learnosity-report.lastscore-by-item-by-user .table-bordered tr[data-custom_performance="2"] .lrn-report-score::after,
    .learnosity-report.lastscore-by-item-by-user .table-bordered tr[data-custom_performance="3"] .lrn-report-score::after,
    .learnosity-report.lastscore-by-item-by-user .table-bordered tr[data-custom_performance="4"] .lrn-report-score::after {
        width: 28px;
        height: 28px;
        position: absolute;
        top: 45%;
        right: 26px;
        transform: translate(50%, -50%);
    }
</style>
<!--visualization background for cut score report-->
<style id="band-4-styles">
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="4"] {
        background: #B0D6A0;
    }
</style>
<style id="band-3-styles">
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="3"] {
        background: #F0F8ED;
    }
</style>
<style id="band-2-styles">
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="2"] {
        background: #FFEDDB;
    }
</style>
<style id="band-1-styles">
    .learnosity-report.lastscore-by-item-by-user .lrn-report-table tr[data-custom_performance="1"] {
        background: #FBE3E3;
    }
</style>

<div class="lsbibu-report"  id="lsbibu-report-cutscore2" style="display: none">
    <div class="controls-container">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-band-4" checked>
            <label class="form-check-label" for="highlight-band-4">
                Distinction (80 - 100%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-band-3">
            <label class="form-check-label" for="highlight-band-3">
                Credit (65 - 79%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-band-2">
            <label class="form-check-label" for="highlight-band-2">
                Pass (50 - 64%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-band-1">
            <label class="form-check-label" for="highlight-band-1">
                Fail (0 - 49%)
            </label>
        </div>
    </div>
    <div class="learnosity-report" id="lastscore-by-item-by-user-cutscore2"></div>
</div>
<script>
    const callbacksCutScore2 = {
        readyListener: function () {
            const report = reportsAppCutScore2.getReport('lastscore-by-item-by-user-cutscore2');
            report.on('load:data', function(data) {
                console.log("cut score 2 load data: ", data);
            });
        },
        errorListener: function (err) {
            console.log(err);
        },
        scoreMutator: function(data) {
            processScoresCutScore2(data);
        }
    };

    function processScoresCutScore2(data) {
        let performanceBand = 'none';
        let voiceOverMessage = '';

        if      (data.percentageItemsCorrect >= 80) { performanceBand = '4'; voiceOverMessage = "Distinction (80 - 100%)";}
        else if (data.percentageItemsCorrect >= 65) { performanceBand = '3'; voiceOverMessage = "Credit (65 - 79%)";}
        else if (data.percentageItemsCorrect >= 50) { performanceBand = '2'; voiceOverMessage = "Pass (50 - 64%)";}
        else if (data.percentageItemsCorrect >=  0) { performanceBand = '1'; voiceOverMessage = "Fail (0 - 49%)";}
        const customDomData = {
            performance: performanceBand
        };
        data.domData = customDomData;
        data.voiceOverMessage = voiceOverMessage;
    }

    const reportsAppCutScore2 = LearnosityReports.init(<?= $InitLastScoreBIBUCutScore2->generate(); ?>, callbacksCutScore2);

    initCustomControlsCutScore2();

    applyVisualizationCutScore2();

    //add button handler for visualization checkboxes
    function initCustomControlsCutScore2() {
        window.band4scoreStyles = document.getElementById('band-4-styles');
        window.band3scoreStyles = document.getElementById('band-3-styles');
        window.band2scoreStyles = document.getElementById('band-2-styles');
        window.band1scoreStyles = document.getElementById('band-1-styles');

        document.getElementById('highlight-band-1').addEventListener('click', applyVisualizationCutScore2);
        document.getElementById('highlight-band-2').addEventListener('click', applyVisualizationCutScore2);
        document.getElementById('highlight-band-3').addEventListener('click', applyVisualizationCutScore2);
        document.getElementById('highlight-band-4').addEventListener('click', applyVisualizationCutScore2);
    }

    //show/hide borders to high and/or low scores
    function applyVisualizationCutScore2() {
        if (document.getElementById('highlight-band-4').checked) {
            document.body.appendChild(window.band4scoreStyles);
        } else {
            window.band4scoreStyles.remove();
        }

        if (document.getElementById('highlight-band-3').checked) {
            document.body.appendChild(window.band3scoreStyles);
        } else {
            window.band3scoreStyles.remove();
        }

        if (document.getElementById('highlight-band-2').checked) {
            document.body.appendChild(window.band2scoreStyles);
        } else {
            window.band2scoreStyles.remove();
        }

        if (document.getElementById('highlight-band-1').checked) {
            document.body.appendChild(window.band1scoreStyles);
        } else {
            window.band1scoreStyles.remove();
        }
    }
</script>
