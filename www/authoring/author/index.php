<?php

include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Author API</h1>
    <div class="section-intro">
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
        <p>Content can be saved back to your Learnosity hosted item bank, or you can choose to save content locally.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item List</h2>
                </div>
                <div class="panel-body">
                    <p>The item list mode allows authors to search the Learnosity hosted item bank for existing items. From there
                    it can be configured to allows users to edit items, or just select them for activity creation.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item Edit</h2>
                </div>
                <div class="panel-body">
                    <p>The item edit mode enables professional authors (as well as teachers) to create and edit content. Items,
                    questions and features are saved to your Learnosity hosted item bank.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-edit.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item Edit – Templates</h2>
                </div>
                <div class="panel-body">
                    <p>A simple single column template that allows authors to add a single question.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./single-question.php">Demo</a>
                    </p>
                    <hr>
                    <p>A 2-column template (50%/50%) that allows a single feature in the left column, and a question in the right.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./feature-question.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item Edit – Events</h2>
                </div>
                <div class="panel-body">
                    <p>A demonstration of event binding with the <a href="http://docs.learnosity.com/authoring/author/publicmethods#on-events">'on' public method</a>.</p>
                    <p>You can prevent the default save event (back to Learnosity) to add custom workflow.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./events.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item List – Routing</h2>
                </div>
                <div class="panel-body">
                    <p>A demonstration that uses the <a href="http://docs.learnosity.com/authoring/author/publicmethods#on-events">&lsquo;navigate&rsquo; event</a> and the <a href="http://docs.learnosity.com/authoring/author/publicmethods#navigate">&lsquo;navigate&rsquo; public method</a> to enable linkable, bookmarkable, shareable URLs that allow navigation directly to locations within the app.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./routing.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php';
