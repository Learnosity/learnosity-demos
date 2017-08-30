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

$request = '{
    "type": "local_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "beta_flags": {
        "reactive_views": true
    },
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
            "type": "formulaessay",
            "response_id": "demoformula8_'.$uniqueResponseIdSuffix.'",
            "is_math": true,
            "stimulus": "Prove by induction that \\\\(1 + 2 + 4 + 8 + \\\\dots + 2n-1 = 2n - 1 \\\\)"
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
            });
        }
    });

    function injectCodeMirrorCss() {
        var $head = $('head');
        var $codeMirrorCss = $head.find('link[href=\'../../static/vendor/codemirror/codemirror.css\']');

        if ($codeMirrorCss.length) {
            return;
        }

        var $headlinklast = $head.find('link[rel=\'stylesheet\']:last');
        var linkElement = '<link rel=\'stylesheet\' href=\'../../static/vendor/codemirror/codemirror.css\' type=\'text/css\' media=\'screen\'>';
        if ($headlinklast.length){
           $headlinklast.after(linkElement);
        }
        else {
           $head.append(linkElement);
        }
    }
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

    <p>5. Formula essay question type. <small>Each line of input is either math or text.</small></p>
    <div class="question">
        <span class="learnosity-response question-demoformula8_<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
    <hr />
</div>

<script src="<?php echo $env['www'] ?>static/js/codemirror.min.js"></script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
