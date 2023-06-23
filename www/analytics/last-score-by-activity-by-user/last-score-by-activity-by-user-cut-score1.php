<?php
use LearnositySdk\Request\Init;

$lastScoreBABUReportConfigCutScore11 = array_merge($lastScoreBABUReportConfig, ['id' => "lastscore-by-activity-by-user-cutscore1"]);
$InitLastScoreBABUCutScore11 = new Init('reports', $security, $consumer_secret, [
    'reports' => [
        $lastScoreBABUReportConfigCutScore11
    ],
]);
?>

<!--visualization checkboxes-->
<style>
    /* Styles for the checkbox when checked */
    input[type="checkbox"].highlight-band-fail1-switch:checked {
        background-color:#34C759;
        width: 38px;
        height:23px;
        border-color: #34C759;
    }
    /* Styles for the checkbox when not checked */
    input[type="checkbox"].highlight-band-fail1-switch1:not(:checked) {
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
    .learnosity-report .lrn-report-table > tbody > tr > td.lrn-report-clickable {
        position: relative;
        vertical-align: middle;
    }
    .learnosity-report .lrn-report-table > tbody > tr > td.lrn-report-clickable:hover {
        text-decoration: underline;
    }
    .learnosity-report .lrn-report-table > tbody > tr > td.lrn-report-clickable:hover::before {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        box-shadow: 0 0 0 1px #696969;
    }
    .learnosity-report .lrn-report-table > tbody > tr > td.lrn-report-clickable:focus {
        border: 2px solid #333333;
    }
</style>
<!--visualization performance band fail styles-->
<style id="band-fail-styles1">
    td[data-custom_performance="fail"] {
        background-color: #FBE3E3;
        font-weight: 700;
    }
    .learnosity-report .lrn-report-table > tbody > tr > td[data-custom_performance="fail"] {
        border: 2px solid #DD002F;
    }
     /* .learnosity-report .lrn-report-table td[data-custom_performance="fail"] .lrn-report-user {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
        position: relative;
    } 
    .learnosity-report .lrn-report-table td[data-custom_performance="fail"] .lrn-report-user::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 4px;
        background-color: #DD002F;
    } 

    .learnosity-report .lrn-report-table td[data-custom_performance="fail"] .lrn-report-score {
        font-family: 'Helvetica Neue';
        font-style: normal;
        font-weight: 700;
        font-size: 13px;
        border: 2px solid #DD002F
    }  */
</style>

<div class="lsbabu-report"  id="lsbabu-report-cutscore1" style="display: none">
    <div class="form-check form-switch lrn-cut-score-switch" >
    
    <input type="checkbox" id="highlight-band-fail1" class="switch-input highlight-band-fail1-switch1" checked >
        <label for="highlight-band-fail1" class="switch-label"><span class="switch-text">Show failing</span></label>
    </div>

    <div class="learnosity-report" id="lastscore-by-activity-by-user-cutscore1"></div>
</div>

<script>
    // last score by item by user report with cut score demo 1
    const callbacksCutScore11 = {
        readyListener: function () {
            const report1 = reportsAppCutScore11.getReport('lastscore-by-activity-by-user-cutscore1');
            report1.on('load:data', function(data) {
                console.log("cut score 1 load data: ", data);
            });
            report1.on("click:score", function(data) {
                console.log("click score: ", data);
            });
            report1.on("click:user", function(data) {
                console.log("click user: ", data);
            });
        },
        errorListener: function (err) {
            console.log(err);
        },
        scoreMutator: function(data) {
            console.log("DATA1",data);
            processScoresCutScore1(data);
        }
    };

    function processScoresCutScore1(data) {
        console.log("DATA2",data);
        console.log("PIC",data.percentageItemsCorrect);
        let performanceBand = 'none';
        let voiceOverMessage = '';

        if (data.percentageItemsCorrect <= 50) {
            performanceBand = 'fail';
            voiceOverMessage = 'Highlighted as failed';
        }

        const customDomData = {
            performance: performanceBand,
        };
        data.domData = customDomData;
        data.voiceOverMessage = voiceOverMessage;
    }

    const reportsAppCutScore11 = LearnosityReports.init(<?= $InitLastScoreBABUCutScore11->generate(); ?>, callbacksCutScore11);

    initCustomControlsCutScore11();

    //add button handler for visualization checkboxes
    function initCustomControlsCutScore11() {
        window.failStyles = document.getElementById('band-fail-styles1');
        document.getElementById('highlight-band-fail1').addEventListener('click', applyVisualizationCutScore11);
    }

    //show/hide borders to high and/or low scores
    function applyVisualizationCutScore11() {
        if (document.getElementById('highlight-band-fail1').checked) {
            document.body.appendChild(window.failStyles);
        }
        else {
            window.failStyles.remove();
        }
    }
</script>
