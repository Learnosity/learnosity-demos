<?php
include_once 'config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron">
    <h1 class="landing-heading">Learnosity API Demos</h1>
    <p>Welcome to the Learnosity API demos site. Here you can try out some of our products.</p>
    <p>You may also <a href="https://github.com/Learnosity/learnosity-demos/tree/master#getting-started">download the entire site</a>
    to see how you can integrate our services into your own technology stack,
    or <a href="https://github.com/Learnosity/learnosity-php-examples/tree/master">browse the code directly</a> on github.</p>
</div>

<div class="container">
    <div class="row landing">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Authoring</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><p><a href="<?php echo $env['www'] ?>authoring/questioneditor/index.php">Question Editor API</a></p>
                        <p>A fully featured Question and Feature creation tool, with an easy-to-use interface and a live preview and interaction panel,
                        allowing on-the-fly interactive creation and testing for Authors.</p></li>
                        <li><p><a href="<?php echo $env['www'] ?>authoring/author/index.php">Author API</a></p>
                        <p>Allows searching and integration of Learnosity powered content into your content management systems while still leveraging the
                        power of the learnosity author site for creation of rich items with a simple interface.</p></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Assessment</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><p><a href="<?php echo $env['www'] ?>assessment/questions/index.php">Questions API</a></p>
                        <p>Rich Question types can be embedded on any page with the Learnosity Questions API.</p></li>
                        <li><p><a href="<?php echo $env['www'] ?>assessment/items/index.php">Items API</a></p>
                        <p>Provides a simple way to access content from the Learnosity item bank.</p></li>
                        <li><p><a href="<?php echo $env['www'] ?>assessment/assess/index.php">Assess API</a></p>
                        <p>Configurable layouts, pause, fullscreen mode, simple assessment delivery to desktops and tablet devices.</p></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Reporting</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><p><a href="<?php echo $env['www'] ?>reporting/reports/index.php">Reports API</a></p>
                        <p>A service that allows content providers to easily render rich reports.</p></li>
                        <li><p><a href="<?php echo $env['www'] ?>reporting/data/index.php">Data API</a></p>
                        <p>A back office service that allows authenticated users to retrieve and store information from within the Learnosity Assessment platform.</p></li>
                        <li><p><a href="<?php echo $env['www'] ?>reporting/sso/index.php">Single Sign On API</a></p>
                        <p>Get quick access to the data using the Learnosity Dashboards.</p></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
