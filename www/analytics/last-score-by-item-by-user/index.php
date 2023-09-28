<?php
$lastScoreBIBUReportConfig = [
    'id' => 'lastscore-by-item-by-user',
    'type' => 'lastscore-by-item-by-user',
    'scoring_type' => 'partial',
    "display_time_spent" => true,
    "display_item_numbers" => true,
    "activity_id" => 'Weekly_Math_Quiz',
    'users' => [
        ['id' => 'mce_student', 'name' => 'Jesse Pinkman'],
        ['id' => 'mce_student_1', 'name' => 'Skylar White'],
        ['id' => 'mce_student_2', 'name' => 'Walter White'],
        ['id' => 'mce_student_3', 'name' => 'Saul Goodman']
    ]
];
?>
<style>
    .lsbibu-button {
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

    .lsbibu-button:hover {
        background: #E6F2FC;
    }

    .lsbibu-button:focus {
        outline: 2px solid #0071CE;
        outline-offset: 2px;
    }

    .lsbibu-button-selected {
        color: #FFFFFF;
        background-color: #0071CE;
    }
    .lsbibu-button-selected:hover {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), #0071CE;
    }
    .lsbibu-button-selected:active {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), #0071CE;
    }
    .lsbibu-button-selected:focus {
        outline: 2px solid #0071CE;
        outline-offset: 2px;
    }
</style>

<!-- Container for the reports api to load into -->
<h3 id="lastscore-list-item-report"><a href="#lastscore-list-item-report">Last Score by Item by User Report</a></h3>
<p>Drill down and see exactly how each student did, per item. Helpful for identifying specific knowledge or understanding gaps in your group. The cut-score options allow the teachers to highlight the learners who have made the indicated grade, or fallen beneath the set scores.</p>

<button class="lsbibu-button lsbibu-button-selected" id="lsbibu-default">Default</button>
<button class="lsbibu-button" id="lsbibu-cutscore1">Cut-score 1</button>
<button class="lsbibu-button" id="lsbibu-cutscore2">Cut-score 2</button>

<?php require 'last-score-by-item-by-user-default.php' ?>
<?php require 'last-score-by-item-by-user-cut-score1.php' ?>
<?php require 'last-score-by-item-by-user-cut-score2.php' ?>

<script>
const buttons = [
    {"lsbibu-default": "lsbibu-report-default"},
    {"lsbibu-cutscore1": "lsbibu-report-cutscore1"},
    {"lsbibu-cutscore2": "lsbibu-report-cutscore2"},
];

function hideAllLastScoreByItemByUserReport() {
    document.querySelectorAll('.lsbibu-report').forEach((report) => {
        report.style.display = "none";
    });
}

function unselectAllButtons() {
    document.querySelectorAll('.lsbibu-button').forEach((button) => {
        if (button.classList.contains('lsbibu-button-selected')) {
            button.classList.remove('lsbibu-button-selected');
        }
    });
}

buttons.forEach((button) => {
    const buttonId = Object.keys(button)[0];
    const reportId = button[buttonId];
    document.getElementById(buttonId).addEventListener('click', function (e) {
        hideAllLastScoreByItemByUserReport();
        document.getElementById(reportId).style.display = 'block';
        unselectAllButtons();
        e.target.classList.add('lsbibu-button-selected');
    });
});
</script>
