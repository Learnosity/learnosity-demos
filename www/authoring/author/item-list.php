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
            'item' => array(
                'status' => false
            ),
            'toolbar' => array(
                'add' => true
            )
        ),
        'item_edit' => array(
            'item' => array(
                "back" => true,
                "columns" => true,
                "save" => true,
                "status" => false,
                "reference" => array(
                    "edit" => false,
                    "show" => false
                ),
                'tags' => array(
                    'include_tags_on_edit' => array(
                        array(
                            'type' => 'course',
                            'name' => 'commoncore'
                        ),
                        array(
                            'type' => 'grade',
                            'name' => '2'
                        )
                    )
                )
            ),
            'widget' => array(
                'delete' => true,
                'edit' => true
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
        <h1>Author API</h1>
        <p>The item list view allows authors to search the Learnosity item bank for existing items. From there
        it can be configured to allow users to create items, or just select them for activity creation.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        authorApp = LearnosityAuthor.init(initOptions);
</script>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
