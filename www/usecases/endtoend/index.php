<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';
?>

<div class="jumbotron section index">
    <h1>End to End Demo</h1>
    <div class="section-intro">
        <p>This is an End to End demo covering the main areas of Learnosity APIs.<p>
        <p>Starting with <strong>Authoring</strong> questions to turn them into an <strong>Assessment</strong> and finally <strong>Reporting</strong> to review the results and provide feedback.</p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">End to End (Add items)</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates use of Author API to create content (new items), Items API to assess and Reports API to show the result and feedback.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./authoring.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">End to End (Select existing items)</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates use of Author API to create content (new items <i>or</i> select existing items), Items API to assess and Reports API to show the result and feedback.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./select_items.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/footer.php';
