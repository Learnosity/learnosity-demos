<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$consumer_secret = 'nx5IpYOHvhdI5I2b1Sb5zeIp2B8bAzJ06s13nHcI';
$security = array(
    'consumer_key' => 'khkysmTHU27hp6Kz',
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$items = array("11292013144416832115","11292013144427336251",
"11292013144718150482","11292013144721732855","11292013144724305687",
"11292013144729048364","11292013144754443320",
"11292013145201280334",
"11292013145234142541","11292013145236854307","11292013145240465701","11292013150834002104",
"11292013151638547016","11292013151643431684","11292013151648063441","11292013151653205180",
"11292013151702327626",
"11292013151857200272","11292013151901242304","11292013151904175682","11292013151907405381",
"11292013151909853141","11292013151914810348",
"11292013152150437766",
"11292013152215834361","11292013152218347434","11292013152222254673","11292013152225221425",
"11292013152230374166",
"11292013152258571718","11292013152301007341","11292013152543110645",
"11292013152547146638",
"03192014095522645226","03192014095921067603","03192014100000773870","03192014100009834605");
$sessionid = Uuid::generate();

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => $sessionid,
    'course_id'      => $courseid,
    'items'          => $items,
    'type'           => 'submit_practice',
    'config'         => array(
        "renderSaveButton"    => false,
        "renderSubmitButton"  => false,
        "ignore_validation"   => false,
        'questionsApiVersion' => 'v2'
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Inline</h1>
    </div>
</div>

<div class="section">
    <br>
    <p>
        <?php foreach ($items as $item) { ?>
        <span class="learnosity-item" data-reference="<?= $item; ?>"></span>
        <?php } ?>
        <span class="learnosity-submit-button"></span>
    </p>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
            }
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
