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
            'id' => 'progress_1',
            'type' => 'progress-single',
            'ui' => 'bar',
            'user_id' => 'mce_student',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
                ]
            ]
        ],
        [
            'id' => 'progress_2',
            'type' => 'progress-single',
            'ui' => 'bar',
            'user_id' => 'mce_student_1',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
                ]
            ]
        ],
        [
            'id' => 'progress_3',
            'type' => 'progress-single',
            'ui' => 'bar',
            'user_id' => 'mce_student_2',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
                ]
            ]
        ],
        [
            'id' => 'progress_4',
            'type' => 'progress-single',
            'ui' => 'pie',
            'user_id' => 'mce_student',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
                ]
            ]
        ],
        [
            'id' => 'progress_5',
            'type' => 'progress-single',
            'ui' => 'pie',
            'user_id' => 'mce_student_1',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
                ]
            ]
        ],
        [
            'id' => 'progress_6',
            'type' => 'progress-single',
            'ui' => 'pie',
            'user_id' => 'mce_student_2',
            'hierarchy_reference' => 'questiontype',
            'tag_hierarchy_path' => [
                [
                    'type' => 'questiontype',
                    'name' => 'clozeassociation'
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
            <h2>Progress Single Report</h2>
            <p>Single reports are designed to be embedded within content pages. Gather insight into user progress according to your assigned tag hierarchy (each bar/chart below is a separate report).</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Progress Single</h4>
        <div class="row">
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_1"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_2"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_3"></span></div>
        </div>
        <div class="row">
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_4"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_5"></span></div>
            <div class="col-sm-4 lrn-reports-demo-wrapper"><span class="learnosity-report" id="progress_6"></span></div>
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
