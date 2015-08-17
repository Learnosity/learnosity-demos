<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);



require_once "functions.php";

// Handle load file request
if (isset($_POST['filePath'])) {
    echo file_get_contents($_REQUEST['filePath']);
    die;
}

// Handle get request (load page)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($sampleFileFolder)) {
        $jsonSampleFolder = 'jsonsamples';
        $qtiSampleFolder = 'qtisamples';
    }
    $jsonSampleFileList = readFilesIn($jsonSampleFolder, 'json');
    $qtiSampleFileList = readFilesIn($qtiSampleFolder, 'xml');
}

// Handle post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle `toqti` request
    if ($_GET['operation'] === 'toqti') {
        echo convertToQti(file_get_contents('php://input'));
        die;
    }
    if ($_GET['operation'] === 'fromqti') {
        echo convertToJson(file_get_contents("php://input"), $_GET['baseAssetsUrl']);
        die;
    }
}

?>
<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – xAPI Events</h1>
        <p>Preview xAPI (Experience API) events thrown by the Assess API. New events are prepended at the top of the box:</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
    </div>
</div>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
    <link rel="stylesheet" href="styles.css">

    <script src="http://underscorejs.org/underscore-min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//questions.learnosity.com/?latest"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/ace.js" type="text/javascript" charset="utf-8"></script>

    <div class="container">
        <div class="row">
            <h1>Learnosity QTI Demo</h1>
            <div style="float: right"><a target="_blank" href="documentation.html">View Documentation</a></div>
        </div>
        <div class="row">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#toQti" aria-controls="home" role="tab" data-toggle="tab">Learnosity to QTI</a></li>
                <li role="presentation"><a href="#toJson" aria-controls="profile" role="tab" data-toggle="tab">QTI to Learnosity</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="toQti">
                    <?php require_once "toqti.php"; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="toJson">
                    <?php require_once "tojson.php"; ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 40px">
            <hr>
        </div>
    </div>
