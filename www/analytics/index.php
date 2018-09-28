<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Analytics</h1>
    <div class="section-intro">
        <p>Learnosity's Reports API provides a cross domain embeddable service that allows content providers to easily render rich reports.</p>
        <p>The Data API is a back office service that allows authenticated users to retrieve and store information from within the Learnosity Assessment platform.</p>
    </div>

    <h4><span class="badge btn-warning">Note</span> Placeholder landing page. Titles most of the way there; blurbs and links in progress</h4>
    <p>&nbsp;</p> <!--replace with CSS-->

    <h3>Reports API</h3>
    <p>&nbsp;</p> <!--replace with CSS-->


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">No UI (Raw data only)</h2>
                </div>
                <div class="panel-body">
                    <p>Gain access to the raw data from the Learnosity platform by turning off the report rendering (ui).</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Live Progress Tracking</h2>
                </div>
                <div class="panel-body">
                    <p>An interactive demo, simulating 3 students taking a test with an administrator viewing their progress in real time. Also shows the power of control events, which can be used to remote control an end user's assessment in real time.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_live_progress.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php';
