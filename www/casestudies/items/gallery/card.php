<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$activityRef = $_GET['set'];
$itemRef = $_GET['ref'];

$request = array(
    'user_id'        => $studentid,
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'course_id'      => $courseid,
    'type'           => 'local_practice',
    'rendering_type' => 'inline',
    'items'          => [$itemRef]
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="section">
    <span class="learnosity-item" data-reference="<?php echo $itemRef; ?>"></span>
    <button type="button" class="btn btn-primary" onclick="location.href='./cardset.php?set=<?php echo $activityRef ?>'">Back &laquo;</button>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                init();
            }
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
