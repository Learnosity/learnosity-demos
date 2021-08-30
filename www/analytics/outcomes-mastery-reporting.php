<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    "reports" => [
        [
            "id" => "individual-item-skills-report",
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
            "row_tag_type" => "sh_dok",
            "item_tags" => [
                [
                    "type" => "ch_title",
                    "name" => "skill_hierarchy_001"
                ]
            ]
        ],
        [
            "id" => "class-item-scores-report",
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
                    "name" => "Ralph Wiggum"
                ],
                [
                    "id" => "user_20180417a_00009",
                    "name" => "Martin Prince"
                ]
            ],
            //add drill-down for each student
            //  example used is proficiency data from this demo dataset
            //"row_tag_type" => 'ch_proficiency_strand',
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

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();



?>
    <!--styles for both reports-->
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

    <!--visualization borders for class report-->
    <style id="band-4-styles">
        #class-item-scores-report-container .lrn-ibtbu-col:not(.lrn-ibtbu-col_left):not(.lrn-ibtbu-col_expanded):not(.lrn-ibtbu-col_exploded):not(.lrn-ibtbu-col_inmotion):not(.lrn-ibtbu-col_explodeleft) .lrn-ibtbu-col-cell[data-custom_performance-band="4"] .lrn-ibtbu-percentage {
            border-color: #65A00D;
        }
    </style>
    <style id="band-1-styles">
        #class-item-scores-report-container .lrn-ibtbu-col:not(.lrn-ibtbu-col_left):not(.lrn-ibtbu-col_expanded):not(.lrn-ibtbu-col_exploded):not(.lrn-ibtbu-col_inmotion):not(.lrn-ibtbu-col_explodeleft) .lrn-ibtbu-col-cell[data-custom_performance-band="1"] .lrn-ibtbu-percentage {
            border-color: #E14747;
        }
    </style>


    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Analyze Learning Outcomes and Mastery</h2>
            <p>Drill down in individual and class-based reports to see percent success in learning outcomes and mastery. Optionally visualize data with score analysis and more.</p>
            <ul>
                <li><h4><a href="#item-scores-by-tag-by-user-report">Learning Outcomes - Individual</a></h4></li>
                <li><h4><a href="#item-scores-by-tag-by-user-class-report">Learning Outcomes - Class (with visualization)</a></h4></li>
            </ul>
        </div>
    </div>

    <!--individual report-->
    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="item-scores-by-tag-by-user-report"><a href="#item-scores-by-tag-by-user-report">Learning Outcomes - Individual</a></h3>
        <p>See your class or group's scores, all broken down according to tag. This report allows you to easily identify strengths and weaknesses based on the skills or subject areas associated with the content in the activity.</p>

        <div id="individual-item-skills-report-container" class="report-container">
            <!-- Container for the reports api to load into -->
            <div id="individual-item-skills-report"></div>
        </div>
    </div>

    <!--class report-->
    <div class="section pad-sml">
        <h3 id="item-scores-by-tag-by-user-class-report"><a href="#item-scores-by-tag-by-user-class-report">Learning Outcomes - Class (with visualization)</a></h3>
        <p>
            This demo is based on chapters of a Math curriculum. We've implemented some custom highlighting as an example of some of the powerful customizations possible with this report. You can also use your own custom logic to process and modify the percentages that are shown in every cell. This enables you to implement special weightings, exclusions or rounding in your report if required.
        </p>

        <!--visualization checkboxes-->
        <div class="controls-container">
            <table class="table-unbordered">
                <tbody>
                <tr>
                    <td style="min-width:240px">
                        <label for="highlight-band-4">
                            <input type="checkbox" id="highlight-band-4" name="highlight-band-4" checked> Highlight high scores</input>
                        </label>
                    </td>
                    <td>Custom styling for scores of 80% or more, to identify areas of strength.</td>
                </tr>
                <tr>
                    <td style="min-width:240px">
                        <label for="highlight-band-1">
                            <input type="checkbox" id="highlight-band-1" name="highlight-band-1"> Highlight low scores</input>
                        </label>
                    </td>
                    <td>Custom styling for scores of 60% or less, to identify problem areas.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div id="class-item-scores-report-container" class="report-container">
            <!-- Container for the reports api to load into -->
            <div id="class-item-scores-report"></div>
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>


    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready and/or error event(s)
        var callbacks = {
            readyListener: function () {
                console.log("Reports API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            },
            scoreMutator: function(scores) {
                processScores(scores);
            }
        };

        var reportsApp = LearnosityReports.init(initializationObject, callbacks);



        initCustomControls();
        applyVisualization();

        function processScores(scores) {
            scores.forEach(function(score) {

                var maxScore = score.correct() + score.incorrect() + score.unmarked() + score.unattempted();
                var performanceBand = 'none';

                if (maxScore > 0) {
                    var percent = Math.round(score.correct() / maxScore * 100);
                    if      (percent >= 80) { performanceBand = '4';}
                    else if (percent >= 70) { performanceBand = '3';}
                    else if (percent >= 60) { performanceBand = '2';}
                    else if (percent >=  0) { performanceBand = '1';}
                }
                score.domData({
                    'performance-band': performanceBand
                });
            });
        }


        //add button handler for visualization checkboxes
        function initCustomControls() {
            window.highscoreStyles = document.getElementById('band-4-styles');
            window.lowscoreStyles = document.getElementById('band-1-styles');

            document.getElementById('highlight-band-1').addEventListener('click', applyVisualization);
            document.getElementById('highlight-band-4').addEventListener('click', applyVisualization);
        }

        //show/hide borders to high and/or low scores
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
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
