<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = 'd132b6be-cbf4-4a0e-94b3-2ce64be68ba3';

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'items'          => array('image-annotate-demo'),
    'assess_inline'  => true,
    'config'         => array(
        'title'    => 'Demo activity - showcasing student tools',
        'subtitle' => 'Bart Simpson',
        'ui_style' => 'horizontal',
        'navigation' => array(
            'show_intro' => false,
            'show_outro' => false,
            'show_calculator' => true
        ),
        'regions' => array(
            'right' => array(
                array(
                    'type' => 'fullscreen_button'
                ),
                array(
                    'type' => 'pause_button'
                ),
                array(
                    'type' => 'separator_element'
                ),
                array(
                    'type' => 'flagitem_button'
                ),
                array(
                    'type' => 'masking_button'
                ),
                array(
                    'type' => 'reviewscreen_button'
                ),
                array(
                    'type' => 'separator_element'
                ),
                array(
                    'type' => 'calculator_button'
                ),
            ),
            'bottom-right' => array(
                array(
                    'type' => 'previous_button',
                    'position' => 'left'
                ),
                array(
                    'type' => 'next_button',
                    'position' => 'right'
                ),
            )
        ),
        'time'     => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => true,
            'warning_time' => 120,
            'show_time'    => true
        ),
        'configuration'       => array(
            'onsubmit_redirect_url'  => false,
            'onsave_redirect_url'    => 'student_tools.php',
            'ondiscard_redirect_url' => 'student_tools.php'
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
