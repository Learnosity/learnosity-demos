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

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Inline Gallery Style</h1>
        <p>Demonstrates how simply you can style each <em>item</em> in an activity.</p>
    </div>
</div>

<div class="gallery-section section">
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
