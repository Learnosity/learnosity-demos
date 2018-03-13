<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$sessionId1 = Uuid::generate();
$sessionId2 = Uuid::generate();

$security = [
    'domain' => $_SERVER['SERVER_NAME'],
    'consumer_key' => $consumer_key,
];

$request1 = [
    'activity_id' => $sessionId1,
    'items' => ["Chapter 1-A Q1", "Chapter 1-A Q2"],
    'name' => 'Chapter 1-A',
    'type' => 'submit_practice',
    'rendering_type' => 'inline',
    'session_id' => $sessionId1,
    'user_id' => 'student_00012'
];
$Init1 = new Init('items', $security, $consumer_secret, $request1);
$signedRequest1 = $Init1->generate();

$request2 = [
    'activity_id' => $sessionId2,
    'items' => ["Chapter 1-B Q1", "Chapter 1-B Q2"],
    'name' => 'Chapter 1-B',
    'type' => 'submit_practice',
    'rendering_type' => 'inline',
    'session_id' => $sessionId2,
    'user_id' => 'student_00012'
];
$Init2 = new Init('items', $security, $consumer_secret, $request2);
$signedRequest2 = $Init2->generate();

?>
<style>

    .activity-container {
        display: none;
        padding: 5px;
        border: 1px solid;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        background-color: #f2f2f2;
    }

    .expandable-box.active {
        border-style: solid;
        border-top-left-radius: 5px;
        border-radius: 5px 5px 0px 0px;
        border-color: gray;
        border: 1px solid;
    }

    .expandable-box {
        border-style: solid;
        border-radius: 5px;
        border-color: gray;
        border: 1px solid;
        height: 50px;
        padding: 5px;
    }
    .expandable-box:hover {
        display: block;
        cursor: pointer;
        background-color: #fafafa;
    }

    .expandable-title {
        font-size: large;
        text-align: center;
    }


</style>
<div class="jumbotron section">
    <div class="overview">
        <h1>Items API – Inline</h1>
        <p>In this demo, we show how to embed multiple inline assessments on a single page.</p>
    </div>
</div>

<div class="section">
            <div>
                <div class="expandable-box" id="activity-1">
                <div class="expandable-title">
                    <span>Chapter 1-A: Addition</span>
                </div>
                </div>
                <div class="activity-container" id="activity-1-container">
                    <div class="question-label">
                        <span>Question 1</span>
                    </div>
                    <div class="question-container">
                        <span class="learnosity-item" data-reference="Chapter 1-A Q1"></span>
                    </div>
                    <div class="question-label">
                        <span>Question 2</span>
                    </div>
                    <div class="question-container">
                        <span class="learnosity-item" data-reference="Chapter 1-A Q2"></span>
                    </div>
                    <button class="btn submit-button" id="chapter-1-a-submit-button">Submit</button>
                </div>
            </div>
            <hr>
            <div>
                <div class="expandable-box" id="activity-2">
                <div class="expandable-title">
                    <span>Chapter 1-B: Subraction</span>
                </div>
                </div>
                <div class="activity-container" id="activity-2-container">
                    <div class="question-label">
                        <span>Question 1</span>
                    </div>
                    <div class="question-container">
                        <span class="learnosity-item" data-reference="Chapter 1-B Q1"></span>
                    </div>
                    <div class="question-label">
                        <span>Question 2</span>
                    </div>
                    <div class="question-container">
                        <span class="learnosity-item" data-reference="Chapter 1-B Q2"></span>
                    </div>
                    <button class="btn submit-button" id="chapter-1-b-submit-button">Submit</button>
                </div>
            </div>
            <hr>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var events = {
        readyListener: function () {
            console.log("readyListener");
        },
        errorListener: function () {
            console.log("errorListener");
        }
    };

    var itemsApp1 = LearnosityItems.init(<?php echo $signedRequest1; ?>, events);
    var itemsApp2 = LearnosityItems.init(<?php echo $signedRequest2; ?>, events);

    $('.submit-button').click(
        function () {
            var button = $(this);
            if (button.attr("id") == "chapter-1-a-submit-button") {
                itemsApp1.submit();
            }
            else if (button.attr("id") == "chapter-1-b-submit-button") {
                itemsApp2.submit();
            }
        }
    );

    $('.expandable-box').click(
        function () {
            var expand = $(this);
            if (expand.attr("id") == "activity-1") {
                toggleVisibility("activity-1-container");
                expand.toggleClass("active");
            }
            else if (expand.attr("id") == "activity-2") {
                toggleVisibility("activity-2-container");
                expand.toggleClass("active");
            }
        }
    );


    function toggleVisibility(id) {
        $('#' + id).toggle();

    }

</script>

<?php
include_once 'includes/footer.php';

?>
