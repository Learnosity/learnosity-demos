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
    "consumer_key"    => $consumer_key ,
    "domain"          => $domain
];

$request = [
    'activity_id' => 'Activity_Test',
    'activity_template_id' => 'TexttoSpeech_Testing_Activity',

    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'type' => 'submit_practice',
    'name' => 'Test Assessment',
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'texthelp.php'
        ],
        'region_overrides' => [
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'custom_button',
                    'options' => [
                        'name' => 'SpeechStream',
                        'label' => 'SpeechStream',
                        'icon_class' => 'lrn_btn SpeechStream_btn'
                    ]
                ],
                [
                    'type' => 'verticaltoc_element'
                ]
            ]
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Using Third-Party Assistive Tools: TextHelp</h2>
        <p>This demo shows how Texthelp's SpeechStream product can be integrated into a Learnosity assessment with ease.</p>
        <p><a href="https://www.texthelp.com/en-us/products/speechstream">SpeechStream</a> is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their products. This feature is used by students with learning disabilities, such as dyslexia, struggling readers, English language learners, auditory learners, and students with mild vision impairments.</p>
        <a href='https://www.texthelp.com' target='_blank' title='Learn about solutions from our partner Texthelp'><img src='../static/images/texthelp-logo.png' alt='Texthelp Logo' class='pull-right' /></a>
        <p>If you have a Texthelp license - it integrates effortlessly with Learnosity.</p>
        <p>The SpeechStream Toolbar will appear in the upper right corner of the screen, when the assessment is started.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- TextHelp start point indicator -->
    <span id="start"></span>
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>

<!-- Load Learnosity -->
<script src="<?php echo $url_items; ?>"></script>
<!-- Load the TextHelp library -->
<script src="https://toolbar.speechstream.net/SpeechStream/latest/speechstream.js" type="text/javascript" data-speechstream-config="Learnosityv350R1"></script>

<!-- Load Mathjax config compatible with Speechstream -->
<script type="text/javascript">
    window.MathJax = {
        loader: {
            load: ['a11y/semantic-enrich', 'a11y/explorer', 'a11y/assistive-mml']
        },
        options: {
            enableEnrichment:true,
            enableExplorer: true,
            enableAssistiveMml: true,
            enableMenu: false,
            ignoreHtmlClass: "lrn_noMath"
        },
        tex: {
            inlineMath: [['\\(', '\\)'], ['$$', '$$']],
            displayMath: [['\\[', '\\]']],
            macros: {
                abs: ['{|#1|}', 1],
                degree: ['°'],
                longdiv: ['{\\enclose{longdiv}{#1}}', 1],
                atomic: ['{_{#1}^{#2}}', 2],
                polyatomic: ['{_{#2}{}^{#1}}', 2],
                circledot: ['{\\odot}'],
                parallelogram: ['\\unicode{x25B1}'],
                ngtr: ['\\unicode{x226F}'],
                nless: ['\\unicode{x226E}'],
                MathQuillVarField: ['#1', 1],
                // We create a macro alias for the overarc command to be interpreted as overparen
                // Since overparen is supported by default in mathjax and overarc isn't
                overarc: ['{\\overparen{#1}}', 1]
            }
        },
        chtml: {
            minScale: 1,
            matchFontHeight: false
        }
        };
</script>

<script>

    var initializationObject = <?php echo $signedRequest; ?>

    var itemsApp = LearnosityItems.init(initializationObject, {
        readyListener: function () {
            console.log("Listener fired");
            var assessApp = itemsApp.assessApp();
            assessApp.on('button:SpeechStream:clicked', function(){
                showSpeechStreamBar();
            });
        }
    });

    var speechStreamFirstLoad = true;
    var showSpeechStream = true;
    var speechstreamApi;

    function showSpeechStreamBar(){
    if(speechStreamFirstLoad){
         window.speechstream.Loader.lateLoad().then((api)=>{ sstoolbarLoaded(api) });
    }
    else{
        showSpeechStream = !showSpeechStream;
        speechstreamApi.toggleBar();
        }
    }

    function sstoolbarLoaded(api){
        speechstreamApi = api;
        const ignoreClasses =".sr-item-description, .mq-math-mode, [class^='lrn-accessibility-'], .sr-only, .test-title-text, .subtitle, .item-count, .timer, .lrn_sort_gripper, .footer";
        const doc = window.document;
        const domControl = speechstreamApi.domControlTools.getNewDomControl(doc);
        domControl.addIgnoreListQuerySelector(ignoreClasses);
        const elemStart = document.getElementById('start');
        speechstreamApi.domControlTools.setStartPoint(elemStart);
        speechStreamFirstLoad = false;
     }

</script>

<style>
    .lrn.lrn-assess .lrn-region:not(.lrn-items-region) .lrn_btn.SpeechStream_btn{
        padding: 0.4em 0.9em 0.4em 0.7em;
    }
    @media all and (max-width: 991px) {
        .lrn.lrn-assess .lrn-region:not(.lrn-items-region) .lrn_btn.SpeechStream_btn{
            padding: 0.75em 0.25em;
        }
    }
    button.lrn_btn.SpeechStream_btn:before{
        content: '';
        background-image: url('../static/images/speechstream-logo.png');
        background-size: contain;
        float: left;
        padding: 6px;
        height: 26px;
        width: 23px;
    }
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
