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
                        'custom_styles' => [
                            [
                                'label' => 'Custom Font',
                                'element' => 'span', //<span> for inline styles. <p> for block styles.
                                'element_class' => 'custom-font'
                            ]
                        ],
                        'font_settings' => [
                            'colors' => ['2C91AC,e00202,1dc600,efeb04,dc00e0'],
                            'overwrite_defaults' => true
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
            <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Customize Editor Toolbars</h2>
        <p>Extend the Learnosity rich text editor toolbar with your own buttons, behavior, and styles.</p>
        <p>This demo demonstrates how you can include a custom button in the toolbar to help embed YouTube videos into the stimulus and response option fields.</p>
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
                var modalEl = document.querySelector('.modal.img-upload'),
                    embedButton = document.querySelector('button#embed'),
                    closeButton = document.querySelector('button#cancelembed'),
                    modal = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: 'static' });

                    if (typeof buttonClickHandler === 'function') {
                        embedButton.removeEventListener('click', buttonClickHandler);
                    }
                    if (typeof cancelClickHandler === 'function') {
                        closeButton.removeEventListener('click', cancelClickHandler);
                    }

                    detachEmbedHandlers = function () {
                            closeButton.removeEventListener('click', cancelClickHandler);
                            embedButton.removeEventListener('click', buttonClickHandler);
                    };

                    buttonClickHandler = function () {
                            callback(document.getElementById('ck-custom-content').outerHTML);
                            modal.hide();
                            detachEmbedHandlers();
                    };

                    cancelClickHandler = function () {
                            callback('');
                            modal.hide();
                            detachEmbedHandlers();
                    };

                    embedButton.addEventListener('click', buttonClickHandler);
                    closeButton.addEventListener('click', cancelClickHandler);
                    modal.show()
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
