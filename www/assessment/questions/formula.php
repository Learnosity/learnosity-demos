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
            "type": "formulaV2",
            "response_id": "demoformula1_'.$uniqueResponseIdSuffix.'",
            "description": "Enter a math formula."
        },

        {
            "type": "formulaV2",
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
            "type": "formulaV2",
            "response_id": "demoformula3_'.$uniqueResponseIdSuffix.'",
            "description": "Complete the quadratic equation.",
            "template": "\\\\frac{-b\\\\pm\\\\sqrt{b^2-4ac}}{{{response}}}"
        },
        {
            "response_id": "demoformula4_'.$uniqueResponseIdSuffix.'",
            "symbols": [{
                "label": "\\\\Sigma",
                "title": "My Custom group",
                "value": ["\\\\Sigma", "\\\\sigma", "", "", "\\\\sqrt", "box_\\\\frac", "box_^2", "", "", "", "", "", "", "", "", "", "", "", "", ""]
            }],
            "type": "formulaV2",
            "ui_style": {
                "type": "floating-keyboard"
            }
        },
        {
            "type": "formulaV2",
            "response_id": "demoformula5_'.$uniqueResponseIdSuffix.'",
            "description": "Enter a math formula.",
            "symbols": ["handwriting", "basic", "qwerty"],
            "ui_style": {
                "type": "block-keyboard"
            }
        },
        {
            "type": "formulaV2",
            "response_id": "demoformula6_'.$uniqueResponseIdSuffix.'",
            "description": "Enter a math formula.",
            "ui_style": {
                "type": "fixed-handwriting-only"
            }
        },
        {
            "type": "formulaV2",
            "response_id": "demoformula7_'.$uniqueResponseIdSuffix.'",
            "description": "Enter a math formula.",
            "symbols": ["handwriting", "basic", "qwerty"],
            "ui_style": {
                "type": "block-keyboard"
            }
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

<script src="<?php echo $url_questions; ?>"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;

    // Initialise the Questions API.
    // The second argument is an options object with a readyListener callback function.
    var app = LearnosityApp.init(activity, {
        readyListener: function () {
            // For each formula question on this page...
            $('.question').each(function () {
                var responseId = $('.lrn_qr', this).prop('id');
                var question = app.question(responseId);
                var questionElement = this;

                // If there is a code element to display the latex math in.
                var code = $('.formula-latex code', this);

                // Register a callback to update the latex when the user input changes.
                question.on('change', function () {
                    code.text(question.getResponse().value);
                });

                // 'Show handwriting data' button.
                $('button.handwriting', this).on('click', function () {
                    // retrieve and stringify handwriting json.
                    var json = JSON.stringify(question.getHandwriting(), null, '    ');
                    var pre = $('pre.jsonexample', questionElement);

                    CodeMirror.runMode(json, {name: "javascript", json: true}, pre[0]);
                    pre.finish().slideToggle(50);

                    // Toggle button labels.
                    $('span', this).toggle();
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

    <p>4. Custom toolbar buttons</p>
    <div class="question">
        <div class="formula-latex"><h4>LaTeX output</h4><code>&nbsp;</code></div>
        <span class="learnosity-response question-demoformula4_<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
    <hr />

    <p>5. Basic handwriting input: try writing a math expression on the grid.</p>
    <div class="question">
        <span class="learnosity-response question-demoformula5_<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
    <hr />

    <p>6. Formula question with <em>fixed-handwriting-only</em> style.</p>
    <div class="question">
        <span class="learnosity-response question-demoformula6_<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
    <hr />

    <p>7. Access handwriting data using the <em>getHandwriting</em> public method.</p>
    <div class="question">
        <span class="learnosity-response question-demoformula7_<?php echo $uniqueResponseIdSuffix ?>"></span>
        <button class="handwriting btn btn-md btn-primary">
            <span>Show Handwriting Data</span>
            <span style="display:none;">Hide Handwriting Data</span>
        </button>
        <br>
        <pre class="cm-s-default jsonexample" style="max-width:800px;display:none;"></pre>
    </div>
    <hr />
</div>

<script src="<?php echo $env['www'] ?>static/js/codemirror.min.js"></script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
