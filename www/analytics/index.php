<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section index">
    <h1><img class="product-logo" src="/static/images/product-analytics-full.png" alt="Learnosity Analytics logo"></h1>
    <div class="section-intro">
        <p>Learnosity Analytics provides a suite of powerful tools, covering both embeddable, user-friendly reporting, perfectly suited for quickly building out your product, as well as granular back end data-centric functionality to power your own bespoke reporting needs.</p>
        <ul>
            <li><h4><a class="blue-chevron" href="#dashboard-reporting">Embedding dashboard-style Reporting</a></h4></li>
            <li><h4><a class="blue-chevron" href="#customizing-reporting">Customizing your reporting experience</a></h4></li>
            <li><h4><a class="blue-chevron" href="#data-reporting">Using granular, back-end data reporting</a></h4></li>
        </ul>
        </p>
    </div>

    <h3 id="dashboard-reporting">Embedding dashboard-style Reporting</h3>
    <p>Easily use Learnosity's Reports API to embed visual reports, ranging from student & classroom reporting to large-scale district reports!</p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Display Student-Centric Reports</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about individual students in an easy, in-depth fashion!</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./student-centric-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Present Classroom & Teacher-Centric Reports</h2>
                </div>
                <div class="panel-body">
                    <p>Monitor and compare your students at a glance.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./teacher-centric-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Show Coursework Progress</h2>
                </div>
                <div class="panel-body">
                    <p>Particularly suited for publishers or online book companion products, track student progress through all Item bank content.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./progress-centric-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Display Large-Scale Group/District Reports</h2>
                </div>
                <div class="panel-body">
                    <p>Discover large-scale group reporting and let Learnosity take care of the heavy lifting.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./group-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Response Analysis Reporting</h2>
                </div>
                <div class="panel-body">
                    <p>Summarize class responses at a glance. Group students based on their strengths and needs.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./response-analysis-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Analyze Learning Outcomes & Mastery</h2>
                </div>
                <div class="panel-body">
                    <p>Drill down deeper into student and class results broken down by topic areas or learning outcomes.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./outcomes-mastery-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Provide Live Progress Tracking & Control</h2>
                </div>
                <div class="panel-body">
                    <p>Allow your instructors to see student progress through tests in real-time, along with instructor and teacher control.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./live-progress-reporting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h3 id="customizing-reporting">Customizing your reporting experience</h3>
    <p></p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Disable Reporting UI to Work Directly with Data</h2>
                </div>
                <div class="panel-body">
                    <p>In some cases, you may want to use our in-browser reporting widget info, but your own skin and styling on top. Find out more about getting just the report info, and how you can use it!</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./no-ui-reports.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Use click events</h2>
                </div>
                <div class="panel-body">
                    <p>Bring our reports to life, by integrating click behavior and adding an extra depth to your reporting.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./reports-click-events.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <h3 id="data-reporting">Using granular, back-end data reporting</h3>

    <p></p>
    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">View Data API Examples</h2>
                </div>
                <div class="panel-body">
                    <p>Sometimes, you just need access to all the raw info you can handle! Using Learnosity's Data API, you can.</p>
                    <p class="text-right">
                        <a class="demo_link"  href="./data/index.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php';
