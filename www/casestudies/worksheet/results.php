<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;


//Get Session ID from URL safely
$session_id = filter_input(INPUT_GET, 'session_id', FILTER_VALIDATE_REGEXP, array('options'=>array('default' => 'invalid', 'regexp'=>'/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/')));


if($session_id === "invalid"){
    echo "Invalid Session ID";
    exit;
}


$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'configuration' => array(
        'questionsApiVersion' => 'v2'
    ),
    'reports' => array(
        array(
            'id'          => 'report-1',
            'type'        => 'sessions-summary',
            'user_id'     => 'demo_student',
            'session_ids' => array(
                $session_id
            )
        ),
        array(
            'id'          => 'report-2',
            'type'        => 'sessions-summary-by-tag',
            'user_id'     => 'demo_student',
            'hierarchy'   => 'Worksheet Demo Area-Domain',
            'session_ids' => array(
                $session_id
            ),
        ),
        array(
            'id'          => 'report-3',
            'type'        => 'sessions-list',
            'limit'       => 15,
            'ui'          => 'table',
            'activities'  => array(
                array(
                    "id" => "itemsinlineworksheet",
                    "name" => "Worksheet Sample 1"
                    )
                )
        ),
        array(
            'id'           => 'report-4',
            'type'         => 'sessions-list-by-item',
            'limit'        => 15,
            'activity_id'  => 'itemsinlineworksheet',
            'display_user' => true,
            'users'        => array(
                array(
                    'id'   => 'demo_student',
                    'name' => 'Brian Moser'
                )
            )
        ),
        array(
            'id'         => 'report-detail',
            'type'       => 'session-detail',
            'user_id'    => 'demo_student',
            'session_id' => $session_id
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Reports API – Report Types</h1>
        <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
    </div>
</div>

<div class="section">
    <div id="lrn-reports-demos-sessions-content">
        <span class="learnosity-report" id="report-1"></span>

        <span class="learnosity-report" id="report-2"></span>
        <span class="learnosity-report" id="report-3"></span>
        <span class="learnosity-report" id="report-4"></span>

        <span class="learnosity-report" id="report-detail"></span>


    </div>

    <!-- Demo Report OnClick Modal -->
    <div class="modal fade" id="lrn-reports-demos-modal" tabindex="-1" role="dialog" aria-labelledby="lrn-reports-demos-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="lrn-reports-demos-modal-label">Demo Report</h4>
                </div>
                <div id="lrn-reports-demos-modal-content" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;

    var lrnReports = LearnosityReports.init(initOptions, {
            readyListener: onReportsReady
        }
    );

    function onReportsReady() {
        var onClickFunction = function(data, target, modal) {
            if (modal) {
                var sessionReports = ['sessions-summary', 'session-detail', 'sessions-summary-by-tag'];
                var reportType = sessionReports[Math.floor(Math.random() * sessionReports.length)];

                $('#lrn-reports-demos-modal').modal({
                    'remote': 'demo-request.php'
                    + '?session_id=' + data.session_id
                    + '&user_id=' + data.user_id
                    + '&activity_id=' + data.activity_id
                    + '&report=' + reportType
                });

                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                });
            } else {
                var html = '<div class="alert alert-info alert-dismissable">';
                    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>';
                    html += data.user_id ? '<p><strong>User ID:</strong> ' + data.user_id + '</p>' : '';
                    html += data.activity_id ? '<p><strong>Activity ID:</strong> ' + data.activity_id + '</p>' : '';
                    html += data.session_id ? '<p><strong>Session ID:</strong> ' + data.session_id + '</p>' : '';
                    html += '</p></div>';
                    $('#' + target).append(html);
            }
        };




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
