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
            'id' => 'report',
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
            <h2>Last Score by Tag by User Report</h2>
            <p>Obtain the latest activity score with a break-down of scores according its constituent tags. Hover over the tag scores to see the fine grain score break-down. Names and scores can trigger onClick events to tie into other reports.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Last Score by Tag by User</h4>
        <div id="report">
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
