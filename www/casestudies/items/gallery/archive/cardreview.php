<?php

include_once '../../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$itemRef = 'gallery_1_1';

$request = array(
    'user_id'        => $studentid,
    'state'          => 'review',
    'session_id'     => Uuid::generate(),
    'type'           => 'local_practice',
    'rendering_type' => 'inline',
    'items'          => [$itemRef]
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="section">
    <span class="learnosity-item" data-reference="<?php echo $itemRef; ?>"></span>
</div>

<!-- Container for the items api to load into -->
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
