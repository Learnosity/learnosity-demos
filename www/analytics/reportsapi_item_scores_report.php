<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$render = true;
if (isset($_GET['render']) && $_GET['render'] === 'false') {
    $render = false;
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

//simple api request object for Reports API
$request = [
    'reports' => [
        [
            "id" => "report-1",
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
                    "name" => "Lisa Simpson"
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

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Reports API – Item scores by tag by user</h2>
            <p>Real time score reporting by learning outcome or content area.<p>
            <p>This demo includes some simple highlighting to help visualize the results, but this just one example of the powerful customizations possible with this report.</p>
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
                </tbody>
            </table>
        </div>
        <div class="report-container">
            <div id="report-1"></div>
        </div>
    </div>

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

    <script src="<?php echo $url_reports; ?>"></script>

    <script>
        var initOptions = <?php echo $signedRequest; ?>;
        var eventOpts = {
                scoreMutator: function(scores) {
                    processScores(scores);
                }
            };
        var lrnReports = LearnosityReports.init(initOptions, eventOpts);
        initVisualization();

        function processScores(scores) {
            scores.forEach(function(score) {
                var maxScore = score.correct() + score.incorrect() + score.unattempted() + score.unmarked();
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

        function initVisualization() {
            window.highscoreStyles = document.getElementById('band-4-styles');
            window.lowscoreStyles = document.getElementById('band-1-styles');
            window.exposureStyles = document.getElementById('exposure-styles');

            document.getElementById('highlight-band-1').addEventListener('click', applyStyles);
            document.getElementById('highlight-band-4').addEventListener('click', applyStyles);
            document.getElementById('exclude-low-exposure').addEventListener('click', applyStyles);

            applyStyles();
        }

        function applyStyles() {
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
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
