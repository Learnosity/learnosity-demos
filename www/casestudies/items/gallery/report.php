<?php

include_once '../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;

// Which activity do you want to load?
$activityRef = 'gallery_1';

if (isset($_GET['activity_reference'])) {
    $activityRef = $_GET['activity_reference'];
}

include './itemsRequest.php';

$security = array(
    'consumer_key' => $consumer_key,
    'user_id'      => $teacherid,
    'domain'       => $domain
);

$request  = array(
    'reports' => array(
        array(
            'id'             => 'report-1',
            'render'         => false,
            'type'           => 'live-activitystatus-by-user',
            'activity'       => array(
                'title' => 'Demo Test'
            ),
            'users' => array(
                array(
                    'id'   => $studentid,
                    'name' => 'Jesse Pinkman',
                    'hash' => hash('sha256', $studentid . $consumer_secret)
                )
            )
        )
    )
);

$init = new Init('reports', $security, $consumer_secret, $request);
$reportsRequest = $init->generate();

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
            <?php foreach ($items as $reference) { ?>
            <div class="col-md-4 pod">
                <div class="pod-inner">
                    <div class="card">
                        <span class="learnosity-item" data-reference="<?php echo $reference; ?>"></span>
                        <button type="button" class="btn btn-primary save">Save</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script src="//reports.learnosity.com/"></script>
<script>
    var itemsInit = <?php echo $itemsRequest; ?>,
        reportsInit = <?php echo $reportsRequest; ?>,
        eventOptions = {
            readyListener: function () {
                // init();
            }
        },
        itemsApp = LearnosityItems.init(itemsInit, eventOptions),
        reportsApp = LearnosityReports.init(reportsInit);
</script>

<?php
    include_once 'includes/footer.php';
