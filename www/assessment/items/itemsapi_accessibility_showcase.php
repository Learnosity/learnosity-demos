<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_template_id' => 'demo-activity-5',
    'activity_id'          => 'my-demo-activity',
    'name'                 => 'Accessibility Showcase',
    'session_id'           => Uuid::generate(),
    'user_id'              => $studentid,
    'config'               => array(
        'title'    => 'Accessibility Showcase',
        'subtitle' => 'Walter White',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        )
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
            }
        },
        activity = <?php echo $signedRequest; ?>,
        itemsApp = LearnosityItems.init(activity, eventOptions);
</script>

<?php
    // include_once 'views/modals/settings-items.php';
    // include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
