<?php

include_once '../../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp,
    'user_id'      => $studentid,
);

$sessionId = $_REQUEST['sessionId'];

$request = array(
    array(
        'id'        => 'report-distractor-demo',
        'session_id'  => $sessionId,
        'type'      => 'user-session-detail'
    )
);

$RequestHelper = new RequestHelper(
    'reports',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>
<link rel="stylesheet" href="demo.css">

<div class="jumbotron">
    <h1>Reports API – Distractor Rationale</h1>
    <p>Store distractor rationale in the Questions API metadata property to be rendered by the host
    environment for displaying to users via Reports API.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Items API Documentation
            </a></h4>
            <h4><a href="http://docs.learnosity.com/reportsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Reports API Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
    </div>
</div>

<div class="report-distractor-demo-layout">
    <span class="learnosity-report" id="report-distractor-demo"></span>
</div>

<p><a href="index.php" class="btn btn-default">Back to test</a></p>

<script src="//reports.learnosity.com"></script>
<script src="response-level-map.js"></script>

<script>
    var config = <?php echo $signedRequest; ?>;
    config.configuration = {
        questionsApiVersion: "v2"
    };

    var showDistractor = function (id, text) {
            var distractorId = 'distractor_' + id,
                $responseEl = $('#'+id),
                $el = $('#'+distractorId).length ? $('#' + distractorId) : $('<div class="distractor custom-msg" id="'+distractorId+'"><h3>Rationales</h3><div class="distractor-content"></div></div>').insertAfter($responseEl);
            $el.find('.distractor-content').append(text);
        },

        renderDistractor = function (questionsActivity) {

            var attemptedQuestions = questionsActivity.attemptedQuestions(),
                metadata = questionsActivity.getMetadata(),
                validQuestions = questionsActivity.validQuestions('detailedWithPartials');

            // loop through each metadata and decide which one to render
            $.each(metadata, function (id, qmeta) {
                if (attemptedQuestions.indexOf(id) > -1 && qmeta.distractor_rationale) {
                    if (validQuestions[id] && validQuestions[id].correct !== true) {
                        showDistractor(id, qmeta.distractor_rationale);
                    }
                }
            });
        },

        renderDistractorResponseLevel = function (questionsActivity) {

            var attemptedQuestions = questionsActivity.attemptedQuestions(),
                metadata = questionsActivity.getMetadata(),
                validQuestions = questionsActivity.validQuestions('detailedWithPartials'),
                questions = questionsActivity.getQuestions(),
                responses = questionsActivity.getResponses();

            // loop through each metadata and decide which one to render
            $.each(metadata, function (id, qmeta) {
                if (attemptedQuestions.indexOf(id) > -1 && qmeta.distractor_rationale_response_level && qmeta.distractor_rationale_response_level.length) {
                    if (validQuestions[id]) {
                        var map = mapResponseLevel(questions[id], responses[id], validQuestions[id]),
                            distractors_to_be_shown = [];

                            $.each(qmeta.distractor_rationale_response_level, function (index, d) {
                                if (map && (map[index] === false)) {
                                    distractors_to_be_shown.push(d);
                                }
                            }),
                            $text = $('<ul>');
                        if (distractors_to_be_shown.length) {
                            $.each(distractors_to_be_shown, function (index, d) {
                                $text.append('<li>' + d + '</li>');
                            });
                            showDistractor(id, $text[0].outerHTML);
                        }
                    }
                }
            });
        },

        renderUnattempts = function (questionsActivity) {

            var attemptedQuestions = questionsActivity.attemptedQuestions(),
                attemptedQuestionsSelector = $.map(attemptedQuestions, function (id) {
                    return '#' + id;
                }).join(","),
                $unattempts = $('#report-distractor-demo .lrn-report-response-container').filter(function () {
                    return $(this).find(attemptedQuestionsSelector).length === 0;
                });
            $unattempts.append('<div class="alert alert-warning unattempts custom-msg">Not attempted</div>');
        },

        questionsApiReady = function (questionsActivity) {
            renderDistractor(questionsActivity);
            renderDistractorResponseLevel(questionsActivity);
            renderUnattempts(questionsActivity);
        },

        ReportAPI = LearnosityReports.init(config, {
            readyListener: function () {
                reportObject = ReportAPI.getReport('report-distractor-demo');
                reportObject.on("report:questionsApiReady", questionsApiReady);
            }
        });
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
