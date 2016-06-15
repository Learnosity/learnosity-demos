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
                'save' => true,
                'status' => false,
                'reference' => array(
                    'edit' => false,
                    'show' => false
                ),
                'mode' => array(
                    'default' => 'edit',
                    'show' => false
                )
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
                'version' => $version_questioneditorapi,
                'init_options' => array(
                    'rich_text_editor' => array(
                        'type' => 'ckeditor'
                    ),
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'source_button'      => true,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => true
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
        <h1>Author API – Routing</h1>
        <p>Learnosity&apos;s Author API allows the enabling of linkable, bookmarkable, shareable URLs to navigate directly to locations within the app.</p>
        <p>Our <a href="http://docs.learnosity.com/authoring/author/knowledgebase/author-api-routing">knowledgebase article</a> demonstrates how easy it is to set up routing with the Author API by using the <a href="http://docs.learnosity.com/authoring/author/publicmethods#on-events">&lsquo;navigate&rsquo; event</a> and the <a href="http://docs.learnosity.com/authoring/author/publicmethods#navigate">&lsquo;navigate&rsquo; public method</a>.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        authorApp = LearnosityAuthor.init(initOptions, {
            readyListener: function () {
                authorApp.on('navigate', function (e) {
                    window.location.hash = '#' + e.data.location;
                });
                authorApp.navigate(window.location.hash.replace(/^#/, ''));
                window.onhashchange = function () {
                    authorApp.navigate(window.location.hash.replace(/^#/, ''));
                };
            }
        });
</script>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';

