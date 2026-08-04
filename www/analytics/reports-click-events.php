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
                ['id' => '$ANONYMIZED_USER_ID_1', 'name' => 'Jesse Pinkman'],
                ['id' => '$ANONYMIZED_USER_ID_2', 'name' => 'Walter White'],
                ['id' => '$ANONYMIZED_USER_ID_3', 'name' => 'Saul Goodman']
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
                <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
                <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Use Click Events to Display Additional Information and Reports</h2>
            <p>Click events are events that are provided by certain reports, to provide mechanisms to bind to specific click events within the report. For more information about click events, and to see which reports they can be used in, please see our <a href="https://reference.learnosity.com/reports-api/events" target="_blank">documentation</a>.</p>
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
            var modalEl = document.getElementById('lrn-reports-demos-modal');
            async function loadRemoteContent (container, url) {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(url + ' responded ' + response.status);
                }
                container.innerHTML = await response.text();
                container.querySelectorAll('script').forEach(function (original) {
                    const script = document.createElement('script');
                    [...original.attributes].forEach(function (attr) {
                        script.setAttribute(attr.name, attr.value);
                    });
                    script.textContent = original.textContent;
                    original.replaceWith(script);
                });
            }

            // Clear the injected markup on close so the next click loads it fresh.
            modalEl.addEventListener('hidden.bs.modal', function () {
                modalEl.querySelector('.modal-content').innerHTML = '';
            });

            var onClickFunction = async function(data) {
                const url = 'reports-click-events-modal.php'
                    + '?session_id=' + data.session_id
                    + '&user_id=' + data.user_id
                    + '&activity_id=' + data.activity_id;
                try {
                    await loadRemoteContent(modalEl.querySelector('.modal-content'), url);
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                } catch (error) {
                    console.error(error);
                }
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
