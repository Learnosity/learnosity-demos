<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/analytics/reports" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Reports API</h1>
    <div class="section-intro">
        <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
        <p>Live Progress Tracking also gives administrators the power to control end users assessments in real time.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Report Types</h2>
                </div>
                <div class="panel-body">
                    <p>See all of our powerful reports in action.</p>
                    <p>Rendering aggregated summaries or review
                    modes from students assessments.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./report_types.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">No UI (Raw data only)</h2>
                </div>
                <div class="panel-body">
                    <p>Gain access to the raw data from the Learnosity platform by turning
                    off the report rendering (ui).</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./no-ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Learning Outcomes Reporting - Individual results</h2>
                </div>
                <div class="panel-body">
                    <p>Interactive drill down report for analyzing an individual's results by topic area or learning outcome. Useful for formative/summative, diagnostic reporting and feedback.</p>
                    <p><strong>Note:</strong> learning outcomes reporting is a premium bundle add-on.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./learning_outcomes_individuals.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Learning Outcomes Reporting - Analyzing class results</h2>
                </div>
                <div class="panel-body">
                    <p>Interactive drill down report of class results by topic area or learning outcome. Useful for formative/summative, diagnostic reporting and feedback.</p>
                    <p><strong>Note:</strong> learning outcomes reporting is a premium bundle add-on.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./learning_outcomes_classes.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Learning Outcomes Reporting - Visualization and customization</h2>
                </div>
                <div class="panel-body">
                    <p>Advanced example of visualizing class results using learning outcomes reporting.</p>
                    <p><strong>Note:</strong> learning outcomes reporting is a premium bundle add-on.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./learning_outcomes_visualization.php">Demo</a>
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
                    <p>An interactive demo, simulating 3 students taking a test with an administrator viewing their
                    progress in real time. Also shows the power of <em>control events</em>, which can be used to remote control an end user's
                    assessment in real time.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./live_progress.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
