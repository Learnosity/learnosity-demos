<?php include_once '../src/includes/header.php'; ?>

<div class="jumbotron">
    <h1>Learnosity API Demos</h1>
    <p>Welcome to the Learnosity API demos site. Here you can try out some of our services.</p>
    <p>You may also <a href="https://github.com/Learnosity/learnosity-php-examples/archive/master.zip">download the entire site</a>
    to see how you can integrate our services into your own technology stack,
    or <a href="https://github.com/Learnosity/learnosity-php-examples">browse the code directly</a> on github.</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>What do I do?</h2>
            <p>Use the top navigation, or the list below, to try out any or all of the available demos:</p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Assessment</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><a href="/assessment/questions">Questions API</a></li>
                        <li><a href="/assessment/items">Items API</a></li>
                        <li><a href="/assessment/assess">Assess API</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Authoring</h2>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><a href="/authoring/author">Author API</a></li>
                        <li><a href="/authoring/questioneditor">Question Editor API</a></li>
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
                        <li><a href="/reporting/reports">Reports API</a></li>
                        <li><a href="/reporting/sso">Single Sign On API</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../src/includes/footer.php';
