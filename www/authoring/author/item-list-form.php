<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$item_ref = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'mode'      => 'item_list',
    'config'    => array(
        'item_list' => array(
            'limit' => 10,
            'item' => array(
                'status' => false
            ),
            'toolbar' => array(
                'add' => true
            ),
            'filter' => array(
                'restricted' => array(
                    'current_user' => false
                )
            )
        ),
        'item_edit' => array(
            'item' => array(
                'back' => true,
                'columns' => true,
                'tabs' => true,
                'save' => true,
                'status' => false,
                'reference' => array(
                    'edit' => true,
                    'show' => true
                ),
                'mode' => array(
                    'default' => 'edit',
                    'show' => true
                ),
                'dynamic_content' => false
            ),
            'widget' => array(
                'delete' => true,
                'edit' => true
            )
        ),
        'widget_templates' => array(
            'back' => true,
            'save' => true,
            'widget_types' => array(
                'default' => 'questions',
                'show' => true,
            ),
        ),
        'dependencies' => array(
            'question_editor_api' => array(
                'init_options' => array(
                    'rich_text_editor' => array(
                        'type' => 'ckeditor'
                    ),
                    'label_bundle' => array(
                        'stimulus' => 'Compose question'
                    ),
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'help_button'        => true,
                        'source_button'      => true,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => true,
                        'layout'             => array(
                            'global_template' => 'edit_preview'
                        )
                    )
                )
            )
        )
    ),
    'user' => array(
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API – Item List</h1>
        <p>The item list mode allows authors to search the Learnosity hosted item bank for existing items. From there
        it can be configured to allows users to edit items, or just select them for activity creation.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <!-- <div id="learnosity-author"></div> -->
    <form onsubmit="return testAction();" action="item-list.php">
        Test field:<br>
        <input type="text" name="firstname" value="test"><br>
        <span id="learnosity-author"></span>
        <input type="submit" value="Submit">
    </form>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var assetRequestFunction = function(mediaRequested, returnType, callback) {
        if (mediaRequested === 'image') {
            var $modal = $('.modal.img-upload'),
            $images = $('.asset-img-gallery img'),
            imgClickHandler = function () {
                if (returnType === 'HTML') {
                    callback('<img src="' + $(this).data('img') + '"/>');
                } else {
                    callback($(this).data('img'));
                }
                $modal.modal('hide');
            };
            $images.on('click', imgClickHandler);
            $modal.modal({
                backdrop: 'static'
            }).on('hide', function () {
                $images.off('click', imgClickHandler);
            });
        }
    };

    var eventOptions = {
            readyListener: init,
            customButtons: [{
                name: 'custombutton2',
                label: 'evernote',
                icon: 'http://tidbits.com/images/favicons/evernote.png',
                func:  function(attribute, callback) {
                    return callback('Evernote');
                },
                attributes: ['stimulus', 'metadata.distractor_rationale']
            }
            ],
            assetRequest: assetRequestFunction,
        },
        initOptions = <?php echo $signedRequest; ?>,
        authorApp = LearnosityAuthor.init(initOptions, eventOptions);

    function init () {
        authorApp.on('save:success', function (event) {
            console.log(event);
        });
        authorApp.on('save:error', function (event) {
            console.log('Error ' + event);
        });

    }

    function testAction() {
        console.log('submitted...');
    }

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
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
