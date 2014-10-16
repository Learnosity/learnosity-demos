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

$users = explode(',', $_GET['users']);

$request  = array(
    'reports' => array(
        array(
            'id'             => 'activitystatus-1',
            'render'         => false,
            'type'           => 'live-activitystatus-by-user',
            'activity'       => array(
                'id' => 'itemsinlinedemo'
            ),
            'users' => array_map(function ($user) use ($consumer_secret) {
                return array(
                    'id'   => $user,
                    'hash' => hash('sha256', $user . $consumer_secret)
                );
            }, $users)
        )
    )
);

$init = new Init('reports', $security, $consumer_secret, $request);
$reportsRequest = $init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>Items API &amp; Reports API – Gallery Report</h1>
        <p>Demonstrates how you can combine Items API and Reports API to create a custom report with live updates.</p>
    </div>
</div>

<div class="gallery-section section">
    <section class="gallery">
        <div class="row">
            <?php foreach ($items as $reference) { ?>
            <div class="col-md-4 pod">
                <div class="pod-inner">
                    <div class="card report">
                        <span class="learnosity-item" data-reference="<?php echo $reference; ?>"></span>
                        <button type="button" class="btn btn-primary save">Save</button>
                        <div class="item-status" id="<?php echo $reference; ?>">
                            <span class="status-text" data-toggle="tooltip" data-original-title="">
                                <span class="users-attempted">0</span> /
                                <span class="total-users"><?php echo count($users); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script src="//reports.staging.learnosity.com/"></script>
<script>
    var itemsInit = <?php echo $itemsRequest; ?>,
        reportsInit = <?php echo $reportsRequest; ?>,
        eventOptions = {
            readyListener: function () {
                init();
            }
        },
        itemsApp = LearnosityItems.init(itemsInit),
        reportsApp = LearnosityReports.init(reportsInit, eventOptions),
        scoresByItemByUser = {};

    function init() {
        reportsApp.getReport('activitystatus-1').on('scored', function (event) {
            var data = event.object.definition.extensions.data;
            var userId = event.actor.account.name;

            updateScores(data.itemReference, userId, data);
        });
    }

    function updateScores(itemReference, userId, score) {
        var $itemStatus = $('.item-status#' + itemReference);

        if ($itemStatus.length != 1) {
            return;
        }

        if (!scoresByItemByUser[itemReference]) {
            scoresByItemByUser[itemReference] = {};
        }
        scoresByItemByUser[itemReference][userId] = score;

        var countAttempted = 0;
        var countPassed = 0;
        for (userId in scoresByItemByUser[itemReference]) {
            countAttempted++;

            var userScore = scoresByItemByUser[itemReference][userId];
            if (userScore.score == userScore.maxScore) {
                countPassed++;
            }
        }
        $('.users-attempted', $itemStatus).text(countAttempted);

        var $card = $itemStatus.closest('.card');
        if (countPassed >= countAttempted - countPassed) {
            $card.addClass('passing');
            $card.removeClass('failing');
        } else {
            $card.addClass('failing');
            $card.removeClass('passing');
        }

        $('.status-text', $itemStatus).attr(
            'data-original-title',
            getStatusTooltip(scoresByItemByUser[itemReference])
        );
    }

    function getStatusTooltip(scoresByUser) {
        var text = "";
        for (var userId in scoresByUser) {
            text += userId + ':&nbsp;' + scoresByUser[userId].score + '<br />';
        }
        return text;
    }

    $('.status-text').tooltip({html: true});
</script>

<?php
    include_once 'includes/footer.php';
