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
    'domain'       => $domain
];

//simple api request object for Reports API
$request = [
    'reports' => [
        [
            'id'        => 'progress-by-tag',
            'type'      => 'progress-by-tag',
            'user_id'   => 'mce_student_1',
            'hierarchy_reference' => 'CCSS'
        ],
        [
            "id"        => "progress-by-tag-by-user",
            "type"      => "progress-by-tag-by-user",
            "users"     => [
                ["id" => "mce_student_1","name" => "Brian Moser"],
                ["id" => "mce_student_2","name" => "John Carter"]
            ],
            "hierarchy_reference" => "CCSS"
        ],
        [
            'id'          => 'progress-single',
            'type'        => 'progress-single',
            'ui'          => 'pie',
            'user_id'     => 'demo_student',
            'hierarchy_reference'   => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type'  => 'questiontype',
                    'name'  => 'mcq'
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Coursework Progress Reporting</h2>
            <p>Track the progress of a student, or group of students, against learning objectives, standards, or other tag-based alignments. Or build your own dashboard with our Progress Single report.</p>
            <ul>
                <li><h4><a href="#progress-by-tag-report">Progress by Tag Report</a></h4></li>
                <li><h4><a href="#progress-by-tag-by-user-report">Progress by Tag by User Report</a></h4></li>
                <li><h4><a href="#progress-single-report">Progress Single Report</a></h4></li>
            </ul>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="progress-by-tag-report"><a href="#progress-by-tag-report">Progress by Tag Report</a></h3>
        <p>See at a glance how a student performed against two levels of tagging. Note overall performance in Expressions and Equations, for example, but also drill down to see progress in individual Common Core standards.</p>
        <div id="progress-by-tag"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="progress-by-tag-by-user-report"><a href="#progress-by-tag-by-user-report">Progress by Tag by User Report</a></h3>
        <p>Look at overall progress across multiple tags, but for multiple students in a single report.</p>
        <div id="progress-by-tag-by-user"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="progress-single-report"><a href="#progress-single-report">Progress Single Report</a></h3>
        <p>Use the Progress Single Report when you want to build your own analytics views or dashboards out of several different progress metrics,</p>
        <div style="width:100px;"><div id="progress-single"></div></div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
