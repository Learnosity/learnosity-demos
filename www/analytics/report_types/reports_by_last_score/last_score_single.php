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
            'id' => 'lastscore_1',
            'type' => 'lastscore-single',
            'ui' => 'bar',
            'user_id' => 'mce_student',
            'activity_id' => 'Weekly_Math_Quiz'
        ],
        [
            'id' => 'lastscore_2',
            'type' => 'lastscore-single',
            'ui' => 'bar',
            'user_id' => 'mce_student_1',
            'activity_id' => 'Weekly_Math_Quiz'
        ],
        [
            'id' => 'lastscore_3',
            'type' => 'lastscore-single',
            'ui' => 'bar',
            'user_id' => 'mce_student_2',
            'activity_id' => 'Weekly_Math_Quiz'
        ],
        [
            'id' => 'lastscore_4',
            'type' => 'lastscore-single',
            'ui' => 'pie',
            'user_id' => 'mce_student',
            'activity_id' => 'Weekly_Math_Quiz'
        ],
        [
            'id' => 'lastscore_5',
            'type' => 'lastscore-single',
            'ui' => 'pie',
            'user_id' => 'mce_student_1',
            'activity_id' => 'Weekly_Math_Quiz'
        ],
        [
            'id' => 'lastscore_6',
            'type' => 'lastscore-single',
            'ui' => 'pie',
            'user_id' => 'mce_student_2',
            'activity_id' => 'Weekly_Math_Quiz'
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
            <h2>Last Score Single Report</h2>
            <p>Single reports are designed to be embedded within content pages. Obtain the latest activity score in a single bar or chart format (each bar/chart below is a separate report). Score progress bars and charts can trigger onClick events to tie into other reports.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Last Score Single</h4>
        <div class="row">
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_1"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_2"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_3"></span></div>
        </div>
        <div class="row">
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_4"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_5"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="lastscore_6"></span></div>
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
