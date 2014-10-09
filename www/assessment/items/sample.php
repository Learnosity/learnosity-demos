<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => 'demo_teacher'
);

$request = array(
    'eventbus' => true,
    'users'    => array(
        'brianmoser',
        'paulyshore'
    )
);

$Init = new Init('events', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();
var_dump($signedRequest);
?>

<script src="//events.learnosity.com"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        handleEvent,
        eventsApp;

    eventsApp = LearnosityEvents.init(initOptions);

    function handleEvent (e) {
        console.log(e);
        eventsApp.publish([e])
    }
    function onEvent () {
        eventsApp.on(function (e) {
            console.log(e);
        });
    }
</script>

<?php
    include_once 'includes/footer.php';
