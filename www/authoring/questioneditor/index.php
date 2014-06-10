<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron">
    <h1>Questions Editor API</h1>
    <p>A fully featured Question and Feature creation tool, with an easy-to-use interface and a live preview and interaction panel, allowing on-the-fly interactive creation and testing for Authors.<p>

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
            <h2>Questions Editor API Demos</h2>
            <p>Try one of the Demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Standard</h2>
                </div>
                <div class="panel-body">
                    <p><strong>DRAFT - </strong>The Question Editor initialised with the standard defaults.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./standard.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Extended</h2>
                </div>
                <div class="panel-body">
                    <p><strong>DRAFT - </strong>The Question Editor can be extended to include your own custom question types and groupings in addition to the standard defaults.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./extended.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Bespoke</h2>
                </div>
                <div class="panel-body">
                    <p><strong>DRAFT - </strong>The Question Editor can be initialised with only your own custom question types and groupings.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./bespoke.php">Demo</a>
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
                    <p><strong>DRAFT - </strong>The old way of doing things.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./legacy.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once 'includes/footer.php';
