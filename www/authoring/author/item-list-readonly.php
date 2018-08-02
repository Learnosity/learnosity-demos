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
                'add' => false
            )
        ),
        'item_edit' => array(
            'item' => array(
                'back' => true,
                'columns' => false,
                'save' => false,
                'status' => false,
                'reference' => array(
                    'edit' => false,
                    'show' => true
                ),
                'mode' => array(
                    'default' => 'preview',
                    'show' => false
                )
            ),
            'widget' => array(
                'delete' => false,
                'edit' => false
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/authoring/author/initialization#config_item_list" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API – Read Only</h1>
        <p>Sometimes there is a requirement to simply preview content, without the ability
        to make modifications.</p>
        <p>By disabling <a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">certain configuration flags</a>, you can easily setup read only access
        to your item bank.</p>
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
        // authorApp.navigate('items/new/widgets/new/' + JSON.stringify(
        //     {
        //         widgetTemplate: 'Choice Matrix – Inline'
        //     }
        // ));
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
