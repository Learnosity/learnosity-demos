<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

// This demo temporarily uses a special consumer key
// linked to the Australia region. Soon it will be moved to
// use the standard yis consumer.
$consumer_key_au = "yau0TYCu7U9V4o7M";
$consumer_secret_au = "74c5fd430cf1242a527f6223aebd42d30464be22";
$url_reports_au = '//reports-au.learnosity.com?v1';

$security = [
    'consumer_key' => $consumer_key_au,
    'domain'       => $domain
];

$request = [
    'configuration' => [
        'questionsApiVersion' => 'v2'
    ],
    'reports' => [
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
            "row_tag_type" => "ch_proficiency_strand",
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
    ],
    "label_bundle" => [
        "total" => "Practical Math, 2nd Ed."
    ]
];

$Init = new Init('reports', $security, $consumer_secret_au, $request);
$signedRequest = $Init->generate();

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

    .report-container {
        height: 700px
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
        <h1>Reports API – Item scores by tag by user</h1>
        <p>Real time score reporting by learning outcome or content area.<p>
        <p>This demo includes some simple highlighting to help visualize the results, but this just one example of the powerful customizations possible with this report.</p
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the report to load into -->
    <div class="controls-container">
        <table class="table-unbordered">
            <tbody>
                <tr>
                    <td style="min-width:200px"><label for="highlight-band-4"><input type="checkbox" id="highlight-band-4" name="highlight-band-4" checked> Highlight high scores</input></label></td>
                    <td>Custom styling for scores of 80% or more, to identify areas of strength.</td>
                </tr>
                <tr>
                    <td style="min-width:200px"><label for="highlight-band-1"><input type="checkbox" id="highlight-band-1" name="highlight-band-1"> Highlight low scores</input></label></td>
                    <td>Custom styling for scores of 60% or less, to identify problem areas.</td>
                </tr>
                <tr>
                    <td style="min-width:200px"><label for="exclude-low-exposure"><input type="checkbox" id="exclude-low-exposure" name="exclude-low-exposure"> Exclude low exposure</input></label></td>
                    <td>Disable highlighting for scores based on fewer than 20 questions.</td>
                </tr>
                <tr>
                    <td style="min-width:200px"><label for="ignore-unattempted"><input type="checkbox" id="ignore-unattempted" name="ignore-unattempted"> Ignore unattempted Items</input></label></td>
                    <td>Ignore unattempted Items from score calculations.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="item-scores-report-container" class="report-container">
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

<script src="<?php echo $url_reports_au; ?>"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    window.reportsApp = null;
    initReport();
    initCustomControls();
    applyVisualization();

    function initReport() {
        var initOptions = <?php echo $signedRequest; ?>;
        var eventOpts = {
            scoreMutator: function(scores) {
                processScores(scores, ignoreUnattempted());
            }
        };

        // reset existing report, if there is one.
        if (window.reportsApp) {
            document.getElementById('item-scores-report-container').innerHTML = '<div id="item-scores-report"></div>';
        }

        // initialise the report.
        window.reportsApp = LearnosityReports.init(initOptions, eventOpts);
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

        document.getElementById('highlight-band-1').addEventListener('click', applyVisualization);
        document.getElementById('highlight-band-4').addEventListener('click', applyVisualization);
        document.getElementById('exclude-low-exposure').addEventListener('click', applyVisualization);
        document.getElementById('ignore-unattempted').addEventListener('click', initReport);
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
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
