<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron clearfix">
    <h1>Reports API</h1>
    <p>A cross domain embeddable service that allows content providers to easily render rich reports.<p>
    <p>Live Progress Tracking also gives administrators the power to control end users assessments in real
    time.</p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/reportsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-2">
            <p class='text-right'>
                <a class="btn btn-primary btn-lg" href="../data">
                    Next <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Reports API Demos</h2>
            <p>Try one of the demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Report Types</h2>
                </div>
                <div class="panel-body">
                    <p>See all of our powerful reports in action. Rendering aggregated summaries or review
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
                    <h2 class="panel-title">Live Progress Tracking</h2>
                </div>
                <div class="panel-body">
                    <p>An interactive demo, simulating 3 students taking a test with an administrator viewing their
                    progress in real time. Also shows the power of <em>control events</em>, the ability to control end users
                    assessments in real time.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./live_progress.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
