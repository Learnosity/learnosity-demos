<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain' => $domain
);

$request = [
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => $studentid,
    'items' => [
        'Demo3',
        'Demo4',
        'accessibility_demo_6',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',
        'Demo10',
        'audioplayer-demo-1'
    ],
    'config' => [
        'annotations'=>true,
        "annotations_api_init_options"=> [
                "modules"=> [
                    "notepad"=> true,
                    "texthighlight"=> true,
                    "drawing"=> true,
                    "texthighlight"=> true,
                    "stickynote"=>true
                ]
            ],
        'title' => 'Demo activity - showcasing question types and assess options',
        'subtitle' => 'Walter White',
        'regions' => 'main',
        'navigation' => [
            'show_progress' => false,
            'show_intro' => true,
            'show_outro' => true,
            'show_title' => false,
            'skip_submit_confirmation' => false,
            'warning_on_change' => false,
            'show_acknowledgements' => true,
            'auto_save' => [
                'ui' => false,
                'saveIntervalDuration' => 500
            ],
            'item_count' => [
                'question_count_option' => false
            ]
        ],
        'time' => [
            'max_time' => 1500,
            'limit_type' => 'soft',
            'warning_time' => 120
        ],
        'configuration' => [
            'shuffle_items' => false,
            'lazyload' => false,
            'fontsize' => 'normal',
            'onsubmit_redirect_url' => 'itemsapi_assess.php',
            'onsave_redirect_url' => 'itemsapi_assess.php',
            'ondiscard_redirect_url' => 'itemsapi_assess.php',
            'idle_timeout' => [
                'interval' => 300,
                'countdown_time' => 60
            ],
            'submit_criteria' => [
                'type' => 'attempted'
            ]
        ],
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ],
        'administration' => [
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8',
            'options' => [
                'show_save' => true,
                'show_submit' => true,
                'show_exit' => true,
                'show_extend' => true
            ]
        ]
    ]
];


include 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#" data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/items" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Annotations</h1>
        <p> Annotations let students add sticky notes, highlighting, and freehand sketches to their responses, giving educators even greater access to learners' thought processes.</p>
    </div>
</div>

<div class="section">
    <div id="learnosity_assess"></div>
</div>
<script type="text/javascript" src="https://items.learnosity.com/?v2018.2.LTS"></script>
<!-- <script src="<?php echo $url_items; ?>"></script> -->
<script>

    var itemsApp = {};
    var currentRegions = <?php echo json_encode($request['config']['regions']);?>;
    var eventOptions = {
        readyListener: init,
        errorListener: function (event) {
            console.log("error:" + event);
        }
    };


    itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function init() {
        var assessApp = itemsApp.assessApp();

        assessApp.on('item:load', function () {
            console.log('Active item:', getActiveItem(this.getItems()));
        });

        assessApp.on('test:submit:success', function () {
            toggleModalClass();
        });

        // Uncomment if you don't want a warning when leaving the
        // page with unsaved changes
        // window.onbeforeunload = function () {
        //     return;
        // }
    }

    /**
     * Returns the active item if using the Assess API
     * @param  {object} items Object of all items currently loaded
     * @return {object}       Current active item
     */
    function getActiveItem(items) {
        for (var item in items) {
            if (items.hasOwnProperty(item) && items[item].active === true) {
                return items[item];
            }
        }
    }

    function toggleModalClass() {
        $('.modal-backdrop').css('display', 'none');
    }
</script>
<script type="text/javascript" src="regions_settings.js">
</script>
<?php
include_once 'views/modals/settings-items2.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';

?>
