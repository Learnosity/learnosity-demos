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
    'activity_template_id' => 'NCI_Study-2',
    'activity_id'          => 'my-demo-activity',
    'name'                 => 'NCI Test',
    'course_id'            => $courseid,
    'session_id'           => Uuid::generate(),
    'user_id'              => $studentid,
    'assess_inline'        => false,
    'config'               => array(
        'administration' => array(
            'pwd' => 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' // `password`
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
<script src="//items.learnosity.com"></script>
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
