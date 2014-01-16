<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron">
    <h1>Questions API</h1>
    <p>Rich Question types can be embedded on any page with the Learnosity <b>Questions API</b>. Every question is highly configurable to suit the assessment purpose, be it formative or summative.<p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="<?php echo $env['www'] ?>assessment/items/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Questions API Demos</h2>
            <p>Try one of the Demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Question Types Overview</h2>
                </div>
                <div class="panel-body">
                    <p>Rich Question Types can be embedded on any page with the Learnosity Questions API. Every question is highly configurable to suit the assessment purpose, be it formative or summative.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./questiontypes.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Features</h2>
                </div>
                <div class="panel-body">
                    <p>The Learnosity Questions API supports features, standalone utilities that are defined in the client's HTML. These are generally used as stimulus for questions.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./featuretypes.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Math Formula Question Type</h2>
                </div>
                <div class="panel-body">
                    <p>Painless input and validation for complex math expressions.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./formula.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Graph Plotting Question Type</h2>
                </div>
                <div class="panel-body">
                    <p>Draw points and/or lines on a Cartesian plane.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./graphplotting.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
    include_once 'includes/footer.php';
