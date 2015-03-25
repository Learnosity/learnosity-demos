<?php

include_once '../../../config.php';
include_once 'includes/header.php';

// Which activity do you want to load?
$activityRef = 'gallery_1';

if (isset($_GET['activity_reference'])) {
    $activityRef = $_GET['activity_reference'];
}

$studentid = isset($_GET['user']) ? $_GET['user'] : $studentid;

include './includes/itemsRequest.php';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API – Inline Gallery Style</h1>
        <p>Demonstrates how simply you can style each <em>item</em> in an activity.</p>
        <ul>
            <li>Student View</li>
            <li><a href="./report.php">Teacher View</a></li>
        </ul>
    </div>
</div>

<div class="gallery-section section">
    <section class="gallery">
        <button type="button" class="gallery-button gallery-button-prev" title="Previous Question">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous Question</span>
        </button>
        <div class="row">
            <?php foreach ($items as $reference) { ?>
            <div class="col-md-4 pod">
                <div class="pod-inner">
                    <div class="card clearfix">
                        <span class="learnosity-item" data-reference="<?php echo $reference; ?>"></span>
                        <div style="padding-top: 25px; position: relative;">
                            <button type="button" class="btn btn-default btn-sm cancel pull-left">Close</button>
                            <div class="alert alert-info alert-saved collapse" role="alert">
                                <p>Question saved</p>
                            </div>
                            <div class="spinner collapse"><img src="<?php echo $env['www'] ?>static/images/spinner.gif"></div>
                            <button type="button" class="btn btn-primary save pull-right">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <ul class="gallery-pagination">
            <?php foreach ($items as $i => $reference) { ?>
                <li>
                    <button type="button" title="Question #<?= $i+1; ?>"><span class="sr-only">Question #<?= $i+1; ?></span></button>
                </li>
            <?php } ?>
        </ul>
        <button type="button" class="gallery-button gallery-button-next" title="Next Question">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next Question</span>
        </button>
    </section>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script src="<?php echo $url_events; ?>"></script>
<script>
    var initOptions = <?php echo $itemsRequest; ?>,
        eventOptions = {
            readyListener: function () {
                init();
            }
        },
        itemsApp = LearnosityItems.init(initOptions, eventOptions),
        $cards = $('.card'),
        lastCardIndex = $cards.length -1,
        cardIndex,
        nextCardIndex,
        eventsApp;

    initOptions.config = {
        eventbus: true
    };
    eventsApp = LearnosityEvents.init(initOptions);

    function init () {
        $('.card').on('click', function (el) {
            cardIndex = $('.card').index(this);
            if (!$(this).hasClass('active')) {
                var $item = $(this).find('div.learnosity-item');
                toggleItem($item, $(this), true);
            }
            pagination(cardIndex);
        });

        $('.card .save').on('click', function (el) {
            var $card = $(this).closest('.card');
            var $item = $card.find('div.learnosity-item');
            $($card).find('.spinner').show();
            saveItem($item.data('reference'));
            return false;
        });

        $('.card .cancel').on('click', function (el) {
            var $card = $(this).closest('.card');
            var $item = $card.find('div.learnosity-item');
            toggleItem($item, $card);
            return false;
        });

        $('.gallery-button').on('click', function(event) {
            if ($(this).hasClass('gallery-button-next') && cardIndex !== lastCardIndex) {
                nextCardIndex = cardIndex + 1;
            } else if (cardIndex !== 0) {
                nextCardIndex = cardIndex - 1;
            }
            showNextCard();
        });

        $('.gallery-pagination li').on('click', function() {
            var paginationIndex = $('.gallery-pagination li').index(this);
            if (paginationIndex !== cardIndex) {
                nextCardIndex = paginationIndex;
                showNextCard();
            }
        });
    }

    function pagination (cardIndex) {
        var paginationItem;

        if (cardIndex === 0) {
            $('.gallery-button-prev').attr('disabled', 'disabled');
        } else {
            $('.gallery-button-prev').removeAttr('disabled');
        }
        if (cardIndex === lastCardIndex) {
            $('.gallery-button-next').attr('disabled', 'disabled');
        } else {
            $('.gallery-button-next').removeAttr('disabled');
        }

        $('.gallery-pagination li').removeClass('active');
        paginationItem = $('.gallery-pagination li')[cardIndex];
        $(paginationItem).addClass('active');
    }

    function saveItem (reference) {
        var attempted = false,
            responseIds = [],
            itemScore;

        itemsApp.save({
            success: function (response_ids) {
                toggleSavedMessage(response_ids);
            }
        });

        itemsApp.attemptedItems(function (items) {
            attempted = $.inArray(reference, items) !== -1;
        });
        if (!attempted) {
            return;
        }

        itemsApp.getItems(
            function (items) {
                responseIds = items[reference].response_ids;
            }
        );

        itemScore = {
            score: 0,
            max_score: 0
        };
        itemsApp.getScores(
            function (responses) {
                for (var i=0; i < responseIds.length; i++) {
                    var questionScore = responses[responseIds[i]];
                    if (questionScore && questionScore.max_score) {
                        itemScore.score += questionScore.score;
                        itemScore.max_score += questionScore.max_score;
                    }
                }
            }
        );

        sendEvent(reference, itemScore);
    }

    function sendEvent (reference, score) {
        eventsApp.publish({
            events: [{
                kind: 'assess_logging',
                actor: {
                    account: {
                        homePage: '<?php echo $consumer_key; ?>',
                        name: '<?php echo $studentid; ?>'
                    },
                    objectType: 'Agent'
                },
                verb: {
                    id: 'http://adlnet.gov/expapi/verbs/scored',
                    display: {
                        'en-US': 'scored'
                    }
                },
                object: {
                    id: 'https://xapi.learnosity.com/activities/org/1/pool/null/activity/' +
                        initOptions.request.activity_id + '/item/' + reference,
                    objectType: 'Activity',
                    definition: {
                        extensions: {
                            data: {
                                itemReference: reference,
                                score: score.score,
                                maxScore: score.max_score
                            }
                        }
                    }
                }
            }]
        });
    }

    function showNextCard () {
        var $currentCard = $($cards[cardIndex]),
            $currentItem = $currentCard.find('div.learnosity-item'),
            $nextCard = $($cards[nextCardIndex]),
            $nextItem = $nextCard.find('div.learnosity-item');

        $currentItem.closest('.pod').addClass('col-md-4').hide();
        $currentCard.removeClass('active');
        $nextItem.closest('.pod').removeClass('col-md-4').fadeIn();
        $nextCard.addClass('active');

        cardIndex = nextCardIndex;
        pagination(cardIndex);
    }

    function toggleItem ($item, $card, showCard) {
        $('.pod').toggle();
        if (!showCard) {
            $('.gallery').removeClass('card-active');
        }
        $item.closest('.pod').toggleClass('col-md-4').animate({
            width: "toggle",
            height: "toggle",
            opacity: "toggle"
        }, function() {
            if (showCard) {
                $('.gallery').addClass('card-active');
            }
        });

        $card.toggleClass('active');
    }

    function toggleSavedMessage (response_ids) {
        $('.spinner').hide();
        $('.alert-saved').show().fadeToggle(2000);
    }
</script>

<?php
    include_once 'includes/footer.php';
