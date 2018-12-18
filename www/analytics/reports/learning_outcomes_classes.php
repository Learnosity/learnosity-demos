<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;

$addRowTagType = function($opts, $rowTagType) {
    $opts['reports'][0]['row_tag_type'] = $rowTagType;
    return $opts;
};

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$classReport = [
    "configuration" => [
        "questionsApiVersion" => "v2"
    ],
    "label_bundle" => [
        "total" => "Overall result"
    ],
    "reports" => [
        [
            "id" => "class-skills-report",
            "type" => "item-scores-by-tag-by-user",
            "items_tags_live_dataset_reference" => "content-hierarchy-items-dataset-00001",
            "session_items_live_dataset_reference" => "content-hierarchy-sessions-dataset-00001",
            "users" => [
                [
                    "id" => "user_20181002a_00001",
                    "name" => "Bart Simpson"
                ],
                [
                    "id" => "user_20181002a_00002",
                    "name" => "Milhouse Vanhouten"
                ],
                [
                    "id" => "user_20181002a_00003",
                    "name" => "Sherri Mackleberry"
                ],
                [
                    "id" => "user_20181002a_00004",
                    "name" => "Nelson Muntz"
                ],
                [
                    "id" => "user_20181002a_00005",
                    "name" => "Terri Mackleberry"
                ]
            ],
            "column_tag_types" => [
                "sh_skill",
                "sh_dok"
            ],
            // "row_tag_type" => "sh_subskill", // populated by addRowTagType();
            "item_tags" => [
                [
                    "type" => "ch_title",
                    "name" => "skill_hierarchy_001"
                ],
                [
                    "type" => "sh_exercise",
                    "name" => "Chapter 3"
                ]
            ]
        ]
    ]
];

// Collapsed class report uses the base $classReport options. Expanded uses the sh_subskill
// as the row_tag_type.
$classReports = [
    'collapsed' => $classReport,
    'expanded'  => $addRowTagType($classReport, 'sh_subskill')
];


// Now cycle through all the variants of the reports and sign them.
// We'll pass signed options for all variants to the browser, and decide at
// render time which ones should be used based on the UI controls.
$signedClassReports = [];
foreach($classReports as $idx => $opts) {
    $signer = new Init('reports', $security, $consumer_secret, $opts);

    // We'll json_encode() each signed array once afterwards, so here we have to json_decode() the signed
    // string to avoid double encoding.
    $signedClassReports[$idx] = json_decode($signer->generate(), JSON_PRETTY_PRINT);
}

// These are just the init options we display if you click the "Preview API Initialisation Object" button.
$signedRequest = json_encode($signedClassReports['collapsed']);

?>

<style id="base-styles">
    .report-container {
        margin: auto;
        height: 600px;
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
        <h1>Reports API – Learning outcomes for classes</h1>
        <p>This demo shows different ways to analyse learning outcome results for a class of students. It uses the <code>item-scores-by-tag-by-user</code> report, which is a flexible, powerful report for understanding the results of individuals and classes.<p>
        <p><b>Please note:</b> the <code>item-scores-by-tag-by-user</code> report is premium bundle add-on. Contact your support representative to start using this feature.<p>
    </div>
</div>

<div class="section pad-sml">
    <p>
        Click on a skill area to drill down into depth of knowledge.
    </p>
    <p>
        Optionally, you can also show a detailed breakdown per student - tick the box to show subskills, for example. The breakdown can also be based on any other Item tag you desire.
    </p>
    <label for="show-class-skills"><input type="checkbox" id="show-class-skills" name="show-class-skills">  Show breakdown of subskills per student.</input></label>

    <div id="class-skills-report-container" class="report-container">
        <div id="class-skills-report"></div>
    </div>
</div>


<script src="<?php echo $url_reports; ?>"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    window.reportsApp = null;

    initClassReport();
    initCustomControls();

    function initClassReport() {
        var classReportOptions = <?php echo json_encode($signedClassReports, JSON_PRETTY_PRINT); ?>;

        var initOptions = showClassExpanded()? classReportOptions.expanded : classReportOptions.collapsed;
        var eventOpts = {};

        // Reset existing report, if there is one.
        if (window.reportsApp) {
            document.getElementById('class-skills-report-container').innerHTML = '<div id="class-skills-report"></div>';
        }

        // Initialize the report.
        window.reportsApp = LearnosityReports.init(initOptions, eventOpts);
    }

    function initCustomControls() {
        document.getElementById('show-class-skills').addEventListener('click', initClassReport)
    }

    function showClassExpanded() {
        return document.getElementById('show-class-skills').checked;
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
