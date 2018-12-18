<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/questions/knowledgebase/customquestions" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Custom Questions</h1>
    <div class="section-intro">
        <p>Questions API's custom question type alows you to create your own questions, giving you full control over the rendering of the response area, the user interaction with the question, and the scoring of the response.<p>
        <p>Here you can find some custom question examples.</p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Custom Short Text</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates a simple and easy implementation of a custom question.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./custom_shorttext.php">Demo</a>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Custom Mathcore</h2>
                </div>
                <div class="panel-body">
                    <p>Demonstrates how to implement a Math Custom question using Learnosity Mathcore.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./custom_mathcore.php">Demo</a>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Custom Implementation</h2>
                </div>
                <div class="panel-body">
                    <p>Demostrates a custom implementation of the Short Text question type where you can rewrite the question JSON to define your own custom questions.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./custom.php">Demo</a>
                    </p>
                </div>
            </div>
        </div> 

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Custom Percentage Bar</h2>
                </div>
                <div class="panel-body">
                    <p>Demostrates the implementation of a Custom question with an interactive and more complex UI.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./custom_percentage_bar.php">Demo</a>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Custom Box Whisker</h2>
                </div>
                <div class="panel-body">
                    <p>Demostrates the implementation of a Custom question with an interactive and more complex UI.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./custom_box_whisker.php">Demo</a>
                    </p>
                </div>
            </div>
        </div> 

    </div>
</div>

<?php include_once 'includes/footer.php';
