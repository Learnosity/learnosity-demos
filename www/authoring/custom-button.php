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

    //simple api request object for item edit view
    $request = [
        'mode'      => 'item_edit',
        'reference' => Uuid::generate(),
        'config'    => [
            'item_list' => [
                'limit' => 10,
                'item' => [
                    'status' => false
                ],
                'toolbar' => [
                    'add' => true
                ],
                'filter' => [
                    'restricted' => [
                        'current_user' => false
                    ]
                ]
            ],
            'item_edit' => [
                'item' => [
                    'back' => true,
                    'columns' => true,
                    'tabs' => true,
                    'save' => true,
                    'status' => false,
                    'reference' => [
                        'edit' => true,
                        'show' => true
                    ],
                    'mode' => [
                        'default' => 'edit',
                        'show' => true
                    ],
                    'dynamic_content' => false
                ],
                'widget' => [
                    'delete' => true,
                    'edit' => true
                ]
            ],
            'widget_templates' => [
                'back' => true,
                'save' => true,
                'widget_types' => [
                    'default' => 'questions',
                    'show' => true,
                ],
            ],
            'dependencies' => [
                'question_editor_api' => [
                    'init_options' => [
                        'rich_text_editor' => [
                            'type' => 'ckeditor',
                            'custom_styles'=> [
                                [
                                    'label'=> 'Custom Font',
                                    'element'=> 'span',
                                    //<span> for inlie styles. <p> for block styles.
                                    'element_class'=> 'custom-font'
                                ]
                            ],
                            'font_settings'=> [
                                'colors'=>['2C91AC,e00202,1dc600,efeb04,dc00e0'],
                                'overwrite_defaults'=> true
                            ]
                        ],
                        'label_bundle' => [
                            'stimulus' => 'Compose question'
                        ],
                        'ui' => [
                            'public_methods'     => [],
                            'question_tiles'     => false,
                            'documentation_link' => false,
                            'change_button'      => true,
                            'help_button'        => true,
                            'source_button'      => true,
                            'fixed_preview'      => true,
                            'advanced_group'     => false,
                            'search_field'       => true,
                            'layout'             => [
                                'global_template' => 'edit_preview'
                            ]
                        ],
                        'dependencies' => [
                            'questions_api' => [
                                'init_options' => [
                                    'beta_flags' => [
                                        'reactive_views' => true
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'questions_api' => [
                    'init_options' => [
                        'beta_flags' => [
                            'reactive_views' => true
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

    include_once 'utils/settings-override.php';

    $Init = new Init('author', $security, $consumer_secret, $request);
    $signedRequest = $Init->generate();

?>

    <style>
        .custom-font {
            color: red;
            font: "Times New Roman", Times, serif;
        }
    </style>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Using Custom Editor Buttons & Style</h2>
            <p></p>
        </div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks
        var callbacks = {
            readyListener: function () {
                console.log("readyListener")
                // setTimeout - Temporary work around for readylistener race condition issue. Currently working on a fix
                setTimeout(function(){
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
                        "stimulus": "<p>Click here to see the YouTube Video custom button in the CKEditor.</p>",
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
            },1000)},
            customButtons: [{
                name: 'custombutton1',
                label: 'youtube',
                icon: 'http://vignette1.wikia.nocookie.net/i-chu/images/1/18/Youtube_favicon.png',
                func: function(attribute, callback) {
                    var $modal = $('.modal.img-upload'),
                        $embedButton = $('button#embed'),
                        $closeButton = $('button#cancelembed'),
                        $customContent = $('#ck-custom-content').prop('outerHTML');

                        buttonClickHandler = function () {
                                $customContent = $('#ck-custom-content').prop('outerHTML');
                                callback($customContent);
                                $modal.modal('hide');
                                $closeButton.off('click', cancelClickHandler);
                                $embedButton.off('click', buttonClickHandler);
                                console.log("11111111");
                        };

                        cancelClickHandler = function () {
                                callback('');
                                $modal.modal('hide');
                                $closeButton.off('click', cancelClickHandler);
                                $embedButton.off('click', buttonClickHandler);
                                console.log("222222222");
                        };

                        $embedButton.unbind('click');
                        $closeButton.unbind('click');
                        $embedButton.on('click', buttonClickHandler);
                        $closeButton.on('click', cancelClickHandler);
                        $modal.modal({
                            backdrop: 'static'
                        })
                        console.log("3333333333");
                }
            }
        ],
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

        function loadWidget () {
            // Vg
            var itemRef = '8e283c09-6ac1-4760-9ce3-8d0435ba1a28';
            var widgetRef = '43fac767-371c-4d59-918b-535bd0cad883';
            var templateRef = '33d53a22-1a59-4a03-9671-7f5104edd62e';
            // Stage
            // var itemRef = '8c5bc69d-a358-41df-912e-298ebb021635';
            // var widgetRef = '67b07c46-436e-4b20-9504-7d86d2a96b9c';
            // var templateRef = '33d53a22-1a59-4a03-9671-7f5104edd62e';
            console.log('Loading widget');
            authorApp.setWidget({
                    "options": [
                        {
                            "label": "A",
                            "value": "0"
                        },
                        {
                            "label": "B",
                            "value": "1"
                        },
                        {
                            "label": "C",
                            "value": "2"
                        },
                        {
                            "label": "D",
                            "value": "3"
                        }
                    ],
                    "stimulus": "<p>New content</p>",
                    "type": "mcq",
                    "ui_style": {
                        "choice_label": "upper-alpha",
                        "type": "block"
                    },
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": []
                        }
                    }
                },
                {
                    "template_reference": templateRef
                }
            );

            // {
            //             "template_reference": templateRef
            //         }
            // authorApp.navigate('items/'+itemRef+'/widgets/'+widgetRef+'/{"widgetJson": {"options": [{"label": "A","value": "0"}, {"label": "B","value": "1"}, {"label": "C","value": "2"}, {"label": "D","value": "3"}],"stimulus": "<p>Original content</p>","type": "mcq","validation": {"scoring_type": "exactMatch","valid_response": {"score": 1,"value": []}},"is_math": true,"ui_style": {"type": "block","choice_label": "upper-alpha"}},"widgetTemplate": {"template_reference": "'+templateRef+'"}}');
            // authorApp.navigate('items/'+itemRef+'/widgets/'+widgetRef+'/{"widgetJson": {"options": [{"label": "A","value": "0"}, {"label": "B","value": "1"}, {"label": "C","value": "2"}, {"label": "D","value": "3"}],"stimulus": "<p>Original content</p>","type": "mcq","validation": {"scoring_type": "exactMatch","valid_response": {"score": 1,"value": []}},"is_math": true,"ui_style": {"type": "block","choice_label": "upper-alpha"}},"widgetTemplate": "Multiple Choice – Block UI"}');
            // authorApp.navigate('items/'+itemRef+'/widgets/'+widgetRef+'/{"widgetJson": {"options": [{"label": "A","value": "0"}, {"label": "B","value": "1"}, {"label": "C","value": "2"}, {"label": "D","value": "3"}],"stimulus": "<p>Original content</p>","type": "mcq","validation": {"scoring_type": "exactMatch","valid_response": {"score": 1,"value": []}},"is_math": true,"ui_style": {"type": "block","choice_label": "upper-alpha"}},"widgetTemplate": "'+templateRef+'"}');
            console.log('items/'+itemRef+'/widgets/'+widgetRef+'/{"widgetJson": {"options": [{"label": "A","value": "0"}, {"label": "B","value": "1"}, {"label": "C","value": "2"}, {"label": "D","value": "3"}],"stimulus": "<p>Original content</p>","type": "mcq","validation": {"scoring_type": "exactMatch","valid_response": {"score": 1,"value": []}},"is_math": true,"ui_style": {"type": "block","choice_label": "upper-alpha"}},"widgetTemplate": {"template_reference": "'+templateRef+'"}}');
        };


    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'views/modals/youtube-embed.php';
include_once 'includes/footer.php';
