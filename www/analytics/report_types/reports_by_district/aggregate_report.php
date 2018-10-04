<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

//simple api request object for Reports API
$request = [
    'reports' => [
        [
            'id'          => 'report',
            'type'        => 'activity-summary-by-group',
            'dataset_id'  => 'a1a8e23e-7fce-4146-b079-9b607697df23',
            "group_path" => [],
            "columns" =>  [
                [
                    "type" => "group_name",
                ],
                [
                    "type" => "numeric",
                    "field" => "population",
                    "label" => "Students"
                ],
                [
                    "type" => "numeric",
                    "field" => "lowest_percent",
                    "label" => "Lowest score %"
                ],
                [
                    "type" => "numeric",
                    "field" => "highest_percent",
                    "label" => "Highest score %"
                ],
                [
                    "type" => "numeric",
                    "field" => "mean_percent",
                    "label" => "Average score %"
                ],
                [
                    "type" => "numeric",
                    "field" => "median_percent",
                    "label" => "Median score %"
                ],
                [
                    "type" => "numeric",
                    "field" => "p75_percent",
                    "label" => "75th percentile"
                ]
            ]
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
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
            <h2>Aggregate Report</h2>
            <p>Calculate the average score, median, minumum/maximum, standard deviation, percentiles and other statistics for custom groupings of users. Summarise, drill down, explore and compare results across regions, schools, classes, departments, age group, and any other arbitrary cohort.</p>
            <p>Two variants are available depending on how data should be selected:
                <ul>
                    <li>Activity Summary by Group: compare results for users attempting one or more common learning activities</li>
                    <li>Sessions Summary by Group: compare results for users across a specific set of assessment sessions</li>
                </ul>
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Aggregate Report</h4>
        <div id="report"></div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
