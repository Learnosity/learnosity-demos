<?php

include_once '../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => 'brianmoser'
);

$request = array(
    'eventbus' => true
);

$Init = new Init('events', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<script src="//events.learnosity.com"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        handleEvent,
        eventsApp;

    eventsApp = LearnosityEvents.init(initOptions);

    function handleEvent (e) {
        console.log(e);
        eventsApp.publish(e)
    }
    function onEvent () {
        eventsApp.on(function (e) {
            console.log(e);
        });
    }

    // To have the host page send xAPI events, pass something like the following
    // to a method that would call publish() on the Events API instance:
    /*
        handleEvent({
          "events": [
            {
              "kind": "assess_logging",
              "actor": "brianmoser",
              "verb": "progressed",
              "object": "https://xapi.learnosity.com/activities/org/1/pool/null/activity/demoactivity"
            }
          ]
        });
     */
</script>

<?php
    include_once 'includes/footer.php';
