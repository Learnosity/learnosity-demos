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
    'items'          => array('Demo3', 'Demo4', 'Demo12', 'accessibility_demo_6', 'Demo6', 'Demo7', 'Demo8', 'Demo9', 'Demo10', 'audioplayer-demo-1'),
    'assess_inline'  => true,
    'config'         => array(
        'title'          => 'Demo activity - showcasing question types and assess options',
        'subtitle'       => 'Walter White',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', // `password`
            'options' => array(
                'show_save' => true,
                'show_exit' => true,
                'show_extend' => true
            )
        ),
        'navigation' => array(
            'scroll_to_top'            => false,
            'scroll_to_test'           => false,
            'show_intro'               => true,
            'show_outro'               => true,
            'show_next'                => true,
            'show_prev'                => true,
            'show_accessibility' => array(
                'show_colourscheme' => true,
                'show_fontsize' => true,
                'show_zoom' => true
            ),
            'show_configuration'       => false,
            'show_fullscreencontrol'   => true,
            'show_progress'            => true,
            'show_submit'              => true,
            'show_title'               => true,
            'show_save'                => false,
            'show_calculator'          => false,
            'show_itemcount'           => true,
            'skip_submit_confirmation' => false,
            'toc'                      => true,
            'transition'               => 'fade',
            'transition_speed'         => 400,
            'warning_on_change'        => false,
            'scrolling_indicator'      => false,
            'show_answermasking'       => true,
            'show_acknowledgements'    => true,
            'auto_save'                => array(
                'ui' => false,
                'saveIntervalDuration' => 500
            )
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => true,
            'warning_time' => 120,
            'show_time'    => true
        ),
        'labelBundle' => array(
            'item' => 'Question'
        ),
        'ui_style'            => 'main',
        'ignore_validation'   => false,
        'questionsApiVersion' => $version_questionsapi,
        'assessApiVersion'    => $version_assesssapi,
        'configuration'       => array(
            'fontsize'               => 'normal',
            'stylesheet'             => '',
            'onsubmit_redirect_url'  => 'itemsapi_assess.php',
            'onsave_redirect_url'    => 'itemsapi_assess.php',
            'ondiscard_redirect_url' => 'itemsapi_assess.php',
            'idle_timeout'           => array(
                'interval'       => 300,
                'countdown_time' => 60
            )
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
        <h1>Items API – Assess</h1>
        <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.<p>
        <p>Type ctrl+shift+m to open the Administration Panel. The default password is <em>password</em>.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        var assessApp = itemsApp.assessApp();

        assessApp.on('item:load', function () {
            console.log('Active item:', getActiveItem(this.getItems()));
        });

        assessApp.on('test:submit:success', function () {
            toggleModalClass();
        });
    }

    /**
     * Returns the active item if using the Assess API
     * @param  {object} items Object of all items currently loaded
     * @return {object}       Current active item
     */
    function getActiveItem (items) {
        for (var item in items) {
            if (items.hasOwnProperty(item) && items[item].active === true) {
                return items[item];
            }
        }
    }

    function toggleModalClass () {
        $('.modal-backdrop').css('display', 'none');
    }
</script>

<?php
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
