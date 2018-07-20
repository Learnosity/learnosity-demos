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
    'name'           => '',
    'rendering_type' => 'assess',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'sections' => array(
        array(
            'items' => array('Demo3', 'Demo4', 'Demo5'),
            'config' => array(
                'subtitle' => 'Vocabulary section'
            )
        ),
        array(
            'items' => array('Demo6', 'Demo7', 'Demo8'),
            'config' => array(
                'subtitle' => 'Grammar section'
            )
        ),
        array(
            'items' => array('Demo9', 'Demo10'),
            'config' => array(
                'subtitle' => 'Spelling section'
            )
        )
    ),
    'assess_inline'  => true,
    'config'         => array(
        'title'          => 'Demo activity - showcasing assess question indexing across sections',
        'subtitle'       => 'Will be overridden',
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
        'configuration'       => array(
            'fontsize'               => 'normal',
            'stylesheet'             => '',
            'onsubmit_redirect_url'  => 'itemsapi_sections.php',
            'onsave_redirect_url'    => 'itemsapi_sections.php',
            'ondiscard_redirect_url' => 'itemsapi_sections.php',
            'question_indexing'      => true,
            'idle_timeout'           => array(
                'interval'       => 300,
                'countdown_time' => 60
            )
        ),
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/items" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Assess Question Indexing</h1>
        <p>
            The Assess configuration option question_indexing adds sequential numbers to all
            questions in the activity.
        </p>
        <p>
            Where <a href="https://docs.learnosity.com/assessment/items/knowledgebase/sections" title="Documentation for Assess sections">sections</a> are used, the numbers reset to 1 at the start of each section.
        </p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
                itemsApp.assessApp().on('test:submit:success', function () {
                    toggleModalClass();
                });
            }
        });

    function toggleModalClass () {
        $('.modal-backdrop').css('display', 'none');
    }
</script>

<?php
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
