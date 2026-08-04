<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

$activityRef = filter_input(INPUT_GET, 'activity_reference', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'gallery_1']]);
$studentid = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'demo_student']]);

include './includes/itemsRequest.php';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">

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
            <span class="bi bi-chevron-left" aria-hidden="true"></span>
            <span class="visually-hidden">Previous Question</span>
        </button>
        <div class="row">
            <?php foreach ($items as $reference) { ?>
            <div class="col-md-4 pod">
                <div class="pod-inner">
                    <div class="gallery-card clearfix">
                        <span class="learnosity-item" data-reference="<?php echo $reference; ?>"></span>
                        <div style="padding-top: 25px; position: relative;">
                            <button type="button" class="btn btn-outline-secondary btn-sm cancel float-start">Close</button>
                            <div class="alert alert-info alert-saved collapse" role="alert">
                                <p>Question saved</p>
                            </div>
                            <div class="spinner collapse"><img src="/static/images/spinner.gif"></div>
                            <button type="button" class="btn btn-primary save float-end">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <ul class="gallery-pagination">
            <?php foreach ($items as $i => $reference) { ?>
                <li>
                    <button type="button" title="Question #<?= $i + 1; ?>"><span class="visually-hidden">Question #<?= $i + 1; ?></span></button>
                </li>
            <?php } ?>
        </ul>
        <button type="button" class="gallery-button gallery-button-next" title="Next Question">
            <span class="bi bi-chevron-right" aria-hidden="true"></span>
            <span class="visually-hidden">Next Question</span>
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
        cards = [...document.querySelectorAll('.gallery-card')],
        lastCardIndex = cards.length -1,
        cardIndex,
        nextCardIndex,
        eventsApp;

    initOptions.config = {
        eventbus: true
    };
    eventsApp = LearnosityEvents.init(initOptions);

    function init () {
        document.querySelectorAll('.gallery-card').forEach(function (cardEl) {
            cardEl.addEventListener('click', function () {
                cardIndex = cards.indexOf(this);
                if (!this.classList.contains('active')) {
                    toggleItem(this.querySelector('div.learnosity-item'), this, true);
                }
                pagination(cardIndex);
            });
        });

        document.querySelectorAll('.gallery-card .save').forEach(function (saveEl) {
            saveEl.addEventListener('click', function (event) {
                var card = this.closest('.gallery-card');
                var item = card.querySelector('div.learnosity-item');
                card.querySelectorAll('.spinner').forEach(function (spinner) {
                    spinner.style.display = '';
                });
                saveItem(item.dataset.reference);
                event.preventDefault();
            });
        });

        document.querySelectorAll('.gallery-card .cancel').forEach(function (cancelEl) {
            cancelEl.addEventListener('click', function (event) {
                var card = this.closest('.gallery-card');
                toggleItem(card.querySelector('div.learnosity-item'), card);
                event.preventDefault();
            });
        });

        document.querySelectorAll('.gallery-button').forEach(function (button) {
            button.addEventListener('click', function () {
                if (this.classList.contains('gallery-button-next') && cardIndex !== lastCardIndex) {
                    nextCardIndex = cardIndex + 1;
                } else if (cardIndex !== 0) {
                    nextCardIndex = cardIndex - 1;
                }
                showNextCard();
            });
        });

        document.querySelectorAll('.gallery-pagination li').forEach(function (pageItem) {
            pageItem.addEventListener('click', function () {
                var items = [...document.querySelectorAll('.gallery-pagination li')];
                var paginationIndex = items.indexOf(this);
                if (paginationIndex !== cardIndex) {
                    nextCardIndex = paginationIndex;
                    showNextCard();
                }
            });
        });
    }

    function pagination (cardIndex) {
        var paginationItem;

        document.querySelectorAll('.gallery-button-prev').forEach(function (button) {
            button.disabled = cardIndex === 0;
        });
        document.querySelectorAll('.gallery-button-next').forEach(function (button) {
            button.disabled = cardIndex === lastCardIndex;
        });

        var paginationItems = document.querySelectorAll('.gallery-pagination li');
        paginationItems.forEach(function (pageItem) {
            pageItem.classList.remove('active');
        });
        paginationItem = paginationItems[cardIndex];
        if (paginationItem) {
            paginationItem.classList.add('active');
        }
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
            attempted = items.indexOf(reference) !== -1;
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
        var currentCard = cards[cardIndex],
            currentItem = currentCard.querySelector('div.learnosity-item'),
            nextCard = cards[nextCardIndex],
            nextItem = nextCard.querySelector('div.learnosity-item');

        var currentPod = currentItem.closest('.pod');
        currentPod.classList.add('col-md-4');
        currentPod.style.display = 'none';
        currentCard.classList.remove('active');

        var nextPod = nextItem.closest('.pod');
        nextPod.classList.remove('col-md-4');
        fadeIn(nextPod, 400);
        nextCard.classList.add('active');

        cardIndex = nextCardIndex;
        pagination(cardIndex);
    }

    function toggleItem (item, card, showCard) {
        document.querySelectorAll('.pod').forEach(function (pod) {
            pod.style.display = pod.style.display === 'none' ? '' : 'none';
        });
        if (!showCard) {
            document.querySelector('.gallery').classList.remove('gallery-card-active');
        }

        var pod = item.closest('.pod');
        pod.classList.toggle('col-md-4');

        var isHidden = pod.style.display === 'none';
        var animation = isHidden ? fadeOut(pod, 400) : fadeIn(pod, 400);
        animation.then(function () {
            if (showCard) {
                document.querySelector('.gallery').classList.add('gallery-card-active');
            }
        });

        card.classList.toggle('active');
    }

    function toggleSavedMessage (response_ids) {
        document.querySelectorAll('.spinner').forEach(function (spinner) {
            spinner.style.display = 'none';
        });
        document.querySelectorAll('.alert-saved').forEach(function (alert) {
            alert.style.display = '';
            fadeOut(alert, 2000);
        });
    }
</script>

<?php
    include_once 'includes/footer.php';
