<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron">
    <h1>Data API</h1>
    <p>A back office service that allows authenticated users to retrieve and store information from within the
    Learnosity platform. Only authenticated users can access information, over SSL.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/dataapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"> <p class='text-right'><a class="btn btn-primary btn-lg" href="../../misc/security_check.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Data API Demos</h2>
            <p>Try one of the Demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Users</h2>
                </div>
                <div class="panel-body">
                    <p>Read and write user data, in and out of the Learnosity Assessment platform.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./dataapi_users.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Schools</h2>
                </div>
                <div class="panel-body">
                    <p>Display items from the Learnosity Item Bank in no time with the Items API. The Items API builds on the Questions API's power and makes it quicker to integrate.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./itemsapi_inline.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Sessions</h2>
                </div>
                <div class="panel-body">
                    <p>Shows examples of using inline hints for questions.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./itemsapi_workedsolutions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
