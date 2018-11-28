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
        <p>Learnosity Analytics provides a suite of powerful tools, covering both embeddable, user friendly reporting, perfectly suited for quickly building out your product, as well as granular back end data-centric functionality to power your own bespoke reporting needs.</p>
        <ul>
            <li><h4><a href="#dashboard-reporting">Embedded dashboard-style Reporting</a></h4></li>
            <li><h4><a href="#customizing-reporting">Customizing your reporting experience</a></h4></li>
            <li><h4><a href="#data-reporting">Granular, back-end data reporting</a></h4></li>
        </ul>
        </ul>
        </p>
    </div>

    <p>


    <h3 id="dashboard-reporting"><a href="#dashboard-reporting">Embedded dashboard-style Reporting</a></h3>
    <p>Easily use Learnosity's Reports API to embed visual reports, ranging from student & classroom reporting to large scale district reports!</p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Student-Centric reporting</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about individual students in an easy, in-depth fashion!</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./student-centric-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
            <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Classroom & Teacher-Centric reporting</h2>
                </div>
                <div class="panel-body">
                    <p>Monitor and compare the progress of your students at a glance.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
            </div>
            <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Coursework Progress reporting</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about individual students in an easy, in-depth fashion!</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
            </div>
            <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Large-Scale cohort / district reporting</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about individual students in an easy, in-depth fashion!</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Live Progress Tracking & Control</h2>
                </div>
                <div class="panel-body">
                    <p></p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_live_progress.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Learning Outcomes & Mastery</h2>
                </div>
                <div class="panel-body">
                    <p></p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_live_progress.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h3 id="customizing-reporting"><a href="#customizing-reporting">Customizing your reporting experience</a></h3>
    <p></p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Disabling Reporting UI</h2>
                </div>
                <div class="panel-body">
                    <p>In some cases, you may want to use our in-browser reporting widget info, but your own skin and styling on top. Find out more about getting just the report info, and how you can use it!</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using click events</h2>
                </div>
                <div class="panel-body">
                    <p>Use click events in our visual </p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <h3 id="data-reporting"><a href="#data-reporting">Granular, back-end data reporting</a></h3>

    <p></p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Data API Examples</h2>
                </div>
                <div class="panel-body">
                    <p>Sometimes, you just need access to all the raw info you can handle! Using Learnosity's Data API, you can </p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./reportsapi_no_ui.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php';
