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
            'id' => 'sessions-summary',
            'type' => 'sessions-summary',
            'user_id' => 'demo_student',
            'session_ids' => [
                '8524a7f7-169f-4b0b-b2ef-23df7c3ad51f'
            ]
        ],
        [
            'id' => 'sessions-summary-tag',
            'type' => 'sessions-summary-by-tag',
            'user_id' => 'demo_student',
            'hierarchy_reference' => 'author',
            'session_ids' => [
                '8524a7f7-169f-4b0b-b2ef-23df7c3ad51f'
            ]
        ],
        [
            'id' => 'sessions-list',
            'type' => 'sessions-list',
            'limit' => 5,
            'ui' => 'table',
            'activities' => [
                ['id' => 'Weekly_Math_Quiz', 'name' => 'Weekly Math Quiz']
            ]
        ],
        [
            'id' => 'sessions-list-item',
            'type' => 'sessions-list-by-item',
            'limit' => 5,
            'activity_id'  => 'MCE_5.MD.5b',
            'display_user' => false,
            'users' => [
                ['id' => 'mce_student', 'name' => 'Brian Moser']
            ]
        ],
        [
            'id' => 'lastscore-activity',
            'type' => 'lastscore-by-activity',
            'scoring_type' => 'partial',
            'user_id' => 'mce_student',
            'display_time_spent' => true,
            'activities' => [
                ['id' => 'Weekly_Math_Quiz', 'name' => 'Weekly Math Quiz'],
                ['id' => 'Summer_Test_1', 'name' => 'Summer Test']
            ]
        ],
        [
            'id' => 'session-detail',
            'type' => 'session-detail-by-item',
            'user_id' => 'brianmoser',
            'session_id' => '8151DD9E-9029-4D13-AC773EC9C05E7FF2'
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
            <h2>Student-Centric Reporting</h2>
            <p>Learn more about individual students in an easy, in-depth fashion! Our Reports API provides embededdable, student focused reports to provide a student with additional information and feedback, or provide a teacher with a drilled down view of their student progress.
            <ul>
                <li><h4><a href="#sessions-summary-report">Sessions Summary</a></h4></li>
                <li><h4><a href="#sessions-summary-tag-report">Sessions Summary - with Tag breakdown</a></h4></li>
                <li><h4><a href="#sessions-list-report">List of Student Sessions and Scores</a></h4></li>
                <li><h4><a href="#sessions-list-item-report">List of Student Sessions - broken down by item scores</a></h4></li>
                <li><h4><a href="#lastscore-activity-report">Most recent score per Activity</a></h4></li>
                <li><h4><a href="#session-detail-report">Session Detail Review</a></h4></li>

            </ul>
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="sessions-summary-report"><a href="#sessions-summary-report">Sessions Summary</a></h3>
        <p>See a running total of correct, incorrect and skipped items for an individual session or a combination of sessions.</p>
        <div id="sessions-summary"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="sessions-summary-tag-report"><a href="#sessions-summary-tag-report">Sessions Summary - with Tag breakdown</a></h3>
        <p>See a more detailed breakdown of the score of an individual or combination of sessions, broken down based on a tag hierarchy.</p>
        <div id="sessions-summary-tag"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="sessions-list-report"><a href="#sessions-list-report">List of Student Sessions and Scores</a></h3>
        <p>View multiple attempts at the same activity, or multiple different activities, for a single student.</p>
        <div id="sessions-list"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="sessions-list-item-report"><a href="#sessions-list-item-report">List of Student Sessions - broken down by item scores</a></h3>
        <p>Dive deeper and analyze exactly how a student did at a per-item level for a number of sessions.</p>
        <div id="sessions-list-item"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="lastscore-activity-report"><a href="#lastscore-activity-report">Most recent score per Activity</a></h3>
        <p>See a student score for their most recent attempt at one or multiple activities.</p>
        <div id="lastscore-activity"></div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h3 id="session-detail-report"><a href="#session-detail-report">Session Detail Review</a></h3>

        <p>Drill down into the student answer, score and correct answer for a session.</p>
        <div id="session-detail"></div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
