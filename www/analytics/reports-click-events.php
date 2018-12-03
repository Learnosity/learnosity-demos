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
            <h2>Click Events</h2>
            <p>Click events are events that are provided by certain reports, to provide mechanisms to bind to specific click events within the report. For more information about click events, and to see which reports they can be used in, please see our <a href="https://docs.learnosity.com/analytics/reports/events#clickEvents" target="_blank">documentation</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Report</h4>
        <div id="report"></div>
        <div id="click-event-report"></div>
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

        var initOptions = <?php echo $signedRequest; ?>;

        var reportsApp = LearnosityReports.init(initOptions, {
                readyListener: onReportsReady
            }
        );



        function onReportsReady() {
            var onClickFunction = function(data, target) {
                $('#lrn-reports-demos-modal').modal({
                    'remote': 'demo-request.php'
                    + '?session_id=' + data.session_id
                    + '&user_id=' + data.user_id
                    + '&activity_id=' + data.activity_id
                    + '&report=sessions-summary'
                    + '&context=modal'
                });

                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                    $('.modal-content').html("");
                });
            };

            /* onclick events */
            var groupLastScoreByActivityByUser = reportsApp.getReport('report');

            groupLastScoreByActivityByUser.on('click:score', function (data) {
                onClickFunction(data, 'click-event-report');
            });


            function displayReport() {
                var report = window.location.hash.substring(1);
                if (report) {
                    var parts = report.split('-');
                    if (parts.length >= 3) {
                        if (parts[1] !== 'session') {
                            $('#accordion-' + parts[0] + '-' + parts[1]).click();
                        }
                        $('#' + report).click();
                        $(window).scrollTop($('#' + report).offset().top);
                    }
                }
                return false;
            }
            displayReport();
        }


    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
