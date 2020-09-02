<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$itemRef = filter_input(INPUT_GET, 'ref', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$request = array(
    'user_id'        => 'demo_student',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'course_id'      => 'course_id',
    'type'           => 'local_practice',
    'rendering_type' => 'inline',
    'items'          => [$itemRef]
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="section">
    <span class="learnosity-item" data-reference="<?php echo $itemRef; ?>"></span>
    <button type="button" class="btn btn-primary" onclick="location.href='./'">Back &laquo;</button>
</div>

<!-- Container for the items api to load into -->
<script src="<?php echo $url_items; ?>"></script>
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
