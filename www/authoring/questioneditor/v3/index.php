<?php
include_once '../../../config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section">
        <div class="pull-right toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authoring/questioneditor/v3" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <h1>Question Editor API V3 (Beta)</h1>
        <div class="section-intro">
            <p>Our editor. Your item bank platform. Embed our Question Editor into your existing CMS to author rich question types
                directly in the system your content authors and SMEs already know.<p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Full examples</h2>
                    </div>
                    <div class="panel-body">
                        <p>Review full examples of the embeddable Question Editor API with a tile list view</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./main.php">Demo</a>
                        </p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Edit panel layout</h2>
                    </div>
                    <div class="panel-body">
                        <p>Customise the Question Editor edit panel's layout for each question type to suit your design needs.</p>

                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./editlayout.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Directly Edit a Question</h2>
                    </div>
                    <div class="panel-body">
                        <p>Setup the Question Editor to directly load a question, bypassing the question tiles screen.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./editquestion.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'includes/footer.php';
