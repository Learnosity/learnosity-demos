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

$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'widget_type' => 'response',
                    'ui' => [
                        'layout' => [
                            'simple_features' => [
                                'calculator' => [
                                    [
                                        'layout' => 'calculator-layout'
                                    ]
                                ],
                                'videoplayer' => [
                                    [
                                        'layout' => 'video-player-layout'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'simple_feature_templates' => [
                        [
                            'name' => 'Custom ruler',
                            'reference' => '4d918ac6-2ac5-48f5-8707-c1957c157new',
                            'defaults' => [
                                'type' => 'imagetool',
                                'button' => true,
                                'buttonicon' => 'ruler',
                                'image' => 'ruler-15-cm',
                                'label' => 'Custom ruler label',
                                'alt' => 'Customised alt text.'
                            ]
                        ],
                        [
                            'reference' => '116e3f78-a564-4862-877c-91cdad8a2c2b'
                        ],
                        [
                            'reference' => 'd3e05438-8321-457c-a541-3cb18020eae8'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Customize the Simple Feature Modal</h2>
            <p>Our editor. Your item bank platform. You can customise the rich text editor's simple feature modal layout to suit your design needs. In this demo, we have reduced the number of, and simplified, the simple features available. For more information, refer to <a href="https://support.learnosity.com/hc/en-us/articles/360000780157-Customizing-the-simple-feature-modal">knowledge base article</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>

    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks
        var callbacks = {
            readyListener: function () {
                // navigate to new MCQ question to demonstrate the layout
                authorApp.navigate(
                    'items/new/widgets/new/' + encodeURIComponent(JSON.stringify({
                        widgetTemplate: {
                            template_reference: '9e8149bd-e4d8-4dd6-a751-1a113a4b9163'
                        }
                    }))
                );
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

    </script>

    <!--/ Simple Feature Custom Layouts -->

    <script type="text/template" data-lrn-qe-layout="calculator-layout">
        <div class="lrn-qe-edit-form">
            <span data-lrn-qe-label="mode"></span>
            <span data-lrn-qe-input="mode"></span>
        </div>
    </script>

    <script type="text/template" data-lrn-qe-layout="video-player-layout">
        <div class="lrn-qe-edit-form">
            <span data-lrn-qe-label="player_type"></span>
            <span data-lrn-qe-input="player_type"></span>
            <span data-lrn-qe-label="src"></span>
            <span data-lrn-qe-input="src"></span>
        </div>
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
