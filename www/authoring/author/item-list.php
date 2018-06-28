<?php


//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';


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
                'add' => true,
                'browse' => array(
                    'controls' => [
                        array(
                            'type' => 'hierarchy',
                            'hierarchies' => [
                                array(
                                    'reference' => 'Standards'
                                )
                            ]
                        ),
                        array(
                            'type' => 'separator'
                        ),
                        array(
                            'type' => 'tag',
                            'tag' => array(
                                'type' => 'Depth of Knowledge'
                            )
                        ),
                        array(
                            'type' => 'tag',
                            'tag' => array(
                                'type' => 'Blooms Taxonomy'
                            )
                        )
                    ]
                )
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
                    ),
                    'dependencies' => [
                        'questions_api' => [
                            'init_options' => [
                                'beta_flags' => [
                                    'reactive_views' => true
                                ]
                            ]
                        ]
                    ]
                )
            ),
            'questions_api' => [
                'init_options' => [
                    'beta_flags' => [
                        'reactive_views' => true
                    ]
                ]
            ]
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
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
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
</script>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
