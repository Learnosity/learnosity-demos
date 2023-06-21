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


//simple api request object for item list view, with optional creation of items
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config'    => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'widget_type' => 'response',
                    'ui' => [
                        'layout' => [
                            'global_template' => 'edit'
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
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Edit Questions Directly</h2>
            <p>Initialize the Author API to directly load a question for quick editing. For more information refer to the init options docs and the <a href="https://reference.learnosity.com/author-api/methods/authorApp/setWidget">setWidget()</a> public method.</p>
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
                authorApp.on('render:item', function(){
                    authorApp.setWidget(
                        {
                            "options": [
                                {
                                    "label": "[Option A]",
                                    "value": "0"
                                },
                                {
                                    "label": "[Option B]",
                                    "value": "1"
                                },
                                {
                                    "label": "[Option C]",
                                    "value": "2"
                                },
                                {
                                    "label": "[Option D]",
                                    "value": "3"
                                }
                            ],
                            "stimulus": "<p>This is the question the student will answer</p>",
                            "type": "mcq",
                            "validation": {
                                "scoring_type": "exactMatch",
                                "valid_response": {
                                    "score": 1,
                                    "value": [
                                        "2"
                                    ]
                                }
                            },
                            "ui_style": {
                                "type": "horizontal"
                            }
                        },
                        'Multiple choice – standard'
                    );
                });
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
