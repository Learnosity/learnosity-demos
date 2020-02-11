<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'activity_id' => 'activity-1',
    'name' => 'Science Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => 505,
    'items' => [
        'Sci-Demo-1',
        'Sci-Demo-2',
        'Sci-Demo-3',
    ],
    'state' => 'resume',
    'config' => [
        'title' => 'Activity 1',
        'subtitle' => 'Science Stage 1',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => true
        ]
    ]
];

$init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

$request = [
    'activity_id' => 'activity-2',
    'name' => 'English Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => 505,
    'items' => [
        'Gram-1',
        'Gram-2',
        'Gram-3',
    ],
    'state' => 'resume',
    'config' => [
        'title' => 'Activity 2',
        'subtitle' => 'English Stage 1',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => true
        ]
    ]
];

$init = new Init('items', $security, $consumer_secret, $request);
$signedRequest2 = $init->generate();

$request = [
    'activity_id' => 'activity-3',
    'name' => 'Geography Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => '$ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => 505,
    'items' => [
        'Au-Demo-1',
        'Au-Demo-2',
        'Au-Demo-3'
    ],
    'state' => 'resume',
    'config' => [
        'title' => 'Activity 3',
        'subtitle' => 'Geography Stage 1',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false,
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ],
        'questions_api_init_options' => [
            'show_distractor_rationale' => true
        ]
    ]
];

$init = new Init('items', $security, $consumer_secret, $request);
$signedRequest3 = $init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#" data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Manage Multiple Items API Instances in a Single Page App</h2>
            <p>This demo illustrates best practices for managing the lifecycle of Items API instances in a single page app.</p>
            <p>In a single page app, we’ll often want to create and destroy views. When these views contain Items API assessments, that means we’ll also want to create or destroy the corresponding <code>itemsApp</code> instances. To achieve this, we can use the <a href="https://reference.learnosity.com/items-api/methods#init"><code>LearnosityItems.init()</code></a> and <a href="https://reference.learnosity.com/items-api/methods#itemsApp-Reset"><code>itemsApp.reset()</code></a> methods, and integrate <a href="https://reference.learnosity.com/items-api/events#assessmentEvents">Items API events</a> with our single page app.</p>
            <p>Note that the activity list and navigation aren’t provided by Items API – they’re a basic example of how a single page app might function.</p>
        </div>
    </div>

    <style>
        .section.pad-sml {
            min-height: calc(4.75rem + 513px);
            overflow: hidden;
            padding: 1.875rem;
        }
        .view {
            float: left;
            margin-right: -100%;
            transition: opacity 0.25s ease, transform 0.25s ease;
            width: 100%;
        }
        .view-hidden {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-100%);
            user-select: none;
        }
        :not(.view-hidden) ~ .view-hidden {
            transform: translateX(100%);
        }
        .navigation-list {
            border-top: 1px solid #ddd;
            line-height: 1.25;
            list-style: none;
            margin: 10px;
            padding: 0;
        }
        .navigation-item {
            border-bottom: 1px solid #ddd;
            color: inherit;
            display: block;
            padding: 0.9rem 1.1rem;
        }
        .navigation-item:hover {
            background-color: #f8f8f8;
            text-decoration: none;
        }
        .navigation-item:active {
            background-color: #ef3232;
            color: #fff;
        }
        .navigation-restore {
            display: inline-block;
            margin: -10px 0 -9px;
            padding: 10px 14px 10px 24px;
            line-height: 1;
        }
        .navigation-restore::before {
            content: "\2190";
            display: inline-block;
            margin: 0 0.25em 0 -1.75em;
            text-decoration: none;
            text-align: right;
            width: 1.5em;
        }
        h3 {
            margin: 0 10px 0.9rem;
            padding: 0 1.1rem;
        }
    </style>

    <div class="section pad-sml">
        <div id="activities" class="view">
            <h3>All Activities</h3>
            <ul class="navigation-list">
                <li><a href="#activity-1" class="navigation-item"><b>Activity 1</b><br>Science Stage 1</a></li>
                <li><a href="#activity-2" class="navigation-item"><b>Activity 2</b><br>English Stage 1</a></li>
                <li><a href="#activity-3" class="navigation-item"><b>Activity 3</b><br>Geography Stage 1</a></li>
            </ul>
        </div>
        <div id="activity-detail" class="view view-hidden">
            <a href="#activities" class="navigation-restore">Back to All Activities</a>
        </div>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        // A list of Items API initialization options for all activities.
        //
        // In a real app, the init options would be fetched or generated
        // upon request, such as by customizing the getInitializationObject()
        // function below. This demo has been simplified to focus on the
        // interaction with Items API.
        //
        // Important notes:
        //
        // * Items API does not provide the ability to display and manage
        //   this list itself -- these features are left up to the host app.
        //
        // * The session_id used for each activity should be unique, not
        //   shared across multiple activities.
        //
        var allActivities = [
            <?php echo $signedRequest; ?>,
            <?php echo $signedRequest2; ?>,
            <?php echo $signedRequest3; ?>
        ];

        var callbacks = {
            readyListener: function() {
                itemsAppStatus.isReady = true;
                console.log('Items API initialization completed for activity "%s"', itemsAppStatus.appId);
            },
            errorListener: function(error) {
                console.log('Items API initialization failed for activity "%s"', itemsAppStatus.appId, error);
            }
        };

        var activityListElement = document.getElementById('activities');
        var activityDetailElement = document.getElementById('activity-detail');
        var showActivityButtons = document.querySelectorAll('.navigation-item');
        var showActivityListButton = document.querySelector('.navigation-restore');

        var itemsAppStatus = null;
        var itemsApp = null;

        function createItemsAppStatus(appId) {
            return {
                appId: appId,
                isActive: false,
                isReady: false,
                testStartEventObserved: false
            };
        }

        /**
         * Create and return an Items API instance with the given
         * initializationObject.
         */
        function createItemsApp(initializationObject, itemsAppStatus) {
            itemsAppStatus.isReady = false;
            itemsAppStatus.testStartEventObserved = false;

            // An element with id matching itemsAppStatus.appId must be
            // present in the DOM before calling LearnosityItems.init().
            insertItemsAppContainerElement(itemsAppStatus.appId);

            var itemsApp = LearnosityItems.init(initializationObject, itemsAppStatus.appId, {
                readyListener: function() {
                    itemsAppStatus.isReady = true;
                }
            });

            itemsApp.once('test:start', function() {
                itemsAppStatus.testStartEventObserved = true;
            });

            itemsAppStatus.isActive = true;

            return itemsApp;
        }

        /**
         * Destroy the itemsApp instance and remove its container element
         * from the document. This will discard any unsaved changes.
         *
         * This method is useful when saving changes to the session is not
         * desired, such as when using Items API with type: "local_practice".
         */
        function destroyItemsApp(itemsApp, itemsAppStatus) {
            if (itemsAppStatus.isActive) {
                itemsApp.reset();
            }

            itemsAppStatus.isActive = false;
            removeItemsAppContainerElement(itemsAppStatus.appId);
        }

        /**
         * Destroy the itemsApp instance and remove its container element
         * from the document. This will attempt to save any changes made
         * within the session prior to destroying the itemsApp instance.
         */
        function saveAndDestroyItemsApp(itemsApp, itemsAppStatus) {
            if (isSavingRequired(itemsApp, itemsAppStatus)) {
                // Save this session before destroying the itemsApp instance.
                itemsApp.save();

                // We must wait to receive either a 'test:save:success' or a
                // 'test:save:error' event before calling itemsApp.reset(),
                // since resetting the itemsApp instance will stop all events
                // firing. (Saving will not be interrupted, but we will never
                // know whether it succeeded without these events.)
                itemsApp.once('test:save:success', function() {
                    itemsApp.reset();
                });

                itemsApp.once('test:save:error', function(error) {
                    // An error has occurred. This might be an opportunity to
                    // retry itemsApp.save() after a suitable
                    // back-off delay, or to display an error message to the
                    // student.
                    var activityId = itemsAppStatus.appId;
                    console.log('Unable to save changes to activity "%s"', activityId, error);
                    itemsApp.reset();
                });
            } else if (itemsAppStatus.isActive) {
                // There are no changes to save because the itemsApp instance
                // did not complete initialization or the student has not
                // started the test, so reset() can be called immediately.
                itemsApp.reset();
            }

            itemsAppStatus.isActive = false;
            removeItemsAppContainerElement(itemsAppStatus.appId);
        }

        function isSavingRequired(itemsApp, itemsAppStatus) {
            // Before calling itemsApp.save(), we must also check:
            //
            // (a) itemsAppStatus.isActive to ensure the itemsApp.reset() method
            //     has not already been called. Calling any itemsApp method after
            //     reset() will cause a JavaScript error to be thrown.
            //
            // (b) itemsAppStatus.isReady to ensure the readyListener callback
            //     was called and the itemsApp instance has loaded and is ready
            //     to use. Calling itemsApp.save() before readyListener is called
            //     may result in a JavaScript error being thrown.
            //
            // (c) itemsAppStatus.testStartEventObserved to ensure the 'test:start'
            //     event has fired. Prior to observing this event, any calls to
            //     itemsApp.save() (and itemsApp.submit()) will not trigger the
            //     subsequent 'test:save:success' or 'test:save:error' events,
            //     which we rely upon to know when saving has completed.
            //
            if (!itemsAppStatus.isActive || !itemsAppStatus.isReady || !itemsAppStatus.testStartEventObserved) {
                return false;
            }

            // Saving is not allowed in the following activity states:
            var activityState = itemsApp.getActivity().state;
            if (activityState === 'preview' || activityState === 'review') {
                return false;
            }

            // If we only need to save changes to responses, and not also
            // the test timer's value and currently selected item, we could
            // skip saving when itemsApp.safeToUnload() returns true.
            //
            // In this example, we want the test timer and current item to
            // persist, so the following check is omitted.
            //
            // if (itemsApp.safeToUnload()) {
            //     return false;
            // }

            return true;
        }

        function insertItemsAppContainerElement(id) {
            var containerElement = document.createElement('div');
            containerElement.id = id;
            activityDetailElement.appendChild(containerElement);
        }

        function removeItemsAppContainerElement(id) {
            var containerElement = id && document.getElementById(id);
            if (containerElement) {
                containerElement.parentNode.removeChild(containerElement);
            }
        }

        function getInitializationObject(activityId) {
            for (var i = 0; i < allActivities.length; i++) {
                if (allActivities[i].request.activity_id === activityId) {
                    return allActivities[i];
                }
            }

            return null;
        }

        function showActivityDetailView() {
            activityListElement.classList.add('view-hidden');
            activityDetailElement.classList.remove('view-hidden');
        }

        function showActivityListView() {
            activityDetailElement.classList.add('view-hidden');
            activityListElement.classList.remove('view-hidden');
        }

        // Attach event listeners for navigation actions:
        for (var i = 0; i < showActivityButtons.length; i++) {
            showActivityButtons[i].addEventListener('click', onClickShowActivityButton);
        }

        showActivityListButton.addEventListener('click', onClickShowActivityListButton);

        function onClickShowActivityButton(event) {
            event.preventDefault();

            var activityId = event.currentTarget.hash.replace('#', '');
            var initializationObject = getInitializationObject(activityId);

            if (initializationObject) {
                itemsAppStatus = createItemsAppStatus(activityId);
                itemsApp = createItemsApp(initializationObject, itemsAppStatus);

                showActivityDetailView();

                // Add event listeners to handle when the student finishes the test:
                itemsApp.on('test:finished:discard test:finished:save test:finished:submit', onFinishTest);
            } else {
                console.log('Activity "%s" not found', activityId);
            }
        }

        function onClickShowActivityListButton(event) {
            event.preventDefault();
            saveAndDestroyItemsApp(itemsApp, itemsAppStatus);
            showActivityListView();
        }

        function onFinishTest() {
            saveAndDestroyItemsApp(itemsApp, itemsAppStatus);
            showActivityListView();
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
