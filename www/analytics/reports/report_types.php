<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$activitySummaryByGroupColumns = [
    [
        "type" => "group_name",
    ],
    [
        "type" => "numeric",
        "field" => "population",
        "label" => "Students"
    ],
    [
        "type" => "numeric",
        "field" => "lowest_percent",
        "label" => "Lowest score %"
    ],
    [
        "type" => "numeric",
        "field" => "highest_percent",
        "label" => "Highest score %"
    ],
    [
        "type" => "numeric",
        "field" => "mean_percent",
        "label" => "Average score %"
    ],
    [
        "type" => "numeric",
        "field" => "median_percent",
        "label" => "Median score %"
    ],
    [
        "type" => "numeric",
        "field" => "p75_percent",
        "label" => "75th percentile"
    ]
];

$usersMap = json_decode(file_get_contents(__DIR__ . "/aggregatereports/usersMap.json"), true);

$request = array(
    'configuration' => array(
        'questionsApiVersion' => 'v2'
    ),
    'reports' => array(
        array(
            'id'          => 'report-1',
            'type'        => 'sessions-summary',
            'user_id'     => 'mce_student',
            'session_ids' => array(
                'd7ad7585-a0c1-4c01-9762-44a85f55835c'
            )
        ),
        array(
            'id'         => 'report-2',
            'type'       => 'session-detail-by-item',
            'user_id'    => 'brianmoser',
            'session_id' => '8151DD9E-9029-4D13-AC773EC9C05E7FF2'
            // Better to use this session below as it corresponds to the session-detail-by-question report below.
            // 'user_id'    => 'demo_student',
            // 'session_id' => 'ac65af88-78e6-4117-920b-f11497542e45'

        ),
        array(
            'id'         => 'report-2b',
            'type'       => 'session-detail-by-question',
            'user_id'    => 'demo_student',
            'session_id' => 'ac65af88-78e6-4117-920b-f11497542e45'
        ),
        array(
            'id'        => 'report-3',
            'type'      => 'progress-by-tag',
            'user_id'   => 'mce_student_1',
            'hierarchy' => 'CCSS'
        ),
        array(
            'id'          => 'report-4',
            'type'        => 'sessions-summary-by-tag',
            'user_id'     => 'mce_student_3',
            'hierarchy'   => 'CCSS',
            'session_ids' => array(
                'd5cde952-1111-49ad-bfc7-c1ba102f3b22'
            ),
        ),
        array(
            'id'                 => 'report-5',
            'type'               => 'lastscore-by-activity-by-user',
            'scoring_type'       => 'partial',
            'ui'                 => 'numeric',
            'display_time_spent' => true,
            'users'              => array(
                array(
                    'id' => 'mce_student',
                    'name' => 'Jesse Pinkman'
                ),
                array(
                    'id' => 'mce_student_1',
                    'name' => 'Walter White'
                ),

                array(
                    'id' => 'mce_student_2',
                    'name' => 'Skylar White'
                ),
                 array(
                    'id' => 'mce_student_3',
                    'name' => 'Saul Goodman'
                ),
                 ),

            'activities' => array(
                array(
                    'id' => 'Summer_Test_1',
                    'name' => 'Summer Test'
                ),
                array(
                    'id' => 'Weekly_Math_Quiz',
                    'name' => 'Weekly Math Quiz'
                )
            )
        ),
        array(
            'id'                 => 'report-6',
            'type'               => 'lastscore-by-activity',
            'scoring_type'       => 'partial',
            'user_id'            => 'mce_student',
            'display_time_spent' => true,
            'activities'         => array(
                array(
                    'id' => 'Summer_Test_1',
                    'name' => 'Summer Test'
                ),
                array(
                    'id' => 'Weekly_Math_Quiz',
                    'name' => 'Weekly Math Quiz'
                )
            )
        ),
        array(
            'id'                   => 'report-7',
            'type'                 => 'lastscore-by-item-by-user',
            'display_time_spent'   => true,
            'display_item_numbers' => true,
            'scoring_type'         => 'partial',
            'users'                => array(
                array(
                    'id' => 'mce_student',
                    'name' => 'Jesse Pinkman'
                ),
                array(
                    'id' => 'mce_student_2',
                    'name' => 'Skylar White'
                ),
                array(
                    'id' => 'mce_student_1',
                    'name' => 'Walter White'
                ),
                array(
                    'id' => 'mce_student_3',
                    'name' => 'Saul Goodman'
                )
            ),
            'activity_id' => 'Weekly_Math_Quiz'
        ),
        array(
            'id'                 => 'report-8',
            'type'               => 'lastscore-by-tag-by-user',
            'display_time_spent' => true,
            'users'              => array(
                array(
                    'id' => 'mce_student',
                    'name' => 'Jesse Pinkman'
                ),
                 array(
                    'id' => 'mce_student_1',
                    'name' => 'Walter White'
                ),
                   array(
                    'id' => 'mce_student_2',
                    'name' => 'Skylar White'
                ),
                    array(
                    'id' => 'mce_student_3',
                    'name' => 'Saul Goodman'
                )
            ),
            'activity_id' => 'Weekly_Math_Quiz',
            'hierarchy' => 'DepthofKnowledge'
        ),
        array(
            'id'          => 'report-9',
            'type'        => 'sessions-list',
            'limit'       => 15,
            'ui'          => 'table',
            'activities'  => array(
                array(
                    "id" => "Summer_Test_1",
                    "name" => "Summer Test 1, 2015"
                    ),
                array(
                    "id" => "Weekly_Math_Quiz",
                    "name" => "Weekly Math Quiz"
                    )
                )
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
            'id'          => 'report-19',
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
            'id'          => 'report-20',
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
        ),
        array(
            'id'           => 'report-22',
            'type'         => 'sessions-list-by-item',
            'limit'        => 15,
            'activity_id'  => 'MCE_5.MD.5b',
            'display_user' => true,
            'users'        => array(
                array(
                    'id'   => 'mce_student',
                    'name' => 'Brian Moser'
                )
            )
        ),
        array(
            'id'          => 'report-23',
            'type'        => 'sessions-summary-by-question',
            'user_id'     => 'mce_student',
            'session_ids' => array(
                'd7ad7585-a0c1-4c01-9762-44a85f55835c'
            )
        ),
        array(
            'id'          => 'activity-summary-by-group-report',
            'type'        => 'activity-summary-by-group',
            'dataset_id'  => 'a1a8e23e-7fce-4146-b079-9b607697df23',
            "group_path" => [],
            "columns" => $activitySummaryByGroupColumns,
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
                <div class="panel-body no-padding-bottom">
                    <div class="panel-group" id="lrn-reports-demos-sessions-content">

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-1">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> <span style="color:">Sessions Summary</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Gain quick, meaningful information about a students session at a glance</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="tab-pane active" id="sessions-summary">
                                        <section>
                                            <h3 class="report-title">Sessions Summary</h3>
                                            <p class="lrn-report-summary">Gain quick, meaningful information about a students session at a glance.</p>
                                            <span class="learnosity-report" id="report-1"></span>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-6">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Sessions Summary By Tag Chart</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">A sessions summary broken down into its constituent tags</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-6" class="panel-collapse collapse">
                                <div class="panel-body">
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

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-7">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Sessions Summary By Question</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">A sessions summary broken down into its questions</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="tab-pane" id="sessions-summary-by-quesiton">
                                        <section>
                                            <h3 class="report-title">Sessions Summary By Question</h3>
                                            <p class="lrn-report-summary">A sessions summary broken down into its questions.</p>
                                            <span class="learnosity-report" id="report-23"></span>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-2">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"></span> Sessions List</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Get a quick glimpse of the latest sessions</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="tab-pane" id="sessions-list">
                                        <section>
                                            <h3 class="report-title">Sessions List</h3>
                                            <p class="lrn-report-summary">Get a quick glimpse of the latest sessions.</p>
                                            <p class="lrn-report-summary">Session progress bars can trigger onClick events to tie into other reports.</p>
                                            <span class="learnosity-report" id="report-9"></span>
                                        </section>
                                        <div id="lrn-report-sessions-list-events"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-3">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"></span>Sessions List By Item</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Get a quick glimpse of the latest sessions with a score break-down for each item per session</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="tab-pane" id="sessions-list-by-item">
                                        <section>
                                            <h3 class="report-title">Sessions List By Item</h3>
                                            <p class="lrn-report-summary">Get a quick glimpse of the latest sessions with a score break-down for each item per session.</p>
                                            <p class="lrn-report-summary">Names can trigger onClick events to tie into other reports.</p>
                                            <p class="lrn-report-summary">Hover over items to see the fine grain score break-down.</p>
                                            <span class="learnosity-report" id="report-22"></span>
                                        </section>
                                        <div id="lrn-report-sessions-list-by-item-events"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-5">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Session Detail By Question</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">For a single user session, shows the specific responses of the user for each question</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="tab-pane" id="sessions-detail">
                                        <section>
                                            <h3 class="report-title">Session Detail By Question</h3>
                                            <p class="lrn-report-summary">For a single user session, shows the specific responses of the user for each question.</p>
                                            <p class="lrn-report-summary">This is a fine-grain approach to gleaning a students strengths and weaknesses, question by question.</p>
                                            <span class="learnosity-report" id="report-2b"></span>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-no-border">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="accordion-report-session" data-toggle="collapse" data-parent="#lrn-reports-demos-sessions-content" href="#lrn-reports-demos-sessions-inner-4">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Session Detail By Item</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">For a single user session, shows the specific responses of the user for each item</p>

                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lrn-reports-demos-sessions-inner-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="tab-pane" id="sessions-detail">
                                        <section>
                                            <h3 class="report-title">Session Detail By Item</h3>
                                            <p class="lrn-report-summary">For a single user session, shows the specific responses of the user for each item.</p>
                                            <p class="lrn-report-summary">Unlike the <i>Session Detail By Question</i> report above which shows only the questions, this report shows the questions and any additional elements the item may contain, such as HTML, images, widgets or other questions.</p>
                                            <span class="learnosity-report" id="report-2"></span>
                                        </section>
                                    </div>
                                </div>
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
                <div class="panel-body no-padding-bottom">
                    <div class="panel-group" id="lrn-reports-demos-lastscore-content">

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-lastscore-activity" data-toggle="collapse" data-parent="#lrn-reports-demos-lastscore-content" href="#lastscore-activity">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> <span style="color:">Last Score By Activity</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Obtain the latest activity scores for a particular student</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lastscore-activity" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Last Score By Activity</h3>
                                        <p class="lrn-report-summary">Obtain the latest activity scores for a particular student, represented by either a progress bar (shown), or a numeric result.</p>
                                        <p class="lrn-report-summary">Hover over student scores to gather a meaningful score breakdown.</p>
                                        <p class="lrn-report-summary">Activities and scores can trigger onClick events to tie into other reports.</p>
                                        <span class="learnosity-report" id="report-6"></span>
                                    </section>
                                    <div id="lrn-report-lastscore-activity-events"></div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-lastscore-user" data-toggle="collapse" data-parent="#lrn-reports-demos-lastscore-content" href="#lastscore-user">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"></span> Last Score By Activity By User</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Obtain the latest activity scores for a group of students</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lastscore-user" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Last Score By Activity By User</h3>
                                        <p class="lrn-report-summary">Obtain the latest activity scores for a group of students, represented by either a numeric result (shown), or a progress bar.</p>
                                        <p class="lrn-report-summary">Hover over student scores to gather a meaningful score break-down.</p>
                                        <p class="lrn-report-summary">Names, activities and scores can trigger onClick events to tie into other reports.</p>
                                        <span class="learnosity-report" id="report-5"></span>
                                    </section>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                <a id="report-lastscore-single" data-toggle="collapse" data-parent="#lrn-reports-demos-lastscore-content" href="#lastscore-single">
                                    <div class="row">
                                        <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Last Score Single</div>
                                        <div class="col-sm-8">
                                            <p class="lrn-report-summary">Obtain the latest score for a particular student for a particular activity</p>
                                        </div>
                                    </div>
                                </a>
                                </h4>
                            </div>
                            <div id="lastscore-single" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Last Score Single</h3>
                                        <p class="lrn-report-summary">Single reports are designed to be embedded within content pages.</p>
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
                            </div>
                        </div>

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-lastscore-item" data-toggle="collapse" data-parent="#lrn-reports-demos-lastscore-content" href="#lastscore-item">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Last Score By Item By User</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Obtain the latest activity score with a break-down of its constituent items</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lastscore-item" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Last Score By Item By User</h3>
                                        <p class="lrn-report-summary">Obtain the latest activity score with a break-down of its constituent items.</p>
                                        <p class="lrn-report-summary">Hover over items to see the fine grain score break-down.</p>
                                        <p class="lrn-report-summary">Names and scores can trigger onClick events to tie into other reports.</p>
                                        <span class="learnosity-report" id="report-7"></span>
                                    </section>
                                    <div id="lrn-report-lastscore-item-events"></div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-no-border">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-lastscore-tag" data-toggle="collapse" data-parent="#lrn-reports-demos-lastscore-content" href="#lastscore-tag">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Last Score By Tag By User</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Obtain the latest activity score with a break-down of its constituent tags</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="lastscore-tag" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Last Score by Tag by User</h3>
                                        <p class="lrn-report-summary">Obtain the latest activity score with a break-down of scores according its constituent tags.  </p>
                                        <p class="lrn-report-summary">Hover over the tag scores to see the fine grain score break-down.</p>
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
                <div class="panel-body no-padding-bottom">
                    <div class="panel-group" id="lrn-reports-demos-progress-content">

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-progress-by-tag-table" data-toggle="collapse" data-parent="#lrn-reports-demos-progress-content" href="#progress-by-tag-table">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Progress By Tag Table</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Gather insight into user progress by  assigned tag hierarchy</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="progress-by-tag-table" class="panel-collapse collapse in">
                                <div class="panel-body">
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

                        <div class="panel panel-default panel-no-border">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                <a id="report-progress-single" data-toggle="collapse" data-parent="#lrn-reports-demos-progress-content" href="#progress-single">
                                    <div class="row">
                                        <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Progress Single</div>
                                        <div class="col-sm-8">
                                            <p class="lrn-report-summary">Single insight reports (designed to be embedded within content pages)</p>
                                        </div>
                                    </div>
                                </a>
                                </h4>
                            </div>
                            <div id="progress-single" class="panel-collapse collapse">
                                <div class="panel-body">
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
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a id="accordion-report-aggregate" data-toggle="collapse" data-parent="#lrn-reports-demos-accordion" href="#lrn-reports-demos-aggregate">
                        Reports By District, School, Class or Cohort
                    </a>
                </h4>
            </div>
            <div id="lrn-reports-demos-aggregate" class="panel-collapse collapse">
                <div class="panel-body no-padding-bottom">
                    <div class="panel-group" id="lrn-reports-demos-aggregate-content">

                        <div class="panel panel-default panel-border-bottom">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-aggregate-all" data-toggle="collapse" data-parent="#lrn-reports-demos-aggregate-content" href="#aggregate-reports">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span>Aggregate Reports</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Analyse aggregate results for large cohorts; drill down to classes and individuals</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="aggregate-reports" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <section>
                                        <h3 class="report-title">Aggregate Reports</h3>
                                        <p class="lrn-report-summary">Calculate the average score, median, minumum/maximum, standard deviation, percentiles and other statistics for custom groupings of users. Summarise, drill down, explore and compare results across regions, schools, classes, departments, age group, and any other arbitrary cohort.</p>
                                        <p>Two variants are available depending on how data should be selected:
                                            <ul>
                                                <li>Activity Summary by Group: compare results for users attempting one or more common learning activities</li>
                                                <li>Sessions Summary by Group: compare results for users across a specific set of assessment sessions</li>
                                            </ul>
                                        </p>
                                        <div class="alert alert-info">
                                            <strong>Note:</strong> Aggregate reports are prepared asynchronously in advance using Data API. See the <a href="//docs.learnosity.com/analytics/reports/aggregatereports/implementationguide">implementation guide</a> for details.
                                        </div>
                                        <span class="learnosity-report" id="activity-summary-by-group-report"></span>
                                        <div>Access <a onclick="showGroupReportData();">raw data</a> for the rendered report too.</div>
                                    </section>
                                </div>
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
                <div class="panel-body no-padding-bottom">
                    <div class="panel-group" id="lrn-reports-demos-live-content">

                        <div class="panel panel-default panel-no-border">
                            <div class="panel-heading inner-heading">
                                <h4 class="panel-title">
                                    <a id="report-live-progress" data-toggle="collapse" data-parent="#lrn-reports-demos-live-content" href="#live-progress">
                                        <div class="row">
                                            <div class="col-sm-4"><span class="glyphicon glyphicon-chevron-down"> </span> Live Progress Tracking</div>
                                            <div class="col-sm-8">
                                                <p class="lrn-report-summary">Displays a real-time report of students status for an activity.</p>
                                            </div>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div id="live-progress" class="panel-collapse collapse in">
                                <div class="panel-body">
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
                                        <p>Review the <a href="https://docs.learnosity.com/analytics/reports/reporttypes#liveActivityStatusByUser">documentation here</a>.</p>
                                    </section>
                                </div>
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

    var showGroupReportData = function() {
        var reportObj = lrnReports.getReport('activity-summary-by-group-report');
        reportObj.getGroup({path:reportObj.getCurrentGroupPath()}, function(groupData) {
            modal = $('.modal-content');
            var html = '';
                html += '<div class="modal-header">';
                html += '    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                html += '    <h4 class="modal-title" id="lrn-reports-demos-modal-label">Aggregate Reports - Raw Data</h4>';
                html += '</div>';
                html += '<div id="lrn-reports-demos-modal-content" class="modal-body">';
                html += '    <div class="alert alert-info">';
                html += '        <pre>' + JSON.stringify(groupData, null, 2) + '</pre>';
                html += '    </div>';
                html += '<div class="modal-footer">';
                html += '    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                html += '</div>';

            modal.html(html);
            $('#lrn-reports-demos-modal').modal();

            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
                $('.modal-content').html("");
            });
        });
    };

    // Array of ColumnDefinition objects we can pass to activitySummaryByGroup.setOptions({columns: ...}), eg.
    //   [
    //     {
    //         "type" => "group_name",
    //     },
    //     {
    //         "type" => "numeric",
    //         "field" => "population",
    //         "label" => "Students"
    //     },
    //     {
    //         "type" => "numeric",
    //         "field" => "lowest_percent",
    //         "label" => "Lowest score %"
    //     },
    //     ...
    //   ]
    var activitySummaryByGroupColumns = <?php echo json_encode($activitySummaryByGroupColumns, JSON_PRETTY_PRINT); ?>;

    // Map of user_id: user_name, eg.
    //   {
    //      "a3bcada4-0730-4d41-a661-6645088e765e": "Bart Simpson",
    //      "c1a4d492-4de7-45d5-b071-f80d80698b57": "Milhouse Vanhouten",
    //      "1896991f-e6a3-4cfb-b5c9-b44ec57f6c0e": "Nelson Muntz",
    //      ...
    //   }
    var usersMap = <?php echo json_encode($usersMap, JSON_PRETTY_PRINT); ?>;
    function mapUserId(userId) {
        return usersMap[userId];
    }

    // Change the header of the group_name to reflect the current level in the group hiererchy.
    function updateGroupReportHeaders(reportObj, rawJson) {
        var levelLabels = {
            0: "District",
            1: "School",
            2: "Class"
        };
        var currentPath = reportObj.getCurrentGroupPath() || {};
        var currentLevel = currentPath.length;
        var columnDefs = activitySummaryByGroupColumns;
        columnDefs[0] = {
            type: "group_name",
            label: levelLabels[currentLevel] || "Group Name",
        };
        reportObj.setOptions({columns: columnDefs});
    };

    // Scrape the DOM and replace user_ids with real user names.
    function remapUserIDs(reportObj, rawJson) {
        // Get the first field cell for each row (assume group_name is first column).
        var cells = document.querySelectorAll('.learnosity-report.activity-summary-by-group .lrn-table-row > :first-child .lrn-report-field');
        cells.forEach(function(cell) {
            cell.innerHTML = mapUserId(cell.innerText.trim()) || cell.innerHTML;
        });
    }

    // Called each time the activity-summary-by-group is navigated, to manually override/remap certain labels.
    function enhanceGroupReportUI(reportObj, rawJson) {
        updateGroupReportHeaders(reportObj, rawJson);

        // If we're viewing user rows, render real user names in place of user_ids.
        if (rawJson && rawJson.users) {
            setTimeout(function() {
                remapUserIDs(reportObj, rawJson);
            }, 0); // Wait til after the DOM is rendered before remapping.
        }
    };

    function onReportsReady() {
        var onClickFunction = function(data, target, modal) {
            if (modal) {
                var sessionReports = ['sessions-summary', 'session-detail-by-question', 'sessions-summary-by-tag'];
                var reportType = sessionReports[Math.floor(Math.random() * sessionReports.length)];

                $('#lrn-reports-demos-modal').modal({
                    'remote': 'demo-request.php'
                    + '?session_id=' + data.session_id
                    + '&user_id=' + data.user_id
                    + '&activity_id=' + data.activity_id
                    + '&report=' + reportType
                    + '&context=modal'
                });

                $('body').on('hidden.bs.modal', '.modal', function () {
                    $(this).removeData('bs.modal');
                    $('.modal-content').html("");
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

        /* sessions-list onclick events */
        var sessionsListByItem = lrnReports.getReport('report-22');
            sessionsListByItem.on('click:user', function (data) {
            onClickFunction(data, 'lrn-report-sessions-list-by-item-events', false);
        });

        // Aggregate report events
        var activitySummaryByGroup = lrnReports.getReport('activity-summary-by-group-report');
        activitySummaryByGroup.on('change:data', function (eventData) {
            enhanceGroupReportUI(activitySummaryByGroup, eventData.dataset_group);
        });
        enhanceGroupReportUI(activitySummaryByGroup);

        // Sessions detail hidden width fix
        $('a#report-session-detail').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            $('.lrn_response_innerbody').width('100%');
            $('.lrn_graph_plotter .lrn_btn').click();
        });



        // lastscore-single hidden width fix
        // $('a#report-lastscore-single').click(function (e) {
        //     e.preventDefault();
        //     $(this).tab('show');
        //     $('.lastscore-single canvas').each(function () {
        //         var size = $(this).parent().width();
        //         $(this).width(size);
        //         $(this).height(size);
        //     });
        // });

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
