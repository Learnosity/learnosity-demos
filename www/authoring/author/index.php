<?php

include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <h1>Author API</h1>
    <div class="section-intro">
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Latest</h2>
                </div>
                <div class="panel-body">
                    <p>An embedded API enabling content authors to create, edit and persist items, questions and features to our itembank.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./latest.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Legacy</h2>
                </div>
                <div class="panel-body">
                    <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
                    <p><em>Note:</em> This version is only supported to <a href="http://docs.learnosity.com/authorapi-v0.5/index.php">v0.5</a></p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./legacy.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
