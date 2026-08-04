<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

//simple api request object for Reports API
$request = [
    'reports' => [
        [
            'id' => 'sessions-summary-by-group-report',
            'type' => 'sessions-summary-by-group',
            'dataset_id' => '33285a4b-0e6e-47e4-bade-78999ada14db',
            'group_path' => [],
            'always_show_group_ancestors' => true
        ],
        [
            'id' => 'activity-summary-by-group-report',
            'type' => 'activity-summary-by-group',
            'dataset_id' => '33285a4b-0e6e-47e4-bade-78999ada14db',
            "group_path" => [],
            "always_show_group_ancestors" => true,
            "columns" => [
                [
                    "type" => "group_name",
                    "label" => "District"
                ],
                [
                    "type" => "numeric",
                    "field" => "population",
                    "label" => "# of Students"
                ],
                [
                    "type" => "1d_plot",
                    "label" => "Results",
                    "elements" => [
                        [
                            "type" => "shading_plot",
                            "source" => "ancestor_1",
                            "min" => "p25_percent",
                            "max" => "p75_percent"
                        ],
                        [
                            "type" => "line_plot",
                            "source" => "row",
                            "score" => 50,
                            "label" => false
                        ],
                        [
                            "type" => "whisker_plot",
                            "source" => "row",
                            "min" => "lowest_percent",
                            "max" => "highest_percent",
                            "labels" => true
                        ],
                        [
                            "type" => "box_plot",
                            "source" => "row",
                            "min" => "p25_percent",
                            "middle" => "median_percent",
                            "max" => "p75_percent",
                            "labels" => true
                        ]
                    ]
                ]
            ],
            "user_columns" => [
                [
                    "type" => "user_id"
                ],
                [
                    "type" => "numeric",
                    "field" => "score"
                ],
                [
                    "type" => "1d_plot",
                    "label" => "Results",
                    "elements" => [
                        [
                            "type" => "shading_plot",
                            "source" => "ancestor_1",
                            "min" => "p25_percent",
                            "max" => "p75_percent"
                        ],
                        [
                            "type" => "line_plot",
                            "source" => "row",
                            "score" => 50,
                            "label" => false
                        ],
                        [
                            "type" => "score_plot",
                            "shape" => "circle",
                            "source" => "row",
                            "percent" => ["score", "max_score"]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#"
                                                                                                     data-bs-toggle="modal"
                                                                                                     data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span
                                class="bi bi-search"></span></a></li>
                <li class="list-inline-item"><a
                            href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span
                                class="bi bi-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Large Group Report</h2>
            <p>With our large group reports, you can easily build complex, large-scale reports showing detailed
                breakdowns of hundreds of thousands of user scores, raw score data, or complex 1-dimensional
                plots to help administrators easily contrast and compare different parts of their student body.
            <ul>
                <li><h4><a href="#sessions-summary-by-group">Sessions Summary by Group Report</a></h4></li>
                <li><h4><a href="#activity-summary-by-group">Activity Summary by Group Report</a></h4></li>
            </ul>
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <h3 id="sessions-summary-by-group"><a href="#sessions-summary-by-group">Sessions Summary by Group Report</a></h3>
        <p>Summarize results for groups of users using specific session identifiers, with drill-down navigation from high-level group summaries to individual user data.</p>
        <div id="sessions-summary-by-group-report"></div>
    </div>

    <div class="section pad-sml">
        <h3 id="activity-summary-by-group"><a href="#activity-summary-by-group">Activity Summary by Group Report</a></h3>
        <div id="activity-summary-by-group-report"></div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var callbacks = {
            displayNameListener: function (originalNames) {
                var displayNameMap = {
                    "school_1": "Manhattan - Public School 723",
                    "school_2": "Bronx - Public School 122",
                    "school_3": "Queens - Public School 31",
                    "class_16": "Class 16 - Mr. Houston",
                    "class_24": "Class 24 - Ms. McKenzie",
                    "class_47": "Class 47 - Mr. White",
                    "class_48": "Class 48 - Mrs. Holloway",
                    "class_69": "Class 69 - Ms. Shupe",
                    "class_89": "Class 89 - Mr. Zawadzki",
                    "class_91": "Class 91 - Ms. Smith",
                    "class_92": "Class 92 - Mr. Williams",
                    "class_93": "Class 93 - Mr. Brown",
                    "class_112": "Class 112 -Mrs. Jones",
                    "class_113": "Class 113 - Ms. Wilson",
                    "class_133": "Class 133 - Mr. Johnson"
                };

                var displayNames = [];
                for (var i = 0; i < originalNames.length; i++) {
                    var originalName = originalNames[i];
                    if (originalName in displayNameMap) {
                        // The mapped value is what will be displayed instead of the corresponding original name
                        displayNames.push(displayNameMap[originalName]);
                    } else {
                        displayNames.push(originalName);
                    }
                }

                return displayNames;
            }
        };

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, callbacks);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
