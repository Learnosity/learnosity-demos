<?php

include_once '../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp,
    "user_id"      => $studentid
);

$RequestHelper = new RequestHelper(
    'questions',
    $security,
    $consumer_secret
);

$activitySignature = $RequestHelper->getSignature();

$uniqueResponseIdSuffix = UUID::generateUuid();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$signedRequest = '{
    "consumer_key": "'.$consumer_key.'",
    "timestamp": "' . $timestamp . '",
    "signature": "'.$activitySignature.'",
    "user_id": "'.$studentid.'",
    "type": "local_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "questions": [
        {
            "type": "formula",
            "response_id": "demoformula1_'.$uniqueResponseIdSuffix.'",
            "description": "Enter a math formula."
        },

        {
            "type": "formula",
            "response_id": "demoformula2_'.$uniqueResponseIdSuffix.'",
            "description": "Enter any expression that evaluates to x.",
            "instant_feedback" : true,
            "validation": {
                "valid_responses" : [
                    [{ "method": "equivSymbolic", "value": "x" }]
                ]
            }
        },

        {
            "type": "formula",
            "response_id": "demoformula3_'.$uniqueResponseIdSuffix.'",
            "description": "Complete the quadratic equation.",
            "template": "\\\\frac{-b\\\\pm\\\\sqrt{b^2-4ac}}{{{response}}}"
        },

        {
            "type": "formula",
            "response_id": "demoformula4_'.$uniqueResponseIdSuffix.'",
            "description": "Enter some symbols using the custom math toolbar.",
            "symbols": [{
                "symbol": "\\\\Sigma",
                "group": 1,
                "title": "My custom title for uppercase sigma"
            }, {
                "symbol": "\\\\sigma",
                "group": 1,
                "title": "My custom title for lowercase sigma"
            }, {
                "symbol": "\\\\sqrt",
                "group": 2
            }, {
                "symbol": "\\\\frac",
                "group": 2
            }, {
                "symbol": "^",
                "group": 2
            }, {
                "symbol": "\\\\cap",
                "group": 3
            }, , {
                "symbol": "\\\\cup",
                "group": 3
            }, , {
                "symbol": "\\\\subset",
                "group": 3
            }, , {
                "symbol": "\\\\supset",
                "group": 3
            }, {
                "symbol": "\\\\in",
                "group": 3
            }, {
                "symbol": "\\\\ni",
                "group": 3
            }]
        }
    ]
}';

?>

<div class="jumbotron">
    <h1>Questions API - Formula question type</h1>
    <p>One of the many question types provided by the Learnosity <b>Questions API</b>. The formula question type allows for easy input of complex math or scientific expressions, with powerful validation capabilities for authors.<p>
    <p>Input is captured in the popular <a href="http://www.latex-project.org/">LaTeX format</a>. Try entering some maths below to see the resulting LaTeX output.</p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/responsetypes.php#formula" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="./graphplotting.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<script src="//questions.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;

    // Initialise the Questions API.
    // The second argument is an options object with a readyListener callback function.
    var app = LearnosityApp.init(activity, {
        readyListener: function () {
            // Now the questions have been rendered: start polling them for updates.
            window.setInterval(function () {
                var responses = app.getResponses();
                $.each(responses, function (responseId, response) {
                    // Update latex in the code block to the right of the question.
                    var codeEl = $('#' + responseId).closest('.question').find('.formula-latex code');
                    if (codeEl.text() !== response.value) {
                        codeEl.text(response.value);
                    }
                });
            }, 250);
        }
    });
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Demos</h2>

<p>1. Basic question</p>
<div class="question">
    <div class="formula-latex"><h4>LaTeX output</h4><code>&nbsp;</code></div>
    <span class="learnosity-response question-demoformula1_<?php echo $uniqueResponseIdSuffix ?>"></span>
</div>
<hr />

<p>2. Validation: enter any mathematical expression equivalent to <strong>x</strong> and check your answer.
<small>e.g. <strong>2x - x</strong></small>
</p>
<div class="question">
    <div class="formula-latex"><h4>LaTeX output</h4><code>&nbsp;</code></div>
    <span class="learnosity-response question-demoformula2_<?php echo $uniqueResponseIdSuffix ?>"></span>
</div>
<hr />

<p>3. Response positions: enter the symbol to complete the quadratic equation.</p>
<div class="question">
    <div class="formula-latex"><h4>LaTeX output</h4><code>&nbsp;</code></div>
    <span class="learnosity-response question-demoformula3_<?php echo $uniqueResponseIdSuffix ?>"></span>
</div>
<hr />

<p>3. Custom toolbar buttons</p>
<div class="question">
    <div class="formula-latex"><h4>LaTeX output</h4><code>&nbsp;</code></div>
    <span class="learnosity-response question-demoformula4_<?php echo $uniqueResponseIdSuffix ?>"></span>
</div>
<hr />

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
