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

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/authoring/customfeature/";

//simple api request object for item list view, with optional creation of items
$request = [
    'mode'      => 'item_edit',
    'reference' => Uuid::generate(),
    'config'    => [
        'widget_templates' => [
            'widget_types' => [
                'default' => 'features',
                'show' => true
            ]
        ],
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'ui' => [
                        'layout' => [
                             'global_template' => 'edit_preview'
                        ]
                    ],
                    'custom_feature_types' => [
                        [
                            'custom_type' => 'simplegallery',
                            'name' => 'Custom Image Gallery',
                            'js' => $url . 'simplegallery.js',
                            'css' => $url . 'simplegallery.css',
                            'version' => 'v0.0.1',
                            'editor_layout' => $url . 'simplegallery.html',
                            'editor_schema' => [
                                'hidden_question' => false,
                                'properties' => [
                                    'photos' => [
                                        'name' => 'Photos',
                                        'description' => 'Photos',
                                        'type' => 'array',
                                        'required' => true,
                                        'items' => [
                                            'name' => 'Photo',
                                            'type' => 'imageObject',
                                            'attributes' => [
                                                'source' => [
                                                    'name' => 'Add image',
                                                    'description' => 'The image that should be displayed.',
                                                    'type' => 'string',
                                                    'required' => true,
                                                    'asset' => [
                                                        'mediaType' => 'image',
                                                        'returnType' => 'URL'
                                                    ]
                                                ],
                                                'alt' => [
                                                    'name' => 'Image alternative text',
                                                    'description' => 'The alternative text of the image.',
                                                    'type' => 'string',
                                                    'required' => false
                                                ],
                                                'credit' => [
                                                    'name' => 'Image Credit',
                                                    'description' => 'The Credit text of the image.',
                                                    'type' => 'string',
                                                    'required' => false
                                                ]
                                            ]
                                        ],
                                        'default' => [
                                            ['source' => $url . 'newstandard.png','alt' => 'photo 1', 'credit' => 'Learnosity'],
                                            ['source' => $url . 'savetime.png','alt' => 'photo 2', 'credit' => 'Learnosity'],
                                            ['source' => $url . 'alwaysmovingfwd.png','alt' => 'photo 3', 'credit' => 'Learnosity'],
                                            ['source' => $url . 'seamlessintegration.png','alt' => 'photo 4', 'credit' => 'Learnosity']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Author Custom Features</h2>
            <p>Create custom features that can appear in the authoring environment and assessments. In this demo, we've added a Custom Image Gallery feature that allows you to add/remove images and navigate through them.
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Author API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
