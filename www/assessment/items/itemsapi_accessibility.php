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
    'activity_template_id' => 'demo-activity-4',
    'activity_id'          => 'my-demo-activity',
    'name'                 => 'Accessibility Demo',
    'session_id'           => Uuid::generate(),
    'user_id'              => $studentid,
    'assess_inline'        => true,
    'config'               => array(
        'title'    => 'Accessibility Demo',
        'subtitle' => 'Walter White',
        'navigation' => array(
            'show_accessibility' => array(
                'show_colourscheme' => true,
                'show_fontsize' => true,
                'show_zoom' => true
            ),
        ),
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
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
        <h1>Items API – Accessibility</h1>
        <p>The Assess API has a built in accessibility options panel that allows students to adjust settings during their assessment. Options include
        changing the colour scheme, font size and instructions on how to zoom.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var launchAccessibility,
        eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
                launchAccessibility();
            }
        },
        activity = <?php echo $signedRequest; ?>,
        itemsApp = LearnosityItems.init(activity, eventOptions);

    launchAccessibility = function () {
        itemsApp.dialogs().accessibility.show();
    }
</script>

<?php
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
