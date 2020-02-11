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
    'name' => 'Activity 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6',
        'act8'
    ],
    'config' => [
        'title' => 'Activity 1',
        'subtitle' => 'Single Page App Demo',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ]
    ],
    'state' => 'resume'
];

$init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

$request = [
    'activity_id' => 'activity-2',
    'name' => 'Activity 2',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6',
        'act8'
    ],
    'config' => [
        'title' => 'Activity 2',
        'subtitle' => 'Single Page App Demo',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ]
    ],
    'state' => 'resume'
];

$init = new Init('items', $security, $consumer_secret, $request);
$signedRequest2 = $init->generate();

$request = [
    'activity_id' => 'activity-3',
    'name' => 'Activity 3',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6',
        'act8'
    ],
    'config' => [
        'title' => 'Activity 3',
        'subtitle' => 'Single Page App Demo',
        'regions' => 'main',
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false,
        ],
        'configuration' => [
            'onsave_redirect_url' => false,
            'onsubmit_redirect_url' => false
        ]
    ],
    'state' => 'resume'
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
            <h2>Single Page App Example</h2>
            <p>This example demonstrates best practices for the lifecycle of creating and destroying Items API instances within a basic single page app.<p>
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
                <li><a href="#activity-1" class="navigation-item"><b>Activity 1</b><br>Single Page App Demo</a></li>
                <li><a href="#activity-2" class="navigation-item"><b>Activity 2</b><br>Single Page App Demo</a></li>
                <li><a href="#activity-3" class="navigation-item"><b>Activity 3</b><br>Single Page App Demo</a></li>
            </ul>
        </div>
        <div id="activity-detail" class="view view-hidden">
            <a href="#activities" class="navigation-restore">Back to All Activities</a>
        </div>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var allActivities = [
            <?php echo $signedRequest; ?>,
            <?php echo $signedRequest2; ?>,
            <?php echo $signedRequest3; ?>
        ];

        var callbacks = {
            readyListener: function() {
                appState.itemsAppIsReady = true;
                console.log('Items API initialization completed for activity "%s"', appState.activityId);
            },
            errorListener: function(error) {
                console.log('Items API initialization failed for activity "%s"', appState.activityId, error);
            }
        };

        var activityListElement = document.getElementById('activities');
        var activityDetailElement = document.getElementById('activity-detail');
        var showActivityButtons = document.querySelectorAll('.navigation-item');
        var showActivityListButton = document.querySelector('.navigation-restore');

        var itemsApp = null;
        var appState = {};

        resetAppState();

        function resetAppState() {
            itemsApp = null;
            appState.activityId = null;
            appState.itemsAppIsReady = false;
            appState.testStartEventObserved = false;
        }

        function createItemsApp(initializationObject) {
            appState.activityId = initializationObject.request.activity_id;
            insertItemsAppContainerElement(appState.activityId);
            itemsApp = LearnosityItems.init(initializationObject, '#' + appState.activityId, callbacks);

            itemsApp.once('test:start', function() {
                appState.testStartEventObserved = true;
            });
        }

        /**
         * Destroy the itemsApp instance and remove its container element
         * from the document. This will discard any unsaved changes.
         *
         * This method is useful when saving changes to the session is not
         * desired, such as when using Items API with type: "local_practice".
         */
        function destroyItemsApp() {
            if (itemsApp) {
                itemsApp.reset();
            }

            if (appState.activityId) {
                removeItemsAppContainerElement(appState.activityId);
            }

            resetAppState();
        }

        /**
         * Destroy the itemsApp instance and remove its container element
         * from the document. This will attempt to save any changes made
         * within the session prior to destroying the itemsApp instance.
         */
        function saveAndDestroyItemsApp() {
            if (isSavingRequired()) {
                var activityId = appState.activityId;
                var itemsAppWithPendingSave = itemsApp;

                // Save this session before destroying the itemsApp instance.
                itemsAppWithPendingSave.save();

                // We must wait to receive either a 'test:save:success' or a
                // 'test:save:error' event before calling itemsApp.reset(),
                // since resetting the itemsApp instance will stop all events
                // firing. (Saving will not be interrupted, but we will never
                // know whether it succeeded without these events.)
                itemsAppWithPendingSave.once('test:save:success', function() {
                    itemsAppWithPendingSave.reset();
                });

                itemsAppWithPendingSave.once('test:save:error', function(error) {
                    // An error has occurred. This might be an opportunity to
                    // retry itemsAppWithPendingSave.save() after a suitable
                    // back-off delay, or to display an error message to the
                    // student.
                    console.log('Unable to save changes to activity "%s"', activityId, error);
                    itemsAppWithPendingSave.reset();
                });
            } else if (itemsApp) {
                // There are no changes to save because the itemsApp instance
                // did not complete initialization or the student has not
                // started the test, so reset() can be called immediately.
                itemsApp.reset();
            }

            if (appState.activityId) {
                removeItemsAppContainerElement(appState.activityId);
            }

            resetAppState();
        }

        function isSavingRequired() {
            if (!itemsApp) {
                return false;
            }

            var activityState = itemsApp.getActivity().state;

            // Saving is not allowed in the following states:
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

            // Before calling itemsApp.save(), we must also check:
            //
            //   (a) itemsAppIsReady ensures the readyListener callback was
            //       called and the itemsApp instance is ready to use. Calling
            //       itemsApp.save() before readyListener is called may cause
            //       a JavaScript Error to be thrown.
            //
            //   (b) testStartEventObserved ensures the 'test:start' event has
            //       fired. Before observing this event, calls to itemsApp.save()
            //       (and itemsApp.submit()) will not trigger subsequent events,
            //       which we rely upon to determine whether saving succeeded.
            return appState.itemsAppIsReady && appState.testStartEventObserved;
        }

        function insertItemsAppContainerElement(activityId) {
            var containerElement = document.createElement('div');
            containerElement.id = activityId;
            activityDetailElement.appendChild(containerElement);
        }

        function removeItemsAppContainerElement(activityId) {
            var containerElement = document.getElementById(activityId);
            if (containerElement) {
                containerElement.parentNode.removeChild(containerElement);
            }
        }

        function getInitializationObject(activityId) {
            for (var i = 0; i < allActivities.length; i++) {
                if (allActivities[i].request.activity_id === appState.activityId) {
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

            var activityId = event.currentTarget.hash.slice(1);
            var initializationObject = getInitializationObject(activityId);

            if (initializationObject) {
                appState.activityId = activityId;

                createItemsApp(initializationObject);
                showActivityDetailView();

                // Add listeners for events that fire when the student
                // has finished the test:
                itemsApp.on('test:finished:discard test:finished:save test:finished:submit', onTestFinishedEvent);
            } else {
                console.log('Activity "%s" not found', activityId);
            }
        }

        function onClickShowActivityListButton(event) {
            event.preventDefault();
            saveAndDestroyItemsApp();
            showActivityListView();
        }

        function onTestFinishedEvent() {
            saveAndDestroyItemsApp();
            showActivityListView();
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
