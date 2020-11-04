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


//simple author api request object for item edit view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config'    => [
        'widget_templates' => [
            'save' => false,
            'back' => false,
        ],
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'widget_type' => 'response',
                    'ui' => [
                        'change_button' => false,
                        'layout' => [
                            'global_template' => 'edit'
                        ],
                    ],
                    'rich_text_editor' => [
                        'toolbar_settings' => [
                            'ltr_toolbar' => [
                                [
                                    'name' => 'basicstyles',
                                    'items' => ['Bold', 'Italic', 'Underline', 'RemoveFormat', 'FontSize'],
                                ],
                                [
                                    'name' => 'list',
                                    'items' => ['BulletedList', 'NumberedList'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ],
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Customizing the Rich Text Editor toolbar</h2>
            <p>You can customize the Rich Text Editor (RTE) toolbar to rearrange or hide specific options for authors. For example, showing fewer buttons for a cleaner interface.</p>
            <p>By default, the toolbar shows 28 buttons, like this:<br>  
            <img src="../static/images/ckeditor-default-toolbar.png" height=87% width=87%></p>
            <p>In this demo, we have customized the toolbar to only show seven buttons, like so:<br> <img src="../static/images/ckeditor-customized-toolbar.png"  height=21% width=21%></p>
            <p>To see the customized toolbar, click into the "Compose question" field below. For instructions on how to customize the toolbar, see <a href="https://help.learnosity.com/hc/en-us/articles/360014562597-Customizing-the-RTE-toolbar-in-Question-Editor-API">this article</a>.</p>
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
