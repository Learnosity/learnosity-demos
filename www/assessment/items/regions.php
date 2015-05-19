<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'course_id'      => $courseid,
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'items'          => array('Demo3', 'Demo4', 'Demo12', 'accessibility_demo_6', 'Demo6', 'Demo7', 'Demo8', 'Demo9', 'Demo10'),
    'assess_inline'  => true,
    'config'         => array(
        'regions'  => 'main',
        'title'    => 'Demo activity - showcasing question types and assess options',
        'subtitle' => 'Walter White',
        'time'     => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => true,
            'warning_time' => 120,
            'show_time'    => true
        ),
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', // `password`
            'options' => array(
                'show_save'   => true,
                'show_exit'   => true,
                'show_extend' => true
            )
        ),
        'configuration'       => array(
            'onsubmit_redirect_url'  => 'regions.php',
            'onsave_redirect_url'    => 'regions.php',
            'ondiscard_redirect_url' => 'regions.php'
        )
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Assess Regions</h1>
        <p>Learnosity regions are a part of the Assess API, and allow you to create a personalized, fluid and extensible assessment UI.</p>
        <p>All visual elements such as buttons, timer, pager, etc. are modularized in such a way that they can be placed
        in different <em>regions</em> of the assessment container.</p>
        <p>Read more about regions on the <a href="http://docs.learnosity.com/assessapi/knowledgebase/regions.php">docs site</a>,
        or select one of the <a href="#" class="text-muted" data-toggle="modal" data-target="#settings">default or custom regions</a>
        to see the sorts of things you can do.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-regions.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
