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
            'dependencies' => [
                'question_editor_api' => [
                    'init_options' => [
                        'rich_text_editor' => [
                            'type' => 'ckeditor',
                            'custom_styles'=> [
                                [
                                    'label'=> 'Custom Font',
                                    'element'=> 'span', //<span> for inline styles. <p> for block styles.
                                    'element_class'=> 'custom-font'
                                ]
                            ],
                            'font_settings'=> [
                                'colors'=>['2C91AC,e00202,1dc600,efeb04,dc00e0'],
                                'overwrite_defaults'=> true
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

    <!-- Custom Font style. Used to demonstrate the custom font option that we added to the rich text editor -->
    <style>
        .custom-font {
            color: red;
            font-weight: bold;
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
            <h2>Customize Editor Toolbars</h2>
            <p>Extend the Learnosity rich text editor toolbar with your own buttons, behavior, and styles.</p>
            <p>This demo demonstrates how you can include a custom button in the toolbar to help embed YouTube videos into your stimulus and answers.</p>
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
                // navigate to new MCQ question to demonstrate the layout
                authorApp.navigate(
                    'items/new/widgets/new/' + encodeURIComponent(JSON.stringify({
                        widgetTemplate: {
                            template_reference: '9e8149bd-e4d8-4dd6-a751-1a113a4b9163'
                        }
                    }))
                );
            },
            customButtons: [{
                name: 'custombutton1',
                label: 'youtube',
                icon: '/../static/images/youtube_social_icon_red.png',
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
                        };

                        cancelClickHandler = function () {
                                callback('');
                                $modal.modal('hide');
                                $closeButton.off('click', cancelClickHandler);
                                $embedButton.off('click', buttonClickHandler);
                        };

                        $embedButton.unbind('click');
                        $closeButton.unbind('click');
                        $embedButton.on('click', buttonClickHandler);
                        $closeButton.on('click', cancelClickHandler);
                        $modal.modal({
                            backdrop: 'static'
                        })
                }
            }],
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'views/modals/youtube-embed.php';
include_once 'includes/footer.php';
