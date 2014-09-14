<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
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
            'session_id' => '8151DD9E-9029-4D13-AC773EC9C05E7FF2'
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
        ),
        array(
            'id'          => 'report-9',
            'type'        => 'sessions-list',
            'limit'       => 15,
            'ui'          => 'table'
        ),
        array(
            'id'          => 'report-10',
            'type'        => 'lastscore-single',
            'ui'          => 'bar',
            'user_id'     => 'demo_student',
            'activity_id' => '6c2935ae-eecc-4387-9494-a6d47f067893'
        ),
        array(
            'id'          => 'report-11',
            'type'        => 'lastscore-single',
            'ui'          => 'bar',
            'user_id'     => '12345678',
            'activity_id' => 'BD13_L1_P24_AC2'
        ),
        array(
            'id'          => 'report-12',
            'type'        => 'lastscore-single',
            'ui'          => 'bar',
            'user_id'     => 'brianmoser',
            'activity_id' => 'edde56e8-ff65-e42e-b4fe49caad796bd'
        ),
        array(
            'id'          => 'report-13',
            'type'        => 'lastscore-single',
            'ui'          => 'pie',
            'user_id'     => 'demo_student',
            'activity_id' => '6c2935ae-eecc-4387-9494-a6d47f067893'
        ),
        array(
            'id'          => 'report-14',
            'type'        => 'lastscore-single',
            'ui'          => 'pie',
            'user_id'     => '12345678',
            'activity_id' => 'BD13_L1_P24_AC2'
        ),
        array(
            'id'          => 'report-15',
            'type'        => 'lastscore-single',
            'ui'          => 'pie',
            'user_id'     => 'brianmoser',
            'activity_id' => 'edde56e8-ff65-e42e-b4fe49caad796bd'
        ),
        array( //NEW
            'id'          => 'report-16',
            'type'        => 'progress-single',
            'user_id'     => 'brianmoser',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozeassociation'
                )
            )
        ),
        array(
            'id'          => 'report-17',
            'type'        => 'progress-single',
            'user_id'     => 'brianmoser',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozetext'
                )
            )
        ),
        array(
            'id'          => 'report-18',
            'type'        => 'progress-single',
            'user_id'     => '12345678',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozetext'
                )
            )
        ),
        array(
            'id'          => 'report-21',
            'type'        => 'progress-single',
            'user_id'     => 'brianmoser',
            'ui'          => 'pie',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozeassociation'
                )
            )
        ),
        array(
            'id'          => 'report-21',
            'type'        => 'progress-single',
            'user_id'     => 'brianmoser',
            'ui'          => 'pie',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozetext'
                )
            )
        ),
        array(
            'id'          => 'report-21',
            'type'        => 'progress-single',
            'user_id'     => '12345678',
            'ui'          => 'pie',
            'hierarchy'   => 'questiontype',
            'tag_hierarchy_path'   => array(
                array(
                    'type'  => 'questiontype',
                    'name'  => 'clozetext'
                )
            )
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
        <h1>Reports API</h1>
        <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
    </div>
</div>

<div class="section">
    <div class="panel-group" id="lrn-reports-demos-accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-accordion" href="#lrn-reports-demos-sessions">
                    Reports By Session
                </a>
                </h4>
            </div>
            <div id="lrn-reports-demos-sessions" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div id="lrn-reports-demos-sessions-content">
                        <div class="lrn-nav-tabs lrn-nav-sessions pull-left">
                            <ul class="nav nav-tabs tabs-left">
                              <li class="active"><a id="report-session-summary" href="#sessions-summary" data-toggle="tab">Sessions Summary</a></li>
                              <li><a id="report-session-list" href="#sessions-list" data-toggle="tab">Sessions List</a></li>
                              <li><a id="report-session-detail" href="#sessions-detail" data-toggle="tab">Session Detail</a></li>
                              <li><a id="report-session-tags" href="#sessions-tags" data-toggle="tab">Sessions Summary By Tag Chart</a></li>
                            </ul>
                        </div>
                        <div class="lrn-reports-vertical-content lrn-tab-content tab-content pull-left">
                            <div class="tab-pane active" id="sessions-summary">
                                <section>
                                    <h3 class="report-title">Sessions Summary</h3>
                                    <p class="lrn-report-summary">Gain quick, meaningful information about a students session at a glance.</p>
                                    <span class="learnosity-report" id="report-1"></span>
                                </section>
                            </div>
                            <div class="tab-pane" id="sessions-list">
                                <section>
                                    <h3 class="report-title">Sessions List</h3>
                                    <p class="lrn-report-summary">Get a quick glimpse of the latest sessions.</p>
                                    <p class="lrn-report-summary">Session progress bars can trigger onClick events to tie into other reports.</p>
                                    <span class="learnosity-report" id="report-9"></span>
                                </section>
                                <div id="lrn-report-sessions-list-events"></div>
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
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a id="accordion-report-lastscore" data-toggle="collapse" data-parent="#lrn-reports-demos-accordion" href="#lrn-reports-demos-lastscore">
                        Reports By Last Score
                    </a>
                </h4>
            </div>
            <div id="lrn-reports-demos-lastscore" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="lrn-reports-demos-lastscore-content">
                        <div class="lrn-nav-tabs lrn-nav-lastscore pull-left">
                            <ul class="nav nav-tabs tabs-left">
                                <li class="active"><a id="report-lastscore-activity" href="#lastscore-activity" data-toggle="tab">Last Score By Activity</a></li>
                                <li><a id="report-lastscore-user" href="#lastscore-user" data-toggle="tab">Last Score By Activity By User</a></li>
                                <li><a id="report-lastscore-single" href="#lastscore-single" data-toggle="tab">Last Score Single</a></li>
                                <li><a id="report-lastscore-item" href="#lastscore-item" data-toggle="tab">Last Score By Item By User</a></li>
                                <li><a id="report-lastscore-tag" href="#lastscore-tag" data-toggle="tab">Last Score By Tag By User</a></li>
                            </ul>
                        </div>
                        <div class="lrn-reports-vertical-content lrn-tab-content tab-content pull-left">
                            <div class="tab-pane active" id="lastscore-activity">
                                <section>
                                    <h3 class="report-title">Last Score by Activity</h3>
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
                                    <h3 class="report-title">Last Score by Activity by User</h3>
                                    <p class="lrn-report-summary">
                                        Obtain the latest activity scores for a group of students, represented by either a numeric result (shown), or a progress bar.
                                        <br>Hover over student scores to gather a meaningful score break-down.
                                    </p>
                                    <p class="lrn-report-summary">Names, activities and scores can trigger onClick events to tie into other reports.</p>
                                    <span class="learnosity-report" id="report-5"></span>
                                </section>
                                <div id="lrn-report-lastscore-user-events"></div>
                            </div>
                            <div class="tab-pane" id="lastscore-single">
                                <section>
                                    <h3 class="report-title">Last Score Single</h3>
                                    <p class="lrn-report-summary">
                                        Single reports are designed to be embedded within content pages.</p>
                                        <p class="lrn-report-summary">Obtain the latest activity score in a single bar or chart format (each bar/chart below is a separate report).</p>
                                        <p class="lrn-report-summary">Score progress bars and charts can trigger onClick events to tie into other reports.</p>
                                    <table class="lrn-single-reports">
                                        <tr>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-10"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-11"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-12"></span></div></td>
                                        </tr>
                                        <tr>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-13"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-14"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-15"></span></div></td>
                                        </tr>
                                    </table>
                                </section>
                                <div id="lrn-report-lastscore-single-events"></div>
                            </div>
                            <div class="tab-pane" id="lastscore-item">
                                <section>
                                    <h3 class="report-title">Last Score by Item by User</h3>
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
                                    <h3 class="report-title">Last Score by Tag by User</h3>
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
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a id="accordion-report-progress" data-toggle="collapse" data-parent="#lrn-reports-demos-accordion" href="#lrn-reports-demos-progress">
                        Reports By Progress
                    </a>
                </h4>
            </div>
            <div id="lrn-reports-demos-progress" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="lrn-reports-demos-progress-content">
                        <div class="lrn-nav-tabs lrn-nav-progress pull-left">
                            <ul class="nav nav-tabs tabs-left">
                              <li class="active"><a id="report-progress-by-tag-table" href="#progress-by-tag-table" data-toggle="tab">Progress By Tag Table</a></li>
                              <li><a id="report-progress-single" href="#progress-single" data-toggle="tab">Progress Single</a></li>
                            </ul>
                        </div>
                        <div class="lrn-reports-vertical-content lrn-tab-content tab-content pull-left">
                            <div class="tab-pane active" id="progress-by-tag-table">
                                <section>
                                    <h3 class="report-title">Progress by Tag Table</h3>
                                    <p class="lrn-report-summary">Gather insight into user progress according to your assigned tag hierarchy.</p>
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> The progress data for this report is updated every 5 minutes
                                    </div>
                                    <span class="learnosity-report" id="report-3"></span>
                                </section>
                            </div>
                            <div class="tab-pane" id="progress-single">
                                <section>
                                    <h3 class="report-title">Progress Single</h3>
                                    <p class="lrn-report-summary">
                                        Single reports are designed to be embedded within content pages.</p>
                                    <p class="lrn-report-summary">
                                        Gather insight into user progress according to your assigned tag hierarchy (each bar/chart below is a separate report).
                                    </p>
                                    <table class="lrn-single-reports">
                                        <tr>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-16"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-17"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-18"></span></div></td>
                                        </tr>
                                        <tr>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-19"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-20"></span></div></td>
                                            <td width="33%"><div class="lrn-single-report"><span class="learnosity-report" id="report-21"></span></div></td>
                                        </tr>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Real time reports -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                <a id="accordion-report-live" data-toggle="collapse" data-parent="#lrn-reports-demos-accordion" href="#lrn-reports-demos-live">
                    Reports By Live Progress
                </a>
                </h4>
            </div>
            <div id="lrn-reports-demos-live" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="lrn-reports-demos-live-content">
                        <div class="lrn-nav-tabs lrn-nav-live pull-left">
                            <ul class="nav nav-tabs tabs-left">
                              <li class="active"><a id="report-session-summary" href="#live-progress" data-toggle="tab">Live Progress Tracking</a></li>
                            </ul>
                        </div>
                        <div class="lrn-reports-vertical-content lrn-tab-content tab-content pull-left">
                            <div class="tab-pane active" id="live-progress">
                                <section>
                                    <h3 class="report-title">Live Progress Tracking</h3>
                                    <p class="lrn-report-summary">Displays a real-time report of students status for an activity.</p>
                                    <p>You can also send real-time remote control events to do things like:</p>
                                    <ul>
                                        <li>Pause/Unpause</li>
                                        <li>Extend activity time</li>
                                        <li>Save &amp; Quit</li>
                                        <li>Exit &amp; Discard</li>
                                    </ul>
                                    <p>Visit our <a href="./live_progress.php">interactive demo</a> to see this in action.</p>
                                    <p>Review the <a href="http://docs.learnosity.com/reportsapi/reporttypes.php#live-activitystatus-by-user">documentation here</a>.</p>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<script src="//reports.learnosity.com"></script>
<script src="<?php echo $env['www'] ?>static/vendor/head.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/reveal/reveal.js"></script>
<script>
    var config = <?php echo $signedRequest; ?>;
    config.configuration = {
        questionsApiVersion: "v2"
    };
    var lrnReports = LearnosityReports.init(
        config,
        {
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

        /* group-lastscore-by-activity onclick events */
        var groupLastScoreByActivity = lrnReports.getReport('report-6');

        groupLastScoreByActivity.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-activity-events', true);
        });

        groupLastScoreByActivity.on('click:activity', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-activity-events', false);
        });

        groupLastScoreByActivity.on('click:user', function(data) {
            onClickFunction(data, 'lrn-report-lastscore-activity-events', false);
        });

        /* user-lastscore-by-activity onclick events */
        var userLastScoreByActivity = lrnReports.getReport('report-5');

        userLastScoreByActivity.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-user-events', true);
        });

        userLastScoreByActivity.on('click:user', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-user-events', false);
        });

        userLastScoreByActivity.on('click:activity', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-user-events', false);
        });

        /* group-lastscore-by-item onclick events */
        var groupLastScoreByItem = lrnReports.getReport('report-7');
        groupLastScoreByItem.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-item-events', true);
        });

        groupLastScoreByItem.on('click:user', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-item-events', false);
        });

        /* group-lastscore-by-tag onclick events */
        var groupLastScoreByTag = lrnReports.getReport('report-8');
        groupLastScoreByTag.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-tag-events', true);
        });

        groupLastScoreByTag.on('click:user', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-tag-events', false);
        });

        /* sessions-list onclick events */
        var sessionsList = lrnReports.getReport('report-9');
            sessionsList.on('click:session', function (data) {
            onClickFunction(data, 'lrn-report-sessions-list-events', false);
        });

        /* lastscore-single onclick events */
        var lastScoreSingleOne = lrnReports.getReport('report-10');
        lastScoreSingleOne.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });
        var lastScoreSingleTwo = lrnReports.getReport('report-11');
        lastScoreSingleTwo.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });
        var lastScoreSingleThree = lrnReports.getReport('report-12');
        lastScoreSingleThree.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });
        var lastScoreSingleFour = lrnReports.getReport('report-13');
        lastScoreSingleFour.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });
        var lastScoreSingleFive = lrnReports.getReport('report-14');
        lastScoreSingleFive.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });
        var lastScoreSingleSix = lrnReports.getReport('report-15');
        lastScoreSingleSix.on('click:score', function (data) {
            onClickFunction(data, 'lrn-report-lastscore-single-events', false);
        });

        // Sessions detail hidden width fix
        $('a#report-session-detail').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            $('.lrn_response_innerbody').width('100%');
            $('.lrn_graph_plotter .lrn_btn').click();
        });

        // lastscore-single hidden width fix
        $('a#report-lastscore-single').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            $('.lastscore-single canvas').each(function () {
                var size = $(this).parent().width();
                $(this).width(size);
                $(this).height(size);
            });
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
