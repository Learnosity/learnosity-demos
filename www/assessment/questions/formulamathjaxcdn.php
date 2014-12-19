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
            "description": "Enter 1",
            "is_math": true,
            "stimulus": "<p>\\\\(\\\\frac{3}{4}\\\\sqrt{4}\\\\)</p>\n",
            "text_blocks": [],
            "ui_style": {
                "type": "block-keyboard"
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [{
                        "method": "equivSymbolic",
                        "options": {
                            "allowDecimal": false,
                            "inverseResult": false
                        },
                        "value": "1"
                    }]
                }
            }
        }
    ]
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>


<script src="//questions.vg.learnosity.com"></script>
<script>
    function loadLearnosity() {
        var activity = <?php echo $signedRequest; ?>;

        // Initialise the Questions API.
        // The second argument is an options object with a readyListener callback function.
        var app = LearnosityApp.init(activity, {
            readyListener: function () {
                console.log('Learnosity app is ready');
            }
        });
    }
</script>
<script type="text/javascript"
    src="//cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML&delayStartupUntil=configured">
</script>
<script type="text/javascript">

    MathJax.Hub.Register.StartupHook("Begin Config", function () {

        // Set additional configuratons
        MathJax.Hub.Config({
            TeX: {
                extensions: ["autoload-all.js"],
                Macros: {
                    /*
                    Converting MathQuil's \abs to pipe TeX Command
                    http://www.onemathematicalcat.org/MathJaxDocumentation/TeXSyntax.htm#pipeSymbol
                     */
                    abs: ["{|#1|}", 1],
                    degree: ["{^\\circ}"],
                    longdiv: ["{\\enclose{longdiv}{#1}}", 1]
                }
            }
        });

        MathJax.Ajax.Require('[MathJax]/extensions/MathZoom.js', function () {
            (function () {
                if (MathJax.Extension.MathZoom.msieSizeBug) {
                    var originalZoom = MathJax.Extension.MathZoom.Zoom;
                    MathJax.Extension.MathZoom.Zoom = function () {
                        var functionReturn = originalZoom.apply(MathJax.Extension.MathZoom, arguments);
                        var zoomElm = document.getElementById('MathJax_Zoom');
                        // Luke: need to set height and width back to "auto" AFTER zoom calculates position for
                        // IE8 as this way the height of the span is properly set.
                        zoomElm.style.height = "auto";
                        zoomElm.style.width = "auto";
                        return functionReturn;
                    };
                }
            })();
        });

        // Signal MathJax to continue loading
        MathJax.Hub.Configured();

        MathJax.Hub.Register.StartupHook("End", function () {
            console.log('MathJax: startup process has completed, including the initial typesetting pass');
            loadLearnosity();
        });
    });
</script>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/responsetypes.php#formulaV2" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <!-- Main question content below here: -->
    <h2 class="page-heading">Loading MathJax from CDN</h2>
    <hr/>

    <div class="question" id="question">
        <span class="learnosity-response question-demoformula1_<?php echo $uniqueResponseIdSuffix ?>"></span>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
