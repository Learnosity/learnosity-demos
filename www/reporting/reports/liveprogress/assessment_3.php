<?php

include_once '../../../config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$student = array(
    'id'   => $_GET['user_id'],
    'name' => 'Hank Schrader'
);

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'course_id'      => $courseid,
    'session_id'     => Uuid::generate(),
    'user_id'        => $student['id'],
    'assess_inline'  => true,
    'items'          => array('Demo3', 'Demo4', 'Demo5', 'Demo6', 'Demo7', 'Demo8', 'Demo9', 'Demo10'),
    'config'         => array(
        'title'          => 'Demo showcasing remote control events',
        'subtitle'       => $student['name'],
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'navigation' => array(
            'intro_item' => 'demo-intro-live-progress',
            'show_fullscreencontrol' => false
        ),
        'time' => array(
            'max_time'     => 1500,
            'limit_type'   => 'soft',
            'show_pause'   => false,
            'warning_time' => 120,
            'show_time'    => true
        ),
        'labelBundle' => array(
            'item' => 'Question'
        ),
        'ui_style'            => 'horizontal-fixed',
        'questionsApiVersion' => 'v2',
        'assessApiVersion'    => 'v2',
        'configuration'       => array(
            'ondiscard_redirect_url' => './assessment_3.php?user_id=' . $_GET['user_id'],
            'onsubmit_redirect_url' => './assessment_3.php?user_id=' . $_GET['user_id'],
            'onsave_redirect_url'   => './assessment_3.php?user_id=' . $_GET['user_id'],
            'events'                => true
        )
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!-- Container for the items api to load into -->
<div id="learnosity_assess"></div>
<script src="//items.learnosity.com"></script>
<script>
    var app = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>
