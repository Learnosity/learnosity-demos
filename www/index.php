<?php
include_once 'config.php';
include_once 'includes/header.php';
?>

<div class="landing section">
    <div class="jumbotron">
        <h1 class="landing-heading">Learnosity Demos</h1>
        <div class="landing-intro">
            <div class="media">
                <div class="pull-left">
                    <span class="glyphicon glyphicon-question-sign"></span>
                </div>
                <div class="media-body">
                    <p>This site contains demonstrations for all Learnosity APIs. Most of them are interactive, allowing you to get
                the feel of our products with real content.</p>
                </div>
            </div>

            <div class="media">
                <div class="pull-left">
                    <span class="glyphicon glyphicon-cloud-download"></span>
                </div>
                <div class="media-body">
                    <p>You may also download the entire site to see how you can easily integrate our services into your own technology stack,
                    or you can <a href="https://github.com/Learnosity/learnosity-demos/tree/master">browse the code directly</a> on github.</p>
                </div>
            </div>

             <div class="media">
                <div class="pull-left">
                    <span class="glyphicon glyphicon-info-sign"></span>
                </div>
                <div class="media-body">
                    <p>Although the site has been written in PHP, the format is simple enough to follow no matter what your preferred language might be.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row landing-panel">
        <div class="col-md-3 landing-panel-heading">
            <h3>Authoring</h3>
        </div>
        <div class="col-md-8 content-panel">
            <ul class="list-unstyled">
                <li><h4><a href="<?php echo $env['www'] ?>authoring/author/index.php">Author API</a>
                <span class="label label-info">Start here!</span></h4>
                <p>Allows searching and integration of Learnosity powered content into your content management systems, while still leveraging the
                power of the Learnosity Author site for creation of rich items with a simple interface.</p></li>
                <li><h4><a href="<?php echo $env['www'] ?>authoring/questioneditor/index.php">Question Editor API</a></h4>
                <p>A fully featured Question and Feature creation tool, with an easy-to-use interface and a live preview and interaction panel,
                allowing on-the-fly interactive creation and testing for Authors.</p></li>
            </ul>
        </div>
    </div>

    <div class="row landing-panel">
        <div class="col-md-3 landing-panel-heading">
            <h3>Assessment</h3>
        </div>
        <div class="col-md-8 content-panel">
            <ul class="list-unstyled">

                <li><h4><a href="<?php echo $env['www'] ?>assessment/items/index.php">Items API</a>
                <span class="label label-info">Start here!</span></h4>
                <p>Provides a simple way to access content from the Learnosity item bank. Also includes a powerful
                adaptive engine for fine grained assessment control.</p></li>

                <li><h4><a href="<?php echo $env['www'] ?>assessment/questions/index.php">Questions API</a></h4>
                <p>Rich Question and Feature types can be embedded on any page with the Learnosity Questions API.</p></li>

                <li><h4><a href="<?php echo $env['www'] ?>assessment/assess/index.php">Assess API</a></h4>
                <p>Configurable layouts and assessment controls including pause, fullscreen mode,
                navigation and many more. Provides simple assessment delivery to desktops and tablet devices.</p></li>
            </ul>
        </div>
    </div>

    <div class="row landing-panel">
        <div class="col-md-3 landing-panel-heading">
            <h3>Analytics</h3>
        </div>
        <div class="col-md-8 content-panel">
            <ul class="list-unstyled">
                <li><h4><a href="<?php echo $env['www'] ?>analytics/reports/index.php">Reports API</a></h4>
                <p>Allows rendering of rich reports on any page. Includes a live progress report with control
                events, to remotely control any assessment in real time.</p></li>
                <li><h4><a href="<?php echo $env['www'] ?>analytics/data/index.php">Data API</a></h4>
                <p>A back office service that allows authenticated users to retrieve and store information from within the Learnosity Assessment platform.</p></li>
            </ul>
        </div>
    </div>
</div>

<?php
    include_once 'includes/footer.php';
