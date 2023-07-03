<?php
$lastScoreBABUReportConfig = [
    'id' => 'lastscore-activity-by-user',
    'type' => 'lastscore-by-activity-by-user',
    'scoring_type' => 'partial',
    'user_id' => 'mce_student',
    'display_time_spent' => true,
    'activities' => [
        ['id' => 'Weekly_Math_Quiz', 'name' => 'Weekly Math Quiz'],
        ['id' => 'Summer_Test_1', 'name' => 'Summer Test']
    ],
    'users' => [
        ['id' => 'mce_student', 'name' => 'Jesse Pinkman'],
        ['id' => 'mce_student_1', 'name' => 'Walter White'],
        ['id' => 'mce_student_2', 'name' => 'Saul Goodman']
    ]
];
?>
<style>
    .lsbabu-button {
        height: 36px;
        font-family: 'Gilroy';
        font-style: normal;
        font-weight: 700;
        font-size: 17px;
        line-height: 100%;
        text-align: center;
        border-radius: 5px;
        border: 1px solid #0071CE ;
        padding: 8px;
        margin-right: 16px;
        margin-bottom: 16px;
        color: #0071CE;
        background-color: #FFFFFF;
    }

    .lsbabu-button:hover {
        background: #E6F2FC;
    }

    .lsbabu-button:focus {
        outline: 2px solid #0071CE;
        outline-offset: 2px;
    }

    .lsbabu-button-selected {
        color: #FFFFFF;
        background-color: #0071CE;
    }
    .lsbabu-button-selected:hover {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), #0071CE;
    }
    .lsbabu-button-selected:active {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), #0071CE;
    }
    .lsbabu-button-selected:focus {
        outline: 2px solid #0071CE;
        outline-offset: 2px;
    }
</style>

<!-- Container for the reports api to load into -->
<h3 id="lastscore-activity-by-user-report"><a href="#lastscore-activity-by-user-report">Last Score by Activity by User Report</a></h3>
<p>This report provides an easy to use, at-a-glance view for multiple students, across multiple tests. To improve the teacher's ability to quickly see insights across their class, you can choose the cut-score feature which allows you to set score levels to highlight.</p>

<button class="lsbabu-button lsbabu-button-selected" id="lsbabu-default">Default</button>
<button class="lsbabu-button" id="lsbabu-cutscore1">Cut-score 1</button>
<button class="lsbabu-button" id="lsbabu-cutscore2">Cut-score 2</button>

<?php require 'last-score-by-activity-by-user-default.php' ?>
<?php require 'last-score-by-activity-by-user-cut-score1.php' ?>
<?php require 'last-score-by-activity-by-user-cut-score2.php' ?>
<script>
const lastScoreByActivityByUserButtons = [
    {"lsbabu-default": "lsbabu-report-default"},
    {"lsbabu-cutscore1": "lsbabu-report-cutscore1"},
    {"lsbabu-cutscore2": "lsbabu-report-cutscore2"},
];

function hideAllLastScoreByActivityByUserReport() {
    document.querySelectorAll('.lsbabu-report').forEach((report) => {
        report.style.display = "none";
    });
}

function unselectAllButtonsForLastScoreByActivity() {
    document.querySelectorAll('.lsbabu-button').forEach((button) => {
        if (button.classList.contains('lsbabu-button-selected')) {
            button.classList.remove('lsbabu-button-selected');
        }
    });
}

lastScoreByActivityByUserButtons.forEach((button) => {
    const buttonId = Object.keys(button)[0];
    const reportId = button[buttonId];
    document.getElementById(buttonId).addEventListener('click', function (e) {
        hideAllLastScoreByActivityByUserReport();
        document.getElementById(reportId).style.display = 'block';
        unselectAllButtonsForLastScoreByActivity ();
        e.target.classList.add('lsbabu-button-selected');
    });
});
</script>
