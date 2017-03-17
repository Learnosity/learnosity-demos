<?php

include_once '../../../config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Demo showcasing remote control events',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'course_id'      => $courseid,
    'session_id'     => Uuid::generate(),
    'user_id'        => $student['id'],
    'items'          => array('Demo4', 'Demo3', 'Demo6', 'Demo7', 'Demo8', 'Demo9'),
    'config'         => array(
        'title'          => 'Demo showcasing remote control events',
        'subtitle'       => $student['name'],
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'navigation' => array(
            'intro_item' => 'demo-intro-live-progress',
        ),
        'regions' => array(
            'top-right' => array(
                array(
                    'type' => 'timer_element'
                ),
                array(
                    'type' => 'pause_button'
                )
            ),
            'right' => array(
               array(
                  'type' => 'previous_button'
               ),
               array(
                  'type' => 'next_button'
               ),
               array(
                  'type' => 'separator_element'
               ),
               array(
                  'type' => 'flagitem_button'
               ),
               array(
                  'type' => 'masking_button'
               )
            )
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'warning_time' => 120,
            'show_pause'   => true,
            'show_time'    => true
        ),
        'questionsApiVersion' => 'v2',
        'assessApiVersion'    => $version_assessapi,
        'configuration'       => array(
            'ondiscard_redirect_url' => $_SERVER['REQUEST_URI'],
            'onsubmit_redirect_url'  => $_SERVER['REQUEST_URI'],
            'onsave_redirect_url'    => $_SERVER['REQUEST_URI'],
            'events'                 => true
        )
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<!doctype html>
<html>
<head>
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
