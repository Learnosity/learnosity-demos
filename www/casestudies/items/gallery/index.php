<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

// Which activity do you want to load?
$activityRef = 'gallery_1';

/*
 * The only reason we're using the Data API here is to
 * retrieve the item references necessary to create a
 * DOM node (to load an item into).
 * This call would ideally be cached by the host page.
 */
$DataApi = new DataApi();
$response = $DataApi->request(
    'https://data.learnosity.com/latest/itembank/activities',
    $security,
    $consumer_secret,
    ['references' => [$activityRef]]
);

if (!$response->getError()['code']) {
    $activity = json_decode($response->getBody(), true)['data'];
    $glossaryCards = $activity[0]['data']['items'];
}

// Setup your request object as usual
$request = array(
    'user_id'              => $studentid,
    'name'                 => 'Items API demo - Inline Activity.',
    'state'                => 'initial',
    'activity_id'          => 'itemsinlinedemo',
    'session_id'           => Uuid::generate(),
    'course_id'            => $courseid,
    'type'                 => 'local_practice',
    'rendering_type'       => 'inline',
    'activity_template_id' => $activityRef
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>


<style>
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

    .card {
      padding: 25px;
    }

    .card .learnosity-item {
        max-height: 210px;
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
                    <div class="card">
                        <span class="learnosity-item" data-reference="<?php echo $card; ?>"></span>
                    </div>
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
                init();
            }
        },
        init,
        itemsApp,
        loadActivity;

    itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        $('.card').on('click', function (el) {
            var $item = $(this).find('div.learnosity-item');
            loadItem($item);
        });
    }

    function loadItem(item, card) {
        location.href = 'card.php?ref=' + $(item).attr('data-reference');
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
