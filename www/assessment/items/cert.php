<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$sessionid = Uuid::generate();

// HMH1 CERT credentials
$consumer_key = 'HMHLOPnjoBojCdTx';
$consumer_secret = 'XvPhUgCIBtH8ZBPhHpzf1gieLosR9nCgHA7Cj8PB';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_template_id' => '15AVEGK',
    'item_pool_id'         => 'ELA_Betapool_012315',
    'activity_id'          => 'cert-demo',
    'user_id'              => $studentid,
    'rendering_type'       => 'assess',
    'name'                 => 'cert-demo',
    'state'                => 'initial',
    'session_id'           => $sessionid,
    'course_id'            => $courseid,
    'type'                 => 'submit_practice'
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – CERT</h1>
    </div>
</div>

<div class="section">
    <h3>CERT Test</h3>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <!-- Container for the item to load into -->
            <div id="learnosity_assess"></div>
        </div>
    </div>
</div>
<script src="//items-ca.learnosity.com"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
