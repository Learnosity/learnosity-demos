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
      
    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
    <script src="<?php echo $url_reports; ?>"></script>
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

    


    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
