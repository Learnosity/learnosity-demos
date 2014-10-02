<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$DataApi = new DataApi();
$response = $DataApi->request(
    'https://data.learnosity.com/latest/itembank/activities',
    $security,
    $consumer_secret,
    ['references' => ['gallery_1', 'gallery_2', 'gallery_3']]
);
if (!$response->getError()['code']) {
    $activities = json_decode($response->getBody(), true)['data'];
    $glossaryCards = [];
    foreach ($activities as $i => $activity) {
        $glossaryCards[] = $activity['data']['items'][0];
    }
}



$request = array(
    'user_id'        => $studentid,
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'course_id'      => $courseid,
    'type'           => 'local_practice',
    'rendering_type' => 'inline',
    'items'          => $glossaryCards
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>


<style>
    .gallery {
        width: 100%;
        height: 100%;
        position: relative;
    }
    .card {
        transform: scale(.5);
        max-height: 200px;
        overflow: hidden;
    }
    .effect2 {
      position: relative;
    }
    .effect2:before, .effect2:after {
      z-index: -1;
      position: absolute;
      content: "";
      bottom: 15px;
      left: 10px;
      width: 50%;
      top: 80%;
      max-width:300px;
      background: #777;
      -webkit-box-shadow: 0 15px 10px #777;
      -moz-box-shadow: 0 15px 10px #777;
      box-shadow: 0 15px 10px #777;
      -webkit-transform: rotate(-3deg);
      -moz-transform: rotate(-3deg);
      -o-transform: rotate(-3deg);
      -ms-transform: rotate(-3deg);
      transform: rotate(-3deg);
    }
    .effect2:after
    {
      -webkit-transform: rotate(3deg);
      -moz-transform: rotate(3deg);
      -o-transform: rotate(3deg);
      -ms-transform: rotate(3deg);
      transform: rotate(3deg);
      right: 10px;
      left: auto;
    }
</style>


<div class="section">
    <section class="gallery">
        <div class="row">
            <?php foreach ($glossaryCards as $card) { ?>
            <div class="col-md-4">
            <div class="card effect2">
                <span class="learnosity-item" data-reference="<?php echo $card; ?>"></span>
            </div>
            </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
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
