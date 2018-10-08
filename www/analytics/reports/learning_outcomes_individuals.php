<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$addRowTagType = function($opts, $rowTagType) {
    $opts['reports'][0]['row_tag_type'] = $rowTagType;
    return $opts;
};

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$individualReport = [
    "configuration" => [
        "questionsApiVersion" => "v2"
    ],
    "label_bundle" => [
        "total" => "Overall result"
    ],
    "reports" => [
        [
            "id" => "individual-skills-report",
            "type" => "item-scores-by-tag-by-user",
            "items_tags_live_dataset_reference" => "content-hierarchy-items-dataset-00001",
            "session_items_live_dataset_reference" => "content-hierarchy-sessions-dataset-00001",
            "users" => [
                [
                    "id" => "user_20181002a_00001",
                    "name" => "Bart Simpson"
                ]
            ],
            "column_tag_types" => [
                "sh_skill"
            ],
            // "row_tag_type" => "sh_exercise", // populated by addRowTagType();
            "item_tags" => [
                [
                    "type" => "ch_title",
                    "name" => "skill_hierarchy_001"
                ]
            ]
        ]
    ]
];

// The individual reports all use the base config, and just add a different row tag type for each variant.
$individualReports = [
    'sh_exercise'          => $addRowTagType($individualReport, 'sh_exercise'),
    'sh_subskill'          => $addRowTagType($individualReport, 'sh_subskill'),
    'sh_question_category' => $addRowTagType($individualReport, 'sh_question_category'),
    'sh_dok'               => $addRowTagType($individualReport, 'sh_dok')
];

// Now cycle through all the variants of the report and sign them.
// We'll pass signed options for all variants to the browser, and decide at
// render time which ones should be used based on the UI controls.
$signedIndividualReports = [];
foreach($individualReports as $idx => $opts) {
    $signer = new Init('reports', $security, $consumer_secret, $opts);

    // We'll json_encode() each signed array once afterwards, so here we have to json_decode() the signed
    // string to avoid double encoding.
    $signedIndividualReports[$idx] = json_decode($signer->generate(), JSON_PRETTY_PRINT);
}

// These are just the init options we display if you click the "Preview API Initialisation Object" button.
$signedRequest = json_encode($signedIndividualReports['sh_exercise']);

?>

<style id="base-styles">
    .report-container {
        margin: auto;
        height: 400px;
        width: 100%;
    }
</style>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/analytics/reports/reporttypes#itemScoresByTagByUser" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Reports API – Learning outcomes for individuals</h1>
        <p>This demo shows different ways to report and analyse learning outcomes for an individual student. It uses the <code>item-scores-by-tag-by-user</code> report, which is a flexible, powerful report for understanding the results of individuals and classes.<p>
        <p><b>Please note:</b> the <code>item-scores-by-tag-by-user</code> report is premium bundle add-on. Contact your support representative to start using this feature.<p>
    </div>
</div>

<div class="section pad-sml">
    <p>
        Show detailed results for an individual. The score breakdown can be based on any of your Item Tags. For&nbsp;example:&nbsp;<select id="individual-report-breakdown">
            <option value="sh_exercise"         >Report by task</option>
            <option value="sh_subskill"         >Report by subskill</option>
            <option value="sh_question_category">Report by question type</option>
            <option value="sh_dok"              >Report by depth of knowledge</option>
        </select>
    </p>
    <div id="individual-skills-report-container" class="report-container">
        <div id="individual-skills-report"></div>
    </div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    window.reportsApp = null;

    initIndividualReport();
    initCustomControls();

    function initIndividualReport() {
        var individualReportOptions = <?php echo json_encode($signedIndividualReports, JSON_PRETTY_PRINT); ?>;

        var initOptions = individualReportOptions[getSelectedIndividualReport()];
        var eventOpts = {};

        // Reset existing report, if there is one.
        if (window.reportsApp) {
            document.getElementById('individual-skills-report-container').innerHTML = '<div id="individual-skills-report"></div>';
        }

        // Initialize the report.
        window.reportsApp = LearnosityReports.init(initOptions, eventOpts);
    }

    function initCustomControls() {
        document.getElementById('individual-report-breakdown').addEventListener('change', initIndividualReport);
    }

    function getSelectedIndividualReport() {
        return document.getElementById('individual-report-breakdown').value;
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
