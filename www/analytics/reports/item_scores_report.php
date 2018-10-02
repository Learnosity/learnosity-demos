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

// For individual reports, use the base config and add the row tag type for each variant.
$individualReports = [
    'sh_exercise'          => $addRowTagType($individualReport, 'sh_exercise'),
    'sh_subskill'          => $addRowTagType($individualReport, 'sh_subskill'),
    'sh_question_category' => $addRowTagType($individualReport, 'sh_question_category'),
    'sh_dok'               => $addRowTagType($individualReport, 'sh_dok')
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
                    "name" => "Activity 3"
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

$advancedReport = [
    "configuration" => [
        "questionsApiVersion" => "v2"
    ],
    "label_bundle" => [
        "total" => "Practical Math, 2nd Ed."
    ],
    "reports" => [
        [
            "id" => "item-scores-report",
            "type" => "item-scores-by-tag-by-user",
            "items_tags_live_dataset_reference" => "content-hierarchy-items-dataset-00001",
            "session_items_live_dataset_reference" => "content-hierarchy-sessions-dataset-00001",
            "users" => [
                [
                    "id" => "user_20180417a_00001",
                    "name" => "Milhouse Vanhouten"
                ],
                [
                    "id" => "user_20180417a_00002",
                    "name" => "Bart Simpson"
                ],
                [
                    "id" => "user_20180417a_00003",
                    "name" => "Sherri Mackleberry"
                ],
                [
                    "id" => "user_20180417a_00004",
                    "name" => "Nelson Muntz"
                ],
                [
                    "id" => "user_20180417a_00005",
                    "name" => "Terri Mackleberry"
                ],
                [
                    "id" => "user_20180417a_00006",
                    "name" => "Lewis Clark"
                ],
                [
                    "id" => "user_20180417a_00007",
                    "name" => "Adrian Belew"
                ],
                [
                    "id" => "user_20180417a_00008",
                    "name" => "Terri Mackleberry"
                ],
                [
                    "id" => "user_20180417a_00009",
                    "name" => "Martin Prince"
                ]
            ],
            "column_tag_types" => [
                "ch_topic",
                "ch_subtopic",
                "ch_curriculum_code"
            ],
            "item_tags" => [
                [
                    "type" => "ch_title",
                    "name" => "content_hierarchy_001"
                ]
            ]
        ]
    ]
];

// Collapsed advanced report uses the base $advancedReport options. Expanded uses the ch_proficiency_strand
// as the row_tag_type.
$advancedReports = [
    'collapsed' => $advancedReport,
    'expanded' => $addRowTagType($advancedReport, 'ch_proficiency_strand')
];


// Now cycle through all the variants of the reports and sign them.
// We'll json_encode() each signed array once, so we json_decode() the signed
// string to avoid double encoding.
// We'll pass signed options for all variants to the browser, and decide at
// render time which ones should be used based on the UI controls.

$signedIndividualReports = [];
$signedClassReports = [];
$signedAdvancedReports = [];

foreach($individualReports as $idx => $opts) {
    $signer = new Init('reports', $security, $consumer_secret, $opts);
    $signedIndividualReports[$idx] = json_decode($signer->generate(), JSON_PRETTY_PRINT);
}

foreach($classReports as $idx => $opts) {
    $signer = new Init('reports', $security, $consumer_secret, $opts);
    $signedClassReports[$idx] = json_decode($signer->generate(), JSON_PRETTY_PRINT);
}

foreach($advancedReports as $idx => $opts) {
    $signer = new Init('reports', $security, $consumer_secret, $opts);
    $signedAdvancedReports[$idx] = json_decode($signer->generate(), JSON_PRETTY_PRINT);
}



// These are the init options we show in the Preview panel.
$signedRequest = json_encode($signedAdvancedReports['collapsed']);

?>

<style id="base-styles">
    .controls-container {
        padding: 2em 0;
        border: none;
    }

    .controls-container td {
        border: inherit;
        padding: 0 0 10px 0;
    }

    .controls-container label {
        padding-right: 2em;
    }

    .report-container_md {
        margin: auto;
        height: 400px;
        width: 100%;
    }

    .report-container_lg {
        margin: auto;
        height: 600px;
        width: 100%;
    }

    .lrn-ibtbu-col .lrn-ibtbu-col-cell {
        padding: 0;
    }

    .lrn-ibtbu-col .lrn-ibtbu-col-cell .lrn-ibtbu-percentage {
        border: 3px solid transparent;
        border-radius: 4px;
        transition: border 0.6s;
        padding: 1px;
        overflow: hidden;
    }
</style>
<style id="band-4-styles">
    .lrn-ibtbu-col:not(.lrn-ibtbu-col_left):not(.lrn-ibtbu-col_expanded):not(.lrn-ibtbu-col_exploded):not(.lrn-ibtbu-col_inmotion):not(.lrn-ibtbu-col_explodeleft) .lrn-ibtbu-col-cell[data-custom_performance-band="4"] .lrn-ibtbu-percentage {
        /*74BF3C*/
        border-color: #65A00D;
    }
</style>
<style id="band-1-styles">
    .lrn-ibtbu-col:not(.lrn-ibtbu-col_left):not(.lrn-ibtbu-col_expanded):not(.lrn-ibtbu-col_exploded):not(.lrn-ibtbu-col_inmotion):not(.lrn-ibtbu-col_explodeleft) .lrn-ibtbu-col-cell[data-custom_performance-band="1"] .lrn-ibtbu-percentage {
        /*E00826*/
        border-color: #E14747;
    }
</style>
<style id="exposure-styles">
    .lrn-ibtbu-col .lrn-ibtbu-col-cell[data-custom_exposure="low"] .lrn-ibtbu-percentage {
        border-color: transparent !important;
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
        <h1>Reports API – Learning outcomes reporting</h1>
        <p>These demos show different ways to analyse results by learning outcome, standard, topic area and more. They use the <code>item-scores-by-tag-by-user</code> report, which is a flexible, powerful report for understanding the results of individuals and classes.<p>
        <p><b>Please note:</b> the <code>item-scores-by-tag-by-user</code> report is premium bundle add-on. Contact your support representative to start using this feature.<p>
    </div>
</div>

<div class="section pad-sml">
    <h4>Example 1: Individual results</h4>
    <p>
        Show detailed results for an individual. The score breakdown can be based on any of your Item Tags. For&nbsp;example:&nbsp;<select id="individual-report-breakdown">
            <option value="sh_exercise"         >Report by task</option>
            <option value="sh_subskill"         >Report by subskill</option>
            <option value="sh_question_category">Report by question type</option>
            <option value="sh_dok"              >Report by depth of knowledge</option>
        </select>
    </p>
    <div id="individual-skills-report-container" class="report-container_md">
        <div id="individual-skills-report"></div>
    </div>
</div>

<div class="section pad-sml">
    <h4>Example 2: Class results</h4>
    <p>
        Click on a skill area to drill down into depth of knowledge. Optionally, you can also show a detailed breakdown per student, based on any of your Item Tags.
    </p>
    <label for="show-class-skills"><input type="checkbox" id="show-class-skills" name="show-class-skills">  Show breakdown of subskills per student.</input></label>

    <div id="class-skills-report-container" class="report-container_md">
        <div id="class-skills-report"></div>
    </div>
</div>

<div class="section pad-sml">
    <h4>Example 3: Visualizing progress and results - advanced usage</h4>
    <p>This demo is based on chapters of a Math curriculum. We've implemented some custom highlighting and other options, as an example of some of the powerful customizations possible with this report.</p>
    <div class="controls-container">
        <table class="table-unbordered">
            <tbody>
                <tr>
                    <td style="min-width:240px"><label for="highlight-band-4"><input type="checkbox" id="highlight-band-4" name="highlight-band-4" checked> Highlight high scores</input></label></td>
                    <td>Custom styling for scores of 80% or more, to identify areas of strength.</td>
                </tr>
                <tr>
                    <td style="min-width:240px"><label for="highlight-band-1"><input type="checkbox" id="highlight-band-1" name="highlight-band-1"> Highlight low scores</input></label></td>
                    <td>Custom styling for scores of 60% or less, to identify problem areas.</td>
                </tr>
                <tr>
                    <td style="min-width:240px"><label for="exclude-low-exposure"><input type="checkbox" id="exclude-low-exposure" name="exclude-low-exposure"> Exclude low exposure</input></label></td>
                    <td>Disable highlighting for scores based on fewer than 20 questions.</td>
                </tr>
                <tr>
                    <td style="min-width:240px"><label for="ignore-unattempted"><input type="checkbox" id="ignore-unattempted" name="ignore-unattempted"> Ignore unattempted Items</input></label></td>
                    <td>Ignore unattempted Items from score calculations.</td>
                </tr>
                <tr>
                    <td style="min-width:240px"><label for="show-advanced-skills"><input type="checkbox" id="show-advanced-skills" name="show-advanced-skills"> Show skill breakdown</input></label></td>
                    <td>Show student results by skill area.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="item-scores-report-container" class="report-container_lg">
        <div id="item-scores-report"></div>
    </div>

    <!-- Demo Report OnClick Modal -->
    <div class="modal fade" id="lrn-reports-demos-modal" tabindex="-1" role="dialog" aria-labelledby="lrn-reports-demos-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    window.individualReportsApp = null;
    window.classReportsApp      = null;
    window.advancedReportsApp   = null;

    initIndividualReport();
    initClassReport();
    initAdvancedReport();

    initCustomControls();
    applyVisualization();

    function initIndividualReport() {
        var individualReportOptions = <?php echo json_encode($signedIndividualReports, JSON_PRETTY_PRINT); ?>;

        var initOptions = individualReportOptions[getSelectedIndividualReport()];
        var eventOpts = {};

        // Reset existing report, if there is one.
        if (window.individualReportsApp) {
            document.getElementById('individual-skills-report-container').innerHTML = '<div id="individual-skills-report"></div>';
        }

        // Initialize the report.
        window.individualReportsApp = LearnosityReports.init(initOptions, eventOpts);
    }

    function initClassReport() {
        var classReportOptions = <?php echo json_encode($signedClassReports, JSON_PRETTY_PRINT); ?>;

        var initOptions = showClassExpanded()? classReportOptions.expanded : classReportOptions.collapsed;
        var eventOpts = {};

        // Reset existing report, if there is one.
        if (window.classReportsApp) {
            document.getElementById('class-skills-report-container').innerHTML = '<div id="class-skills-report"></div>';
        }

        // Initialize the report.
        window.classReportsApp = LearnosityReports.init(initOptions, eventOpts);
    }

    function initAdvancedReport() {
        var advancedReportOptions = <?php echo json_encode($signedAdvancedReports, JSON_PRETTY_PRINT); ?>;

        var initOptions = showAdvancedExpanded()? advancedReportOptions.expanded : advancedReportOptions.collapsed;
        var eventOpts = {
            scoreMutator: function(scores) {
                processScores(scores, ignoreUnattempted());
            }
        };

        // Reset existing report, if there is one.
        if (window.advancedReportsApp) {
            document.getElementById('item-scores-report-container').innerHTML = '<div id="item-scores-report"></div>';
        }

        // Initialize the report.
        window.advancedReportsApp = LearnosityReports.init(initOptions, eventOpts);
    }

    function processScores(scores, ignoreUnattempted) {
        scores.forEach(function(score) {
            if (ignoreUnattempted) {
                score.unattempted(0);
            }

            var maxScore = score.correct() + score.incorrect() + score.unmarked() + score.unattempted();
            var performanceBand = 'none';
            var exposure = 'low';
            if (maxScore > 0) {
                var percent = Math.round(score.correct() / maxScore * 100);
                if      (percent >= 80) { performanceBand = '4';}
                else if (percent >= 70) { performanceBand = '3';}
                else if (percent >= 60) { performanceBand = '2';}
                else if (percent >=  0) { performanceBand = '1';}

                if (maxScore >= 20) {
                    exposure = '20+'
                }

            }
            score.domData({
                'performance-band': performanceBand,
                'exposure': exposure
            });
        });
    }

    function initCustomControls() {
        window.highscoreStyles = document.getElementById('band-4-styles');
        window.lowscoreStyles = document.getElementById('band-1-styles');
        window.exposureStyles = document.getElementById('exposure-styles');

        // Individual report handlers
        document.getElementById('individual-report-breakdown').addEventListener('change', initIndividualReport);

        // Class report handlers
        document.getElementById('show-class-skills').addEventListener('click', initClassReport);

        // Advanced report handlers
        document.getElementById('highlight-band-1').addEventListener('click', applyVisualization);
        document.getElementById('highlight-band-4').addEventListener('click', applyVisualization);
        document.getElementById('exclude-low-exposure').addEventListener('click', applyVisualization);
        document.getElementById('ignore-unattempted').addEventListener('click', initAdvancedReport);
        document.getElementById('show-advanced-skills').addEventListener('click', initAdvancedReport);
    }

    function applyVisualization() {
        if (document.getElementById('highlight-band-4').checked) {
            document.body.appendChild(window.highscoreStyles);
        }
        else {
            window.highscoreStyles.remove();
        }

        if (document.getElementById('highlight-band-1').checked) {
            document.body.appendChild(window.lowscoreStyles);
        }
        else {
            window.lowscoreStyles.remove();
        }

        if (document.getElementById('exclude-low-exposure').checked) {
            document.body.appendChild(window.exposureStyles);
        }
        else {
            window.exposureStyles.remove();
        }
    }

    function ignoreUnattempted() {
        return document.getElementById('ignore-unattempted').checked;
    }

    function getSelectedIndividualReport() {
        return document.getElementById('individual-report-breakdown').value;
    }

    function showClassExpanded() {
        return document.getElementById('show-class-skills').checked;
    }

    function showAdvancedExpanded() {
        return document.getElementById('show-advanced-skills').checked;
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
