<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Demo showcasing remote control events',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => $student['id'],
    'items'          => ['Demo4', 'Demo3', 'Demo6', 'Demo7', 'Demo8', 'Demo9'],
    'config'         => [
        'title'          => 'Demo showcasing remote control events',
        'subtitle'       => $student['name'],
        'administration' => [
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ],
        'navigation' => [
            'intro_item' => 'demo-intro-live-progress',
        ],
        'regions' => [
            'top-right' => [
                [
                    'type' => 'timer_element'
                ],
                [
                    'type' => 'pause_button'
                ],
            ],
            'right' => [
               [
                  'type' => 'previous_button'
               ],
               [
                  'type' => 'next_button'
               ],
               [
                  'type' => 'separator_element'
               ],
               [
                   'type' => 'save_button'
               ],
               [
                  'type' => 'flagitem_button'
               ],
               [
                  'type' => 'masking_button'
               ]
            ]
        ],
        'time' => [
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'warning_time' => 120,
            'show_pause'   => true,
            'show_time'    => true
        ],
        'configuration'       => [
            'ondiscard_redirect_url' => $_SERVER['REQUEST_URI'],
            'onsubmit_redirect_url'  => $_SERVER['REQUEST_URI'],
            'onsave_redirect_url'    => $_SERVER['REQUEST_URI'],
            'events'                 => true
        ],
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<!doctype html>
<html>
<head>
<title>
        <?php echo $student['name']; ?> &mdash; Demo showcasing remote control events
</title>
</head>
<body>
<!-- Container for the items api to load into -->
<div id="learnosity_assess"></div>
<script src="<?php echo $url_items; ?>"></script>
<script>
var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>
</body>
</html>
