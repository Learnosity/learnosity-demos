<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


//simple api request object for Items API
$request = [
    'activity_id' => 'formulamathjax',
    'name' => 'Items API demo - formaula mathjax',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'demomathjaxformula_1'
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Use Your Existing MathJax Instance for Math Rendering</h2>
            <p>This demo demonstrates how to disable Learnosity's rendering and load your own MathJax CDN.</p>
        </div>
    </div>

    <div class="section pad-sml lrn">
        <!-- Container for the Items API assessment player to load into -->
        <span class="learnosity-item lrn" data-reference="demomathjaxformula_1"></span>
    </div>

    <script src="<?php echo $url_items; ?>"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-AMS-MML_HTMLorMML&delayStartupUntil=configured"></script>

    <script type="text/javascript">
        MathJax.Hub.Register.StartupHook("Begin Config", function () {
            // Set additional configuratons
            MathJax.Hub.Config({
                messageStyle: "none",
                showMathMenu: false,
                tex2jax: {
                    ignoreClass: "lrn_noMath",
                    processClass: "lrn"
                },
                jax: ["output/HTML-CSS"],
                TeX: {
                    Macros: {
                        /*
                        Converting MathQuil's \abs to pipe TeX Command
                        http://www.onemathematicalcat.org/MathJaxDocumentation/TeXSyntax.htm#pipeSymbol
                         */
                        abs: ["{|#1|}", 1],
                        degree: ["{^circ}"],
                        longdiv: ["{enclose{longdiv}{#1}}", 1],
                        atomic: ["{_{#1}^{#2}}", 2],
                        polyatomic: ["{_{#2}{}^{#1}}", 2],
                        circledot: ["{odot}"],
                        parallelogram: ["unicode{x25B1}"],
                        ngtr: ["unicode{x226F}"],
                        nless: ["unicode{x226E}"]
                    }
                },
                "HTML-CSS": {
                availableFonts: ["TeX"],
                    minScaleAdjust: 100,
                    matchFontHeight: false,
                    imageFont: null
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
        });
    </script>
    <script>

            var initializationObject = <?php echo $signedRequest; ?>;

            //optional callbacks for ready
            var callbacks = {
                readyListener: function () {
                    console.log("Items API has successfully initialized.");
                    // Signal MathJax to continue loading
                    MathJax.Hub.Configured();
                    MathJax.Hub.Register.StartupHook("End", function () {
                        console.log('MathJax: startup process has completed, including the initial typesetting pass');
                    });
                },
                errorListener: function (err) {
                    console.log(err);
                }
            };

            var itemsApp = LearnosityItems.init(initializationObject, callbacks);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
