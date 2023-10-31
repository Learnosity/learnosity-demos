<?php
use LearnositySdk\Request\Init;

$lastScoreBABUReportConfigCutScore2 = array_merge($lastScoreBABUReportConfig, ['id' => "lastscore-by-activity-by-user-cutscore2"]);

$InitLastScoreBABUCutScore2 = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBABUReportConfigCutScore2
    ],
]);
?>
<style>
    .form-check-input:checked{
        accent-color: #1877B1;
    }
    .form-check-input + label {
        margin-left: 6px;
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 150%;
        color: #333333;
    }
    .controls-container {
        margin-bottom: 20px;
    }
</style>
<!--visualization background for cut score report-->
<style id="last-score-by-activity-group-4-styles">
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table> tbody > tr > td[data-custom_performance="4"] {
        background: #B0D6A0;
        font-weight: 700;
    }
</style>
<style id="last-score-by-activity-group-3-styles">
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table> tbody > tr > td[data-custom_performance="3"] {
        background: #F0F8ED;
        font-weight: 700;
    }
</style>
<style id="last-score-by-activity-group-2-styles">
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table> tbody > tr > td[data-custom_performance="2"] {
        background: #FFEDDB;
        font-weight: 700;
    }
</style>
<style id="last-score-by-activity-group-1-styles">
    .learnosity-report.lastscore-by-activity-by-user .lrn-report-table> tbody > tr >td[data-custom_performance="1"] {
        background: #FBE3E3;
        font-weight: 700;
    }
</style>

<div class="lsbabu-report"  id="lsbabu-report-cutscore2" style="display: none" >
    <div class="controls-container">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-group-4" checked>
            <label class="form-check-label" for="highlight-group-4">
                Distinction (80 - 100%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-group-3">
            <label class="form-check-label" for="highlight-group-3">
             Credit (65 - 79%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-group-2">
            <label class="form-check-label" for="highlight-group-2">
            Pass (50 - 64%)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="highlight-group-1">
            <label class="form-check-label" for="highlight-group-1">
            Fail (0 - 49%)
            </label>
        </div>
    </div>
    <div class="learnosity-report" id="lastscore-by-activity-by-user-cutscore2"></div>
</div>
<script>
    const callbacksLastScoreByActivityCutScore2 = {
        readyListener: function () {
            const report = reportsAppLastScoreByActivityCutscore2.getReport('lastscore-by-activity-by-user-cutscore2');
            report.on('load:data', function(data) {
                console.log("cut score 2 load data: ", data);
            });
        },
        errorListener: function (err) {
            console.log(err);
        },
        cutScoreMutator: function(data) {
            processLastScoreByActivityCutScore2(data);
        }
    };

    function  processLastScoreByActivityCutScore2(data) {
        let performanceBand = 'none';
        let voiceOverMessage = '';

        if      (data.percentageItemsCorrect >= 80) { performanceBand = '4'; voiceOverMessage = "Distinction";}
        else if (data.percentageItemsCorrect >= 65) { performanceBand = '3'; voiceOverMessage = "Credit";}
        else if (data.percentageItemsCorrect >= 50) { performanceBand = '2'; voiceOverMessage = "Pass";}
        else if (data.percentageItemsCorrect >=  0) { performanceBand = '1'; voiceOverMessage = "Fail";}
        const customDomData = {
            performance: performanceBand
        };
        data.domData = customDomData;
        data.voiceOverMessage = voiceOverMessage;
    }

    const reportsAppLastScoreByActivityCutscore2 = LearnosityReports.init(<?= $InitLastScoreBABUCutScore2->generate(); ?>, callbacksLastScoreByActivityCutScore2);

    initLastScoreByActivityCustomControlsCutScore2();

    applyLastScoreByActivityVisualizationCutScore2();

    //add button handler for visualization checkboxes
    function initLastScoreByActivityCustomControlsCutScore2() {
        window.lastScoreByActivityBand4scoreStyles = document.getElementById('last-score-by-activity-group-4-styles');
        window.lastScoreByActivityBand3scoreStyles = document.getElementById('last-score-by-activity-group-3-styles');
        window.lastScoreByActivityBand2scoreStyles = document.getElementById('last-score-by-activity-group-2-styles');
        window.lastScoreByActivityBand1scoreStyles = document.getElementById('last-score-by-activity-group-1-styles');

        document.getElementById('highlight-group-1').addEventListener('click', applyLastScoreByActivityVisualizationCutScore2);
        document.getElementById('highlight-group-2').addEventListener('click', applyLastScoreByActivityVisualizationCutScore2);
        document.getElementById('highlight-group-3').addEventListener('click', applyLastScoreByActivityVisualizationCutScore2);
        document.getElementById('highlight-group-4').addEventListener('click', applyLastScoreByActivityVisualizationCutScore2);
    }

    //show/hide borders to high and/or low scores
    function applyLastScoreByActivityVisualizationCutScore2() {
        if (document.getElementById('highlight-group-4').checked) {
            document.body.appendChild(window.lastScoreByActivityBand4scoreStyles);
        } else {
            window.lastScoreByActivityBand4scoreStyles.remove();
        }

        if (document.getElementById('highlight-group-3').checked) {
            document.body.appendChild(window.lastScoreByActivityBand3scoreStyles);
        } else {
            window.lastScoreByActivityBand3scoreStyles.remove();
        }

        if (document.getElementById('highlight-group-2').checked) {
            document.body.appendChild(window.lastScoreByActivityBand2scoreStyles);
        } else {
            window.lastScoreByActivityBand2scoreStyles.remove();
        }

        if (document.getElementById('highlight-group-1').checked) {
            document.body.appendChild(window.lastScoreByActivityBand1scoreStyles);
        } else {
            window.lastScoreByActivityBand1scoreStyles.remove();
        }
    }
</script>
