<?php

include_once '../../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

/*
 * Array of cardsets (activities) you want to display
 */
$activityRefs = ['gallery_1', 'gallery_2', 'gallery_3', 'gallery_4', 'gallery_5', 'gallery_6'];

/*
 * First make a request to the Data API to retrieve all
 * card sets you want to appear on this gallery page.
 *
 * This assumes that each set has an equivalent `activity`
 * in the Learnosity Authoring site.
 */
$DataApi = new DataApi();
$response = $DataApi->request(
    $url_data . '/latest/itembank/activities',
    $security,
    $consumer_secret,
    ['references' => $activityRefs]
);

/*
 * Now that you have all activities, loop over them and
 * retrieve the first item in each. That will be the item
 * used as the preview card students will click on.
 */
if (!$response->getError()['code']) {
    $activities = json_decode($response->getBody(), true)['data'];
    $glossaryCards = [];
    $cardsetRef = [];
    foreach ($activities as $i => $activity) {
        $glossaryCards[] = $activity['data']['items'][0];
        $cardsetRef[] = $activity['reference'];
    }
}

/*
 * Now that we have an array of item references, init
 * the Items API (inline mode). Use a "card" UI for each
 * item, which represents the first item of a set.
 */
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
    .excerpt-suppress {
        display: none;
    }
    .section {
        background-color: #f3f5f5;
        border: 0;
        box-shadow: none;
    }
    .gallery {
        width: 100%;
        height: 100%;
        position: relative;
    }
    .effect2,
    .card {
        position: relative;
        z-index: 1;
        background: #fff;
    }
    .effect2:before, .effect2:after {
        z-index: -1;
        position: absolute;
        content: "";
        bottom: 17px; /* Adjust this to move the shadow up/down */
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

    .card .learnosity-item {
        transform: scale(.8);
        max-height: 200px;
        height: 200px;
        overflow: hidden;
    }

    .card:before {
      cursor: pointer;
      z-index: 1;
      content: "";
      display: block;
      background: transparent;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    .pod {
        padding-bottom: 25px;
    }
</style>


<div class="section">
    <section class="gallery">
        <div class="row">
            <?php foreach ($glossaryCards as $i => $card) { ?>
            <div class="col-md-4 pod">
                <div class="effect2">
                    <div class="card" data-activity="<?php echo $cardsetRef[$i]; ?>">
                        <span class="learnosity-item" data-reference="<?php echo $card; ?>"></span>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- Container for the items api to load into -->
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                init();
            }
        },
        init,
        itemsApp,
        loadActivity;

    itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        $('.card').on('click', function (el) {
            var ref = $(this).attr('data-activity');
            loadActivity(ref);
        });
    }

    function loadActivity(ref) {
        location.href = 'cardset.php?set=' + ref;
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
