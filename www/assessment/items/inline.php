<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$items = array('Demo3', 'Demo4', 'Demo5', 'Demo6', 'Demo7', 'Demo8', 'Demo9', 'Demo10');
$sessionid = Uuid::generate();

$request = array(
    'user_id'              => $studentid,
    'rendering_type'       => 'inline',
    'name'                 => 'Items API demo - Inline Activity.',
    'state'                => 'initial',
    'activity_id'          => 'itemsinlinedemo',
    'activity_template_id' => 'printing-demo',
    'session_id'           => $sessionid,
    'course_id'            => $courseid,
    'type'                 => 'local_practice',
    'config'               => array(
        'renderSubmitButton'  => false,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div style="padding-left: 5px;">
    <div>
        <h2>MCQ</h2>
        <span class="learnosity-item" data-reference="printing-mcq"></span>
    </div>
    <div class="page-break">
        <h2>MCQ Multi</h2>
        <span class="learnosity-item" data-reference="printing-mcq-multi"></span>
    </div>
    <div class="page-break">
        <h2>Token Highlight</h2>
        <span class="learnosity-item" data-reference="printing-token"></span>
    </div>
    <div class="page-break">
        <h2>Fill in the blanks</h2>
        <span class="learnosity-item" data-reference="printing-fillintheblank"></span>
    </div>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<style>
h2 {
    border-bottom: 1px solid #dfdfdf;
    margin-bottom: 20px;
    padding-bottom: 5px;
}
@media print {
    .page-break { display: block; page-break-before: always; }
}
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
