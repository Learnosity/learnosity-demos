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

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "local_practice",
    "state": "resume",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "questionsapi-demo-course",
    "questions": [
        {
            "is_math": true,
            "response_container": {
                "width": "125px"
            },
            "stimulus": "<p>Solve the equation \\\\(\\\\frac{1}{3}\\\\left(2n-\\\\frac{1}{4}\\\\right)=\\\\frac{7}{12}\\\\) for \\\\(n\\\\).</p>",
            "symbols": [
                {
                    "label": "\\\\text{Algebra}",
                    "title": "",
                    "value": [
                        "\\\\frac{}{}",
                        "\\\\pm",
                        "\\\\pi",
                        "",
                        "\\\\left(\\\\right)",
                        "\\\\left[\\\\right]",
                        "\\\\abs",
                        "",
                        "box_^",
                        "\\\\sqrt",
                        "\\\\sqrt[3]{}",
                        "",
                        "\\\\approx",
                        "<",
                        "\\\\le",
                        "",
                        "\\\\ne",
                        ">",
                        "\\\\ge",
                        ""
                    ]
                },
                {
                    "label": "\\\\text{Geometry}",
                    "title": "",
                    "value": [
                        "\\\\pi",
                        "\\\\parallel",
                        "\\\\perp",
                        "",
                        "\\\\overline",
                        "\\\\overrightarrow",
                        "\\\\overleftrightarrow",
                        "",
                        "\\\\angle",
                        "\\\\measuredangle",
                        "\\\\degree",
                        "",
                        "\\\\triangle",
                        "\\\\circledot",
                        "\\\\parallelogram",
                        "",
                        "\\\\sim",
                        "\\\\cong",
                        "",
                        ""
                    ]
                }
            ],
            "template": "n={{response}}",
            "text_blocks": [],
            "type": "formulaV2",
            "ui_style": {
                "transparent_background": true,
                "type": "floating-keyboard"
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        {
                            "method": "equivLiteral",
                            "options": {
                                "allowDecimal": false,
                                "inverseResult": false,
                                "allowThousandsSeparator": true,
                                "setThousandsSeparator": [
                                    ","
                                ],
                                "setDecimalSeparator": ".",
                                "ignoreOrder": false
                            },
                            "value": "n=1"
                        }
                    ]
                }
            },
            "showHints": false,
            "response_id": "2397fc24-5487-4f14-8f82-472d878ecb96_414bd09ef531447b0942fcf56c7a20cc"
        }
    ],
    "responses": {
        "2397fc24-5487-4f14-8f82-472d878ecb96_414bd09ef531447b0942fcf56c7a20cc": {
            "value": "n=\b786651\b\\\\times7777777\\\\ne99999999\\\\approx333\\\\left(999\\\\pm\\\\pi\\\\pi6666666\\\\left[3333366666669999999\\\\sqrt{<\\\\sqrt[3]{\\\\abs{56}\\\\pm}}\\\\right]\\\\right)^{\\\\frac{\\\\circledot773333\b5\\\\overrightarrow{\\\\overleftrightarrow{6666666666\\\\measuredangle333333\\\\degree\\\\overleftrightarrow{\\\\overrightarrow{\\\\circledot\\\\parallelogram\\\\cong\\\\pi\\\\pi\\\\pi\\\\pi\\\\pi666\\\\times\\\\times\\\\times\\\\times\\\\triangle\\\\triangle\\\\triangle\\\\triangle\\\\triangle\\\\triangle+++,.}}}}}{.32\\\\left(\\\\left[\\\\abs{\\\\sqrt{\\\\sqrt[3]{^}}}\\\\degree\\\\triangle\\\\pi\\\\parallel>698744\\\\perp<\\\\le\\\\right]\\\\right)}}\b",
            "type": "string",
            "apiVersion": "v2.72.0",
            "responses": [
                "\\\\sqrt[3]{^}"
            ]
        }
    }
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!-- Container for the questions api to load into -->
<script src="<?php echo $url_questions; ?>"></script>
<script>
    $(function(){
        var options = {
            readyListener: function () {
                console.log('READY');
            },
            errorListener: function (e) {
                console.log(e);
            }
        };
        window.questionsApp = LearnosityApp.init(<?php echo $signedRequest; ?>, options);
    });
</script>

<div class="section">
    <div class="row">
        <div class="col-md-8">
            <span class="learnosity-response question-2397fc24-5487-4f14-8f82-472d878ecb96_414bd09ef531447b0942fcf56c7a20cc"></span>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
