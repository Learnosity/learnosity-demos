<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$render = ($_GET['render'] === 'true') ? true : false;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'reports' => array(
        array(
            'id'          => 'session-summary',
            'render'      => $render,
            'type'        => 'session-summary',
            'user_id'     => 'brianmoser',
            'session_ids' => array(
                'AC023456-2C73-44DC-82DA28894FCBC3BF'
            )
        ),
        array(
            'id'        => 'progress-by-tag',
            'render'    => $render,
            'type'      => 'progress-by-tag',
            'user_id'   => 'brianmoser',
            'hierarchy' => 'author'
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
        <h1>Reports API – No UI</h1>
        <p>Turn off the default rendering and access the raw data to present reports any way you choose. Preview the
        <a href="#" data-toggle="modal" data-target="#initialisation-preview">initialisation object</a> to see how to turn off rendering.<p>
        <p>View the page source to see how to use event listeners to access the raw data.</p>
        <p><a href="./no-ui.php?render=<?php echo var_export(!$render, true) ?>">Toggle rendering</a> on or off to compare rendered reports with the raw data.</p>
    </div>
</div>

<div class="section">
    <h3>Brian Moser (brianmoser)</h3>
    <h4>Sessions Summary</h4>
    <div id="session-summary">
        <div class="previewWrapper preview"><pre><code></code></pre></div>
    </div>

    <h4>Progress by Tag</h4>
    <div id="progress-by-tag">
        <div class="previewWrapper preview"><pre><code></code></pre></div>
    </div>
</div>
<script src="//reports.learnosity.com"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        getReportData();
    }

    function getReportData (reportId) {
        // Retrieve the report from the Reports API instance
        var sessionsReport = reportsApp.getReport('session-summary'),
            progressReport = reportsApp.getReport('progress-by-tag');

        // Set a listener on load, to access the raw data
        sessionsReport.on('load:data', function (data) {
            // In this case we're just printing the data to the screen
            // You could do anything you want with it though
            $('#session-summary').find('code').html(
                prettyPrint.render(data)
            );
        });
        progressReport.on('load:data', function (data) {
            // In this case we're just printing the data to the screen
            // You could do anything you want with it though
            $('#progress-by-tag').find('code').html(
                prettyPrint.render(data)
            );
        });
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
