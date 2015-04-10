<?php

include_once '../../config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$consumer_secret = 'xEifKN2DrvAVFK2DGgGbjKOIglbFqANpJEH1agXX';

$security = array(
    'consumer_key' => 'MicroY43GwsDI0rJ',
    'domain'       => 'localhost',
    'timestamp'    => '20150317-2355'
);

$request = '{"rendering_type":"assess","user_id":"demo_student","session_id":"b0280bcb-223c-4c33-a978-88a94d79d900","items":["ccore_video_260_classification","ccore_parcc_tecr_grade3"],"type":"submit_practice","state":"initial","activity_id":"itemsassessdemo","name":"Items API demo - assess activity","course_id":"demo_yis0TYCu7U9V4o7M","config":{"ui_style":"main"}}';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

var_dump($signedRequest);
