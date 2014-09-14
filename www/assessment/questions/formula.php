<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => $studentid
);

$uniqueResponseIdSuffix = Uuid::generate();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
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
            }, {
                "symbol": "\\\\cup",
                "group": 3
            }, {
                "symbol": "\\\\subset",
                "group": 3
            }, {
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

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/responsetypes.php#formula" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Formula question type</h1>
    <p>One of the many question types provided by the Learnosity <b>Questions API</b>. The formula question type allows for easy input of complex math or scientific expressions, with powerful validation capabilities for authors.<p>
    <p>Input is captured in the popular <a href="http://www.latex-project.org/">LaTeX format</a>. Try entering some maths below to see the resulting LaTeX output.</p>
</div>

<script src="//questions.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;

    // Initialise the Questions API.
    // The second argument is an options object with a readyListener callback function.
    var app = LearnosityApp.init(activity, {
        readyListener: function () {
            // For each formula question on this page...
            $('.lrn_formula').each(function () {
                // Get the latex area code element beside the question, and the question object.
                var codeEl = $(this).closest('.question').find('.formula-latex code'),
                    responseId = $(this).prop('id'),
                    question = app.question(responseId);

                // Register a callback to update the latex when the user input changes.
                question.on('change', function () {
                    codeEl.text(question.getResponse().value);
                });
            });
        }
    });
</script>

<div class="section">
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
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
