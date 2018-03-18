<?php

include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
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
                    <p>Demonstrates use of Author API to create content (new items), Items API to assess and Reports API to show the result, including a custom question option.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./authoring.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/footer.php';
