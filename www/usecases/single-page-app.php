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

$request1 = [
    'activity_id' => 'activity-1',
    'name' => 'Science Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => 'ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-1'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-2'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Sci-Demo-3'
        ],
    ],
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

$init1 = new Init('items', $security, $consumer_secret, $request1);
$signedRequest = $init1->generate();

$request2 = [
    'activity_id' => 'activity-2',
    'name' => 'English Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => 'ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        
        [
            'id' => Uuid::generate(),
            'reference' => 'Gram-1',
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Gram-2',
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Gram-3',
        ]
    ],
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

$init2 = new Init('items', $security, $consumer_secret, $request2);
$signedRequest2 = $init2->generate();

$request3 = [
    'activity_id' => 'activity-3',
    'name' => 'Geography Stage 1',
    'type' => 'submit_practice',
    'rendering_type' => 'assess',
    'user_id' => 'ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'Au-Demo-1'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Au-Demo-2'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Au-Demo-3'
        ]
    ],
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

$init3 = new Init('items', $security, $consumer_secret, $request3);
$signedRequest3 = $init3->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#" data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Manage Multiple Items API Instances in a Single Page App</h2>
            <p>This example illustrates best practices for managing the lifecycle of Items API instances in a single page app. See <a href="https://help.learnosity.com/hc/en-us/articles/360006013058">Guidelines for Using Items API with a Single Page App Architecture</a> for details about this approach.</p>
            <p>In a typical single page app, views are created and destroyed frequently. If such a view contains an Items API assessments, we'll also want to create or destroy its corresponding <code>itemsApp</code> instance. To achieve this, we can use the <a href="https://reference.learnosity.com/items-api/methods/LearnosityItems/init"><code>LearnosityItems.init()</code></a> and <a href="https://reference.learnosity.com/items-api/methods/itemsApp/reset"><code>itemsApp.reset()</code></a> methods, and integrate <a href="https://reference.learnosity.com/items-api/events">Items API events</a> with our single page app.</p>
            <p>Note that the Activity list and navigation aren't provided by Items API. They're a basic example of how a single page app might function.</p>
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
        // * Items API does not provide the ability to display and manage
        //   this list itself -- these features are left up to the host app.
        // * The session_id used for each activity should be unique, not
        //   shared across multiple activities.
        var allActivities = [
            <?php echo $signedRequest; ?>,
            <?php echo $signedRequest2; ?>,
            <?php echo $signedRequest3; ?>
        ];

        var itemsAppStatus = null;
        var itemsApp = null;

        var activityListElement = document.getElementById('activities');
        var activityDetailElement = document.getElementById('activity-detail');
        var showActivityButtons = document.querySelectorAll('.navigation-item');
        var showActivityListButton = document.querySelector('.navigation-restore');

        // Attach event listeners for navigation actions:
        for (var i = 0; i < showActivityButtons.length; i++) {
            showActivityButtons[i].addEventListener('click', onClickShowActivityButton);
        }

        showActivityListButton.addEventListener('click', onClickShowActivityListButton);

        /**
         * Create an object to track the state of an associated itemsApp
         * instance, with the following properties:
         *
         * appId:
         * - A string used for the id attribute of the DOM hook element.
         *
         * isActive:
         * - An instance is active after LearnosityItems.init() is called
         *   and before itemsApp.reset() is first called.
         * - This indicates whether the itemsApp.reset() method can be
         *   called.
         *
         * isReady:
         * - Whether the readyListener callback been called.
         * - This indicates that itemsApp methods such as save() are
         *   available to be called.
         *
         * testStartEventObserved:
         * - Whether the 'test:start' assessment event has fired on the
         *   associated itemsApp instance.
         *
         * This object is passed to both the createItemsApp() and
         * destroyItemsApp() functions, which will update this state
         * as needed.
         */
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
                },
                errorListener: function() {
                    console.log('Items API initialization failed for activity "%s"', itemsAppStatus.appId);
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
         * desired, such as when using Items API with type: 'local_practice'.
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
                // firing.
                //
                // Note that calling reset() won't interrupt a save or submit
                // in progress, but it will stop events firing, so we would
                // otherwise never know whether it succeeded without these
                // events.
                itemsApp.on('test:save:success', function() {
                    itemsApp.reset();
                });

                itemsApp.on('test:save:error', function(error) {
                    // An error has occurred. This might be an opportunity to
                    // retry itemsApp.save() after a suitable
                    // back-off delay, or to display an error message to the
                    // student.
                    var activityId = itemsAppStatus.appId;
                    itemsApp.reset();
                    console.log('Items API activity "%s" could not be saved', activityId, error);
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

        // Event handlers:
        function onClickShowActivityButton(event) {
            var activityId = event.currentTarget.hash.replace('#', '');
            var initializationObject = getInitializationObject(activityId);

            if (initializationObject) {
                console.log('Initializing Items API for activity "%s"', activityId);

                itemsAppStatus = createItemsAppStatus(activityId);
                itemsApp = createItemsApp(initializationObject, itemsAppStatus);

                showActivityDetailView();

                // Listen for Items API events:
                itemsApp.on('app:ready', onItemsAppReady);
                itemsApp.on('test:finished:discard test:finished:save test:finished:submit', onFinishTest);
                itemsApp.on('test:reset', onItemsAppReset);
            } else {
                console.log('Activity "%s" not found', activityId);
            }

            event.preventDefault();

            function onItemsAppReady() {
                console.log('Items API activity "%s" is ready for use', activityId);
            }

            function onFinishTest() {
                console.log('Items API activity "%s" was completed by the student', activityId);

                saveAndDestroyItemsApp(itemsApp, itemsAppStatus);
                showActivityListView();
            }

            function onItemsAppReset() {
                console.log('Items API activity "%s" was reset', activityId);
            }
        }

        function onClickShowActivityListButton(event) {
            console.log('The student has finished activity "%s"', itemsAppStatus.appId);

            saveAndDestroyItemsApp(itemsApp, itemsAppStatus);
            showActivityListView();

            event.preventDefault();
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
