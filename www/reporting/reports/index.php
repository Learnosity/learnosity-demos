<?php

include_once '../../config.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$security = array(
    "consumer_key" => 'yis0TYCu7U9V4o7M',
    "domain"       => $domain,
    "timestamp"    => $timestamp,
);

$request = array(
    'reports' => array(
        array(
            'id'          => 'report-1',
            'type'        => 'sessions-summary',
            'user_id'     => 'brianmoser',
            'session_ids' => array(
                'AC023456-2C73-44DC-82DA28894FCBC3BF'
            )
        ),
        array(
            'id'         => 'report-2',
            'type'       => 'session-detail',
            'user_id'    => 'brianmoser',
            'session_id' => 'B146BA2C-C2D0-4368-B90FFBA2B245F2BA'
        ),
        array(
            'id'        => 'report-3',
            'type'      => 'progress-by-tag',
            'user_id'   => 'brianmoser',
            'hierarchy' => 'author'
        ),
        array(
            'id'          => 'report-4',
            'type'        => 'sessions-summary-by-tag',
            'user_id'     => 'brianmoser',
            'ui'          => 'bar-chart',
            'hierarchy'   => 'author',
            'session_ids' => array(
                'B146BA2C-C2D0-4368-B90FFBA2B245F2BA'
            )
        ),
        array(
            'id'           => 'report-5',
            'type'         => 'lastscore-by-activity-by-user',
            'scoring_type' => 'partial',
            'ui'           => 'numeric',
            'users'        => array(
                array(
                    'id' => 'brianmoser',
                    'name' => 'Brian Moser'
                ),
                array(
                    'id' => '12345678',
                    'name' => 'John Carter'
                )
            ),
            'activities' => array(
                array(
                    'id' => 'edde56e8-ff65-e42e-b4fe49caad796bd',
                    'name' => 'Mid Term'
                ),
                array(
                    'id' => 'emberDemo2013',
                    'name' => 'Final'
                )
            )
        ),
        array(
            'id'           => 'report-6',
            'type'         => 'lastscore-by-activity',
            'scoring_type' => 'partial',
            'user_id'      => 'brianmoser',
            'activities'   => array(
                array(
                    'id' => 'edde56e8-ff65-e42e-b4fe49caad796bd',
                    'name' => 'Mid Term'
                ),
                array(
                    'id' => 'emberDemo2013',
                    'name' => 'Final'
                )
            )
        ),
        array(
            'id'           => 'report-7',
            'type'         => 'lastscore-by-item-by-user',
            'scoring_type' => 'partial',
            'users'        => array(
                array(
                    'id' => 'brianmoser',
                    'name' => 'Brian Moser'
                ),
                array(
                    'id' => '12345678',
                    'name' => 'John Carter'
                )
            ),
            'activity_id' => '52f5b81d-9270-914a-7094a1ada4d55e6e'
        ),
        array(
            'id'    => 'report-8',
            'type'  => 'lastscore-by-tag-by-user',
            'users' => array(
                array(
                    'id' => 'brianmoser',
                    'name' => 'Brian Moser'
                ),
                array(
                    'id' => '12345678',
                    'name' => 'John Carter'
                )
            ),
            'activity_id' => '52f5b81d-9270-914a-7094a1ada4d55e6e',
            'hierarchy' => 'questiontype'
        )
    )
);

$RequestHelper = new RequestHelper(
    'reports',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>
<style type="text/css">
    .tabs-left, .tabs-right {
        border-bottom: none;
        padding-top: 2px;
    }
    .tabs-left {
        border-right: 1px solid #ddd;
    }
    .tabs-right {
        border-left: 1px solid #ddd;
    }
    .tabs-left>li, .tabs-right>li {
        float: none;
        margin-bottom: 2px;
    }
    .tabs-left>li {
        margin-right: -1px;
    }
    .tabs-right>li {
        margin-left: -1px;
    }
    .tabs-left>li.active>a, .tabs-left>li.active>a:hover, .tabs-left>li.active>a:focus {
        border-bottom-color: #ddd;
        border-right-color: transparent;
    }
    .tabs-right>li.active>a, .tabs-right>li.active>a:hover, .tabs-right>li.active>a:focus {
        border-bottom: 1px solid #ddd;
        border-left-color: transparent;
    }
    .tabs-left>li>a {
        border-radius: 4px 0 0 4px;
        margin-right: 0;
        display:block;
    }
    .tabs-right>li>a {
        border-radius: 0 4px 4px 0;
        margin-right: 0;
    }
    .lrn-reports-vertical-content {
        margin-left: -1px;
        min-width: 900px;
        width: 900px;
        border-left: 1px solid #ddd;
        padding-left: 30px;
    }
    .lrn-nav-reports {
        width: 190px;
        height: 100%;
    }
    .lrn-nav-reports ul.nav-tabs .padding {
        height: 37px;
    }
    .lrn-reports-content {
        min-width: 1100px;
        height: 100%;
    }
    .lrn-reports-summary {
        font-size: 13px;
    }
    html,
    body,
    .lrn-nav-reports ul {
        height: 100%;
    }
</style>
<div class="jumbotron clearfix">
    <h1>Reports API</h1>
    <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/reportsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2">
            <p class='text-right'>
                <a class="btn btn-primary btn-lg" href="../sso">
                    Next <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </p>
        </div>
    </div>
</div>
<div class="lrn-reports-content clearfix">
    <div class="lrn-nav-reports pull-left">
        <ul class="nav nav-tabs tabs-left">
            <li class="padding">&nbsp;</li>
            <li class="active"><a href="#sessions" data-toggle="tab">Reports by Session</a></li>
            <li><a href="#lastscore" data-toggle="tab">Reports by Latest Score</a></li>
            <li><a href="#progress" data-toggle="tab">Reports by Progress</a></li>
        </ul>
    </div>

    <!-- Tab panes -->
    <div class="lrn-reports-vertical-content lrn-tab-content tab-content pull-left">
        <div class="tab-pane active" id="sessions">
            <div class="lrn-nav-sessions">
                <ul class="nav nav-tabs">
                  <li class="active"><a id="lrn-nav-session-summary" href="#sessions-summary" data-toggle="tab">Sessions Summary</a></li>
                  <li><a id="lrn-nav-session-detail" href="#sessions-detail" data-toggle="tab">Session Detail</a></li>
                  <li><a id="lrn-nav-session-tags" href="#sessions-tags" data-toggle="tab">Sessions Summary By Tag Chart</a></li>
                </ul>
            </div>
            <div class="lrn-tab-content tab-content">
                <div class="tab-pane active" id="sessions-summary">
                    <section>
                        <h3 class="report-title">Sessions Summary</h3>
                        <p class="lrn-report-summary">Gain quick, meaningful information about a students session at a glance.</p>
                        <span class="learnosity-report" id="report-1"></span>
                    </section>
                </div>
                <div class="tab-pane" id="sessions-detail">
                    <section>
                        <h3 class="report-title">Session Detail</h3>
                        <p class="lrn-report-summary">A fine-grain approach to gleaning strengths and weaknesses from a students session.</p>
                        <span class="learnosity-report" id="report-2"></span>
                    </section>
                </div>
                <div class="tab-pane" id="sessions-tags">
                    <section>
                        <h3 class="report-title">Sessions Summary By Tag Chart</h3>
                        <p class="lrn-report-summary">A sessions summary broken down into its constituent tags.</p>
                        <span class="learnosity-report" id="report-4"></span>
                    </section>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="lastscore">
            <div class="lrn-nav-lastscore">
                <ul class="nav nav-tabs">
                    <li class="active"><a id="lrn-nav-lastscore-activity" href="#lastscore-activity" data-toggle="tab">Latest Score By Activity</a></li>
                    <li><a id="lrn-nav-lastscore-user" href="#lastscore-user" data-toggle="tab">Latest Score By Activity By User</a></li>
                    <li><a id="lrn-nav-lastscore-item" href="#lastscore-item" data-toggle="tab">Latest Score By Item By User</a></li>
                    <li><a id="lrn-nav-lastscore-tag" href="#lastscore-tag" data-toggle="tab">Latest Score By Tag By User</a></li>
                </ul>
            </div>
            <div class="lrn-tab-content tab-content">
                <div class="tab-pane active" id="lastscore-activity">
                    <section>
                        <h3 class="report-title">Latest Score by Activity</h3>
                        <p class="lrn-report-summary">
                            Obtain the latest activity scores for a particular student, represented by either a progress bar (shown), or a numeric result.
                            <br>Hover over student scores to gather a meaningful score breakdown.
                        </p>
                        <p class="lrn-report-summary">Activities and scores can trigger onClick events to tie into other reports.</p>
                        <span class="learnosity-report" id="report-6"></span>
                    </section>
                    <div id="lrn-report-lastscore-activity-events"></div>
                </div>
                <div class="tab-pane" id="lastscore-user">
                    <section>
                        <h3 class="report-title">Latest Score by Activity by User</h3>
                        <p class="lrn-report-summary">
                            Obtain the latest activity scores for a group of students, represented by either a numeric result (shown), or a progress bar.
                            <br>Hover over student scores to gather a meaningful score break-down.
                        </p>
                        <p class="lrn-report-summary">Names, activities and scores can trigger onClick events to tie into other reports.</p>
                        <span class="learnosity-report" id="report-5"></span>
                    </section>
                    <div id="lrn-report-lastscore-user-events"></div>
                </div>
                <div class="tab-pane" id="lastscore-item">
                    <section>
                        <h3 class="report-title">Latest Score by Item by User</h3>
                        <p class="lrn-report-summary">
                            Obtain the latest activity score with a break-down of its constituent items.
                            <br>Hover over items to see the fine grain score break-down.
                        </p>
                        <p class="lrn-report-summary">Names and scores can trigger onClick events to tie into other reports.</p>
                        <span class="learnosity-report" id="report-7"></span>
                    </section>
                    <div id="lrn-report-lastscore-item-events"></div>
                </div>
                <div class="tab-pane" id="lastscore-tag">
                    <section>
                        <h3 class="report-title">Latest Score by Tag by User</h3>
                        <p class="lrn-report-summary">
                            Obtain the latest activity score with a break-down of scores according its constituent tags.
                            <br>Hover over the tag scores to see the fine grain score break-down.
                        </p>
                        <p class="lrn-report-summary">Names and scores can trigger onClick events to tie into other reports.</p>
                        <span class="learnosity-report" id="report-8"></span>
                    </section>
                    <div id="lrn-report-lastscore-tag-events"></div>
                </div>
            </div>
      </div>
      <div class="tab-pane" id="progress">
          <section>
              <h3 class="report-title">Progress by Tag Table</h3>
              <p class="lrn-report-summary">Gather insight into user progress according to your assigned tag hierarchy.</p>
              <div class="alert alert-info">
                  <strong>Note:</strong> The progress data for this report is updated every 5 minutes
              </div>
              <span class="learnosity-report" id="report-3"></span>
          </section>
      </div>
    </div>
</div>

<script src="//reports.learnosity.com"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    var config = <?php echo $signedRequest; ?>;
    config.configuration = {
        questionsApiVersion: "v2"
    };
    var lrnReports = LearnosityReports.init(config, {
        readyListener: onReportsReady
    });

    function onReportsReady() {
        var commonFunction = function(data, target) {
            var html = '<div class="alert alert-info alert-dismissable">';
                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>';
                html += data.user_id ? '<p><strong>User ID:</strong> ' + data.user_id + '</p>' : '';
                html += data.activity_id ? '<p><strong>Activity ID:</strong> ' + data.activity_id + '</p>' : '';
                html += data.session_id ? '<p><strong>Session ID:</strong> ' + data.session_id + '</p>' : '';
                html += '</p></div>';
            $('#' + target).append(html);
        };

        /* group-lastscore-by-activity onclick events */
        var groupLastScoreByActivity = lrnReports.getReport('report-6');

        groupLastScoreByActivity.on('click:score', function (data) {
            commonFunction(data, 'lrn-report-lastscore-activity-events');
        });

        groupLastScoreByActivity.on('click:activity', function (data) {
            commonFunction(data, 'lrn-report-lastscore-activity-events');
        });

        groupLastScoreByActivity.on('click:user', function(data) {
            commonFunction(data, 'lrn-report-lastscore-activity-events');
        });

        /* user-lastscore-by-activity onclick events */
        var userLastScoreByActivity = lrnReports.getReport('report-5');

        userLastScoreByActivity.on('click:score', function (data) {
            commonFunction(data, 'lrn-report-lastscore-user-events');
        });

        userLastScoreByActivity.on('click:user', function (data) {
            commonFunction(data, 'lrn-report-lastscore-user-events');
        });

        userLastScoreByActivity.on('click:activity', function (data) {
            commonFunction(data, 'lrn-report-lastscore-user-events');
        });

        /* group-lastscore-by-item onclick events */
        var groupLastScoreByItem = lrnReports.getReport('report-7');
        groupLastScoreByItem.on('click:score', function (data) {
            commonFunction(data, 'lrn-report-lastscore-item-events');
        });

        groupLastScoreByItem.on('click:user', function (data) {
            commonFunction(data, 'lrn-report-lastscore-item-events');
        });

        /* group-lastscore-by-tag onclick events */
        var groupLastScoreByTag = lrnReports.getReport('report-8');
        groupLastScoreByTag.on('click:score', function (data) {
            commonFunction(data, 'lrn-report-lastscore-tag-events');
        });

        groupLastScoreByTag.on('click:user', function (data) {
            commonFunction(data, 'lrn-report-lastscore-tag-events');
        });

        $('.lrn-reports-vertical-content ul.nav-tabs li a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            var select = ($(this).attr('id')).replace('lrn-nav-', '');
            console.log(select);
            $('.' + select + ' .lrn-report-response-container').hide().html($('.session-detail .lrn-report-response-container').html()).fadeIn(0);
        });
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
