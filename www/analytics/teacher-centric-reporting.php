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
            'id' => 'lastscore-tag',
            'type' => 'lastscore-by-tag-by-user',
            "display_time_spent" => true,
            "hierarchy" => 'DepthofKnowledge',
            "activity_id" => 'Weekly_Math_Quiz',
            'users' => [
                ['id' => 'mce_student', 'name' => 'Jesse Pinkman'],
                ['id' => 'mce_student_1', 'name' => 'Skylar White'],
                ['id' => 'mce_student_2', 'name' => 'Walter White'],
                ['id' => 'mce_student_3', 'name' => 'Saul Goodman']
            ]
        ],
        [
            "id" => "response-analysis",
            "type" => "response-analysis-by-item",
            "session_ids" => [
                "c8df0f45-2bfd-4d6c-9de1-20200224c001",
                "c8df0f45-2bfd-4d6c-9de1-20200224c002",
                "c8df0f45-2bfd-4d6c-9de1-20200224c003",
                "c8df0f45-2bfd-4d6c-9de1-20200224c004",
                "c8df0f45-2bfd-4d6c-9de1-20200224c005",
                "c8df0f45-2bfd-4d6c-9de1-20200224c006",
                "c8df0f45-2bfd-4d6c-9de1-20200224c007",
                "c8df0f45-2bfd-4d6c-9de1-20200224c008",
                "c8df0f45-2bfd-4d6c-9de1-20200224c009",
                "c8df0f45-2bfd-4d6c-9de1-20200224c010",
                "c8df0f45-2bfd-4d6c-9de1-20200224c011",
            ],
            "users" => [
                ["id" => "user_20200224a_00001", "name" => "Milhouse Vanhouten"],
                ["id" => "user_20200224c_00002", "name" => "Bart Simpson"],
                ["id" => "user_20200224c_00003", "name" => "Sherri Mackleberry"],
                ["id" => "user_20200224c_00004", "name" => "Nelson Muntz"],
                ["id" => "user_20200224c_00005", "name" => "Terri Mackleberry"],
                ["id" => "user_20200224c_00006", "name" => "Lewis Clark"],
                ["id" => "user_20200224c_00007", "name" => "Adrian Belew"],
                ["id" => "user_20200224c_00008", "name" => "Martin Prince"],
                ["id" => "user_20200224c_00009", "name" => "Wendell Borton"],
                ["id" => "user_20200224c_00010", "name" => "Nina Skalka"],
                ["id" => "user_20200224c_00011", "name" => "Sophie Jensen"],
            ],
            "item_reference_map" => [
                ["reference" => "20200224_responseAnalysis_i01", "name" => "Item 1" ],
                ["reference" => "20200224_responseAnalysis_i02", "name" => "Item 2" ],
                ["reference" => "20200224_responseAnalysis_i03", "name" => "Item 3" ],
                ["reference" => "20200224_responseAnalysis_i04", "name" => "Item 4" ],
                ["reference" => "20200224_responseAnalysis_i05", "name" => "Item 5" ],
                ["reference" => "20200224_responseAnalysis_i06", "name" => "Item 6" ],
                ["reference" => "20200224_responseAnalysis_i07", "name" => "Item 7" ],
                ["reference" => "20200224_responseAnalysis_i08", "name" => "Item 8" ],
                ["reference" => "20200224_responseAnalysis_i09", "name" => "Item 9" ],
                ["reference" => "20200224_responseAnalysis_i10", "name" => "Item 10"]
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
            <h2>Present Classroom and Teacher-Centric Reports</h2>
            <p>Easily learn more about your whole classroom at a glance. Our Reports API provides embeddable, group and classroom-focused reports to provide a teacher or instructor with information about their classroom ability and progress.</p>
            <ul>
                <li><h4><a href="#lastscore-tag-report">Last Score by Tag by User Report</a></h4></li>
                <li><h4><a href="#lastscore-list-item-report">Last Score by Item by User Report</a></h4></li>
                <li><h4><a href="#lastscore-activity-by-user-report">Last Score by Activity by User Report</a></h4></li>
                <li><h4><a href="#response-analysis-report">Response Analysis by Item Report</a></h4></li>
            </ul>
        </div>
    </div>


    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="lastscore-tag-report"><a href="#lastscore-tag-report">Last Score by Tag by User Report</a></h3>
        <p>See your class or group's scores, all broken down according to tag. This report allows you to easily identify strengths and weaknesses based on the skills or subject areas associated with the content in the activity.</p>
        <div id="lastscore-tag"></div>
    </div>

    <div class="section pad-sml">
        <?php require 'last-score-by-item-by-user/index.php'; ?>
    </div>

    <div class="section pad-sml">
    <?php require 'last-score-by-activity-by-user/index.php'; ?>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="response-analysis-report"><a href="#response-analysis-report">Response Analysis by Item Report</a></h3>
        <p>See a summary of class responses at a glance:</p>
        <ul>
            <li>Click on an Item header to drill into the detail view and see full responses.</li>
            <li>Within the detail view, click on student names to highlight groupings of students who responded the same way.</li>
        </ul>
        <div id="response-analysis"></div>
    </div>


    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
