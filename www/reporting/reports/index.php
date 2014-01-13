<?php

include_once '../../config.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

$security = array(
    "consumer_key" => 'yis0TYCu7U9V4o7M',
    "domain"       => $domain,
    "timestamp"    => $timestamp,
    "user_id"      => 'brianmoser'
);

$request = array(
    array(
        'id'          => 'report-1',
        'type'        => 'user-sessions-summary',
        'session_ids' => array(
            'AC023456-2C73-44DC-82DA28894FCBC3BF'
        )
    ),
    array(
        'id'         => 'report-2',
        'session_id' => 'B146BA2C-C2D0-4368-B90FFBA2B245F2BA',
        'type'       => 'user-session-detail'
    ),
    array(
        'id'        => 'report-3',
        'type'      => 'user-progress-by-tag',
        'hierarchy' => 'author'
    ),
    array(
        'id'        => 'report-4',
        'type'      => 'user-sessions-summary-by-tag',
        'ui'        => 'bar-chart',
        'hierarchy' => 'author',
        'session_ids' => array(
            'B146BA2C-C2D0-4368-B90FFBA2B245F2BA'
        )
    ),
    array(
        'id'    => 'report-5',
        'type'  => 'group-lastscore-by-activity',
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
        'id'    => 'report-6',
        'type'  => 'user-lastscore-by-activity',
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
        'id'    => 'report-7',
        'type'  => 'group-lastscore-by-item',
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
        'activity_id' => '52f5b81d-9270-914a-7094a1ada4d55e6e'
    ),
    array(
        'id'    => 'report-8',
        'type'  => 'group-lastscore-by-tag',
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
);

$RequestHelper = new RequestHelper(
    'reports',
    $security,
    '74c5fd430cf1242a527f6223aebd42d30464be22',
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
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
        <div class="col-md-2"> <p class='text-right'><a class="btn btn-primary btn-lg" href="../sso">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="slides-container">
    <div class="row">
        <div class="col-md-10 pull-right">
            <select id="report-selector">
                <option value="0">User Sessions Summary</option>
                <option value="1">User Session Detail</option>
                <option value="2">User Progress By Tag Table</option>
                <option value="3">User Sessions Summary By Tag Chart</option>
                <option value="4">Group Last Score By Activity</option>
                <option value="5">User Last Score By Activity</option>
                <option value="6">Group Last Score By Item</option>
                <option value="7">Group Last Score By Tag</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="reveal">
            <div class="slides">

                <!-- Containers for the reports api to load into -->
                <section>
                    <h3 class="report-title">User Sessions Summary</h3>
                    <span class="learnosity-report" id="report-1"></span>
                </section>

                <section>
                    <h3 class="report-title">User Session Detail</h3>
                    <span class="learnosity-report" id="report-2"></span>
                </section>

                <section>
                    <h3 class="report-title">User Progress By Tag Table</h3>
                    <span class="learnosity-report" id="report-3"></span>
                    <div class="alert alert-info">
                        <strong>Note:</strong> The progress data for the above report is updated every 5 minutes
                    </div>
                </section>

                <section>
                    <h3 class="report-title">User Sessions Summary By Tag Chart</h3>
                    <span class="learnosity-report" id="report-4"></span>
                </section>

                <section>
                    <h3 class="report-title">Group Last Score By Activity</h3>
                    <span class="learnosity-report" id="report-5"></span>
                </section>

                <section>
                    <h3 class="report-title">User Last Score By Activity</h3>
                    <span class="learnosity-report" id="report-6"></span>
                </section>

                <section>
                    <h3 class="report-title">Group Last Score By Item</h3>
                    <span class="learnosity-report" id="report-7"></span>
                </section>

                <section>
                    <h3 class="report-title">Group Last Score By Tag</h3>
                    <span class="learnosity-report" id="report-8"></span>
                </section>

            </div>
        </div>
    </div>
</div>

<script src="//reports.learnosity.com"></script>
<script src="/static/vendor/head.min.js"></script>
<script src="/static/vendor/reveal/reveal.js"></script>
<script>
    var config = <?php echo $signedRequest; ?>;
    LearnosityReports.init(config);

    $(function() {
        Reveal.initialize({
            progress: false,
            rollingLinks: false,
            transition: 'none',
            dependencies: [
                // Cross-browser shim that fully implements classList - https://github.com/eligrey/classList.js/
                { src: '/static/vendor/classList.js', condition: function() { return !document.body.classList; } },
            ]
        });
        $selector = $('#report-selector');
        Reveal.addEventListener('slidechanged', function(event) {
            $selector.val(event.indexh);
        });
        $selector.on('change', function (event) {
            Reveal.slide($(event.currentTarget).val());
        });
    });
</script>

<?php
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
