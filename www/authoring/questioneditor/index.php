<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section">
        <div class="pull-right toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authoring/questioneditor" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <h1>Question Editor API - V3</h1>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Teacher Authoring</h2>
                    </div>
                    <div class="panel-body">
                        <p>For busy teachers you can create super stripped down question templates.</p>

                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./editteachermcq.php">MCQ</a>
                            <a class="btn btn-primary btn-md" href="./editteacherequation.php">Math</a>
                            <a class="btn btn-primary btn-md" href="./editteacherclozedd.php">Cloze D&amp;D</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Test Dynamic Content with Questions Editor</h2>
                    </div>
                    <div class="panel-body">
                        <p>An advanced example to show how Questions Editor dynamically generate the content for your question.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./algorithmicMath/demo.php">Demo (Algorithmic Math)</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Digital Asset Management</h2>
                    </div>
                    <div class="panel-body">
                        <p>The Question Editor can tie into any existing Digital Asset Management System you may have, or want to use.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./assetrequest.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Custom Question Editor Templates</h2>
                    </div>
                    <div class="panel-body">
                        <p>Create custom question type templates in the Question Editor.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./customeditor.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Simple Layouts</h2>
                    </div>
                    <div class="panel-body">
                        <p>Simple layouts for question types.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./simple.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once 'includes/footer.php';
