<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

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
                'dynamic_content' => false,
                'duplicate' => true,
                'shared_passage' => true
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
                        'type' => 'wysihtml'
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

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

$requestRubric = [
    'mode'   => 'item_list',
    'config' => [
        'widget_templates' => [
            'back' => false
        ],
        'label_bundle' => [
            'saveButton' => 'Save Rubric'
        ],
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => [
                    'rich_text_editor' => [
                        'type' => 'wysihtml'
                    ],
                    'ui' => [
                        'change_button' => false,
                        'layout' => [
                            'global_template' => 'edit_preview'
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

$InitRubric = new Init('author', $security, $consumer_secret, $requestRubric);
$signedRequestRubric = $InitRubric->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

        </ul>
    </div>
    <div class="overview">
        <h1>Author API – Attach Rubric</h1>
        <p>This page simulates creating an extended response question,
        with the choice to create a rubric and attach to the main question.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        eventOptionsRubric = {
            readyListener: initRubric
        },
        initOptions = <?php echo $signedRequest; ?>,
        initOptionsRubric = <?php echo $signedRequestRubric; ?>,
        authorApp = LearnosityAuthor.init(initOptions, eventOptions, 'learnosity-author'),
        authorAppRubric;

    function init () {
        setListeners();
        navigateToWidget('essay');
    }

    function initRubric () {
        navigateToWidget('rating');
        authorAppRubric.on('save:success', saveRubric);
    }

    function loadRubricEditor () {
        authorAppRubric = LearnosityAuthor.init(initOptionsRubric, eventOptionsRubric, 'learnosity-author-rubric');
        authorAppRubric.on('save', function (evt) {

        });
    }

    function saveRubric () {
        var ref = authorAppRubric.getItemReference();
        authorApp.editorApp().attribute('metadata.rubric_reference').setValue(ref);
        $('#search-rubric').modal('hide');
        // authorAppRubric.destroy();
    }

    function setListeners () {
        authorApp.on('add:widget', function (evt) {
            addCustomRubricButton();
        });
    }

    function navigateToWidget (widget) {
        switch (widget) {
            case 'essay':
                authorApp.navigate('items/new/widgets/new/' +
                    JSON.stringify({
                        "widgetJson": {
                            "stimulus": "<p>Analyze the arguments presented in the two speeches. In your response, develop an argument in which you explain how one position is better supported than the other. Incorporate relevant and specific evidence from both sources to support your argument.</p>",
                            "type": "longtextV2"
                        },
                        "widgetTemplate": {
                            "template_reference": "1e6039f8-0676-495d-aca9-108710a51ce5"
                        }
                    })
                );
                break;
            case 'rating':
                authorAppRubric.navigate('items/new/widgets/new/' +
                    JSON.stringify({
                        "widgetJson": {
                            "options": [{
                                "value": "3",
                                "label": "3",
                                "label_tooltip": "3",
                                "tint": "green",
                                "description": "3"
                            }, {
                                "value": "2",
                                "label": "2",
                                "label_tooltip": "2",
                                "tint": "green",
                                "description": "2"
                            }, {
                                "value": "1",
                                "label": "1",
                                "label_tooltip": "1",
                                "tint": "blue",
                                "description": "1"
                            }, {
                                "value": "0",
                                "label": "0",
                                "label_tooltip": "0",
                                "tint": "green",
                                "description": "0"
                            }],
                            "type": "rating",
                            "stimulus": "<table class=\"table table-bordered\" style=\"null\"><tbody><tr><td>&nbsp;3</td><td>&nbsp;A complete response with a detailed explanation</td></tr><tr><td>&nbsp;2</td><td>&nbsp;A good solid response with clear explanation</td></tr><tr><td>&nbsp;1</td><td>&nbsp;Explanation is unclear</td></tr><tr><td>&nbsp;0</td><td>&nbsp;Misses key points</td></tr></tbody></table><p>&nbsp;</p>"
                        },
                        "widgetTemplate": {
                            "template_reference": "8e99fa69-b829-4a7d-ae2a-eb935fe3a2c6"
                        }
                    })
                );
                break;
            default:
                break;
        }
    }

    function addCustomRubricButton () {
        var btn = '<div class="lrn-author-save-button-group" style="border-right: 1px solid #eee;">' +
                '<button type="button" class="btn-rubric lrn-btn lrn-btn-primary" data-toggle="modal" data-target="#search-rubric">' +
                    '<span class="lrn-i-details"></span>' +
                    '<span class="lrn-author-inline-block lrn-author-margin-left-xs">Add Rubric</span>' +
                '</button>' +
            '</div>';

        $('.lrn-author-item-nav-right').prepend(btn);
        document.getElementsByClassName('btn-rubric')[0]
            .addEventListener('click', loadRubricEditor, false);
    }

    function guid () {
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
    }

    function s4 () {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
</script>

<div class="modal fade preview" id="search-rubric">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create Rubric</h4>
            </div>
            <div class="modal-body">
                <div id="learnosity-author-rubric"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
