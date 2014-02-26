<?php

include_once '../../config.php';
include_once 'includes/header.php';

$URL     = 'https://data.learnosity.com';
$version = 'v0.17';

?>

<div class="jumbotron">
    <h1>Data API</h1>
    <p>A back office service that allows authenticated users to retrieve and store information from
    within the Learnosity platform. Only authenticated users can access information, over SSL.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/dataapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-2"> <p class='text-right'><a class="btn btn-primary btn-lg" href="../../misc/security_check.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#users">
                    <span class="block">action: get</span>
                    <?php echo '/' . $version . '/users'; ?>
                </a>
            </h4>
        </div>
        <div id="users" class="panel-collapse collapse">
            <div class="panel-body">
                <?php include_once 'users/users.php'; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#usersactivities">
                    <span class="block">action: get</span>
                    <?php echo '/' . $version . '/users/activities'; ?>
                </a>
            </h4>
        </div>
        <div id="usersactivities" class="panel-collapse collapse">
            <div class="panel-body">
                <?php include_once 'users/activities.php'; ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#usersstatuses">
                    <span class="block">action: get</span>
                    <?php echo '/' . $version . '/users/statuses'; ?>
                </a>
            </h4>
        </div>
        <div id="usersstatuses" class="panel-collapse collapse">
            <div class="panel-body">
                <?php include_once 'users/statuses.php'; ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $env['www'] ?>static/vendor/ladda/spin.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/ladda/ladda.min.js"></script>
<script>
    var config = {
        www: '<?php echo $env["www"]; ?>'
    }
</script>

<script src="<?php echo $env['www'] ?>static/js/dataapi/formToObject.js"></script>
<script src="<?php echo $env['www'] ?>static/js/dataapi/dataApiRequest.js"></script>

<?php
    include_once 'includes/footer.php';
