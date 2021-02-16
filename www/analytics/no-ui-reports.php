<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;

//display report or JSON data
$render = filter_input(INPUT_GET, 'render', FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => true], 'flags' => FILTER_NULL_ON_FAILURE]);

$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

//simple api request object for Reports API
$request = [
    'reports' => [
        [
            'id' => 'session-summary',
            'render' => $render,
            'type' => 'sessions-summary',
            'user_id' => '$ANONYMIZED_USER_ID',
            'session_ids' => [
                '02be514f-bb82-4b5e-af71-7538f07e90fa'
            ]
        ],
        [
            'id' => 'progress-by-tag',
            'render' => $render,
            'type' => 'sessions-summary-by-tag',
            'user_id' => '$ANONYMIZED_USER_ID',
            'hierarchy' => 'CCSS',
            'session_ids' => [
                '8f8490d9-5ef7-4c59-bcdc-44df24202a12'
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object">
                    <a href="#" data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a>
                </li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation">
                    <a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a>
                </li>
            </ul>
        </div>
        <div class="overview">
            <h2>Disable Reporting UI to Work Directly with Data</h2>
            <p>Turn off the default rendering and access the raw data to present reports any way you choose. Preview the
                <a href="#" data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object">initialization object</a> to see how to turn off rendering.</p>
            <p>View the page source to see how to use event listeners to access the raw data.</p>
            <span>Render visual reports</span>
            <div style="display=inline-block;" class="lrn-switch">
                <input id="render_toggle" type="checkbox" class="input" <?php if ($render) {
                    echo "checked";
                                                                        } ?>><span class="lrn-switch-trigger"></span>
            </div>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the reports api to load into -->
        <h4>Sessions Summary</h4>
        <div id="session-summary">
            <div class="previewWrapper preview">
                <pre><code></code></pre>
            </div>
        </div>

        <h4>Progress by Tag</h4>
        <div id="progress-by-tag">
            <div class="previewWrapper preview">
                <pre><code></code></pre>
            </div>
        </div>
    </div>

    <script src="<?php echo $url_reports; ?>"></script>
    <script>
        $('.lrn-switch').click(function () {
            window.location.href = "?render=" + !$('#render_toggle').prop('checked');
        });

        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                getReportData();
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var reportsApp = LearnosityReports.init(initializationObject, callbacks);

        function getReportData(reportId) {
            // Retrieve the report from the Reports API instance
            var sessionsReport = reportsApp.getReport('session-summary');
            var progressReport = reportsApp.getReport('progress-by-tag');

            // For each report:
            // set a listener on report data load, to access the raw data...
            sessionsReport.on('load:data', function (data) {
                // ..and display JSON in prettified form. Data can be used in many ways.
                // Ex: using another rendering library in a custom report or dashboard
                $('#session-summary').find('code').html(
                    prettyPrint.render(data)
                );
            });
            progressReport.on('load:data', function (data) {
                $('#progress-by-tag').find('code').html(
                    prettyPrint.render(data)
                );
            });
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
