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
            'id' => 'report',
            'type' => 'lastscore-by-activity-by-user',
            'scoring_type' => 'partial',
            'ui' => 'numeric',
            'user_id' => 'mce_student',
            'display_time_spent' => true,
            'activities' => [
                ['id' => 'Weekly_Math_Quiz', 'name' => 'Weekly Math Quiz'],
                ['id' => 'Summer_Test_1', 'name' => 'Summer Test']
            ],
            'users' => [
                ['id' => 'mce_student', 'name' => 'Jesse Pinkman'],
                ['id' => 'mce_student_1', 'name' => 'Walter White'],
                ['id' => 'mce_student_2', 'name' => 'Saul Goodman']
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Use Click Events to Display Additional Information and Reports</h2>
            <p>Click events are events that are provided by certain reports, to provide mechanisms to bind to specific click events within the report. For more information about click events, and to see which reports they can be used in, please see our <a href="https://reference.learnosity.com/reports-api/events#clickEvents" target="_blank">documentation</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Report: Last Score by Activity by User</h4>
        <div id="report"></div>
    </div>

    <!-- Demo Report OnClick Modal -->
    <div class="modal fade" id="lrn-reports-demos-modal" tabindex="-1" role="dialog" aria-labelledby="lrn-reports-demos-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>

        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                onReportsReady();
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var reportsApp = LearnosityReports.init(initializationObject, callbacks);

        function onReportsReady() {
            // load modal from a remote location that initialize an instance of the reports api
            var onClickFunction = function(data) {
                $('#lrn-reports-demos-modal').modal({
                    'remote': 'reports-click-events-modal.php'
                    + '?session_id=' + data.session_id
                    + '&user_id=' + data.user_id
                    + '&activity_id=' + data.activity_id
                });

                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                    $('.modal-content').html("");
                });
            };

            var groupLastScoreByActivityByUser = reportsApp.getReport('report');

            // onclick events
            groupLastScoreByActivityByUser.on('click:score', function (data) {
                onClickFunction(data);
            });
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
