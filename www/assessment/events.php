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

// Simple api request object for Items API
$request = [
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo3'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo4'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo6'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo7'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo8'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo9'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'Demo10'
        ]
    ],
    'config' => [
        'title' => 'Demo activity - showcasing question types and assess options',
        'subtitle' => 'Walter White',
        'regions' => 'main',
        'navigation' => [
                'scroll_to_test' => false,
                'scroll_to_top' => false
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Bind to Items API Events</h2>
            <p>Below is a demo of event binding using the <a href="https://reference.learnosity.com/assess-api/events">Assessment Events</a> to display custom notifications.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="assess-events"></div>
        </div>
        <div class="col-sm-9">
            <div class="section pad-sml">
                <!-- Container for the author api to load into -->
                <div id="learnosity_assess"></div>
            </div>
        </div>
    </div>

    <script src="<?=$url_items?>"></script>
    <script>
        // Events array used to build DOM elements and event listeners
        const eventsArray = [
            'test:start',
            'test:pause',
            'test:resume',
            'test:save',
            'test:submit',
            'time:change',
            'test:save:success',
            'test:save:error',
            'test:submit:success',
            'test:submit:error',
            'test:finished:save',
            'test:finished:submit',
            'test:finished:discard',
            'save:activity:success',
            'save:error',
            'save:success',
            'item:setAttemptedResponse',
            'item:warningOnChange',
            'item:goto',
            'item:changing',
            'item:changed',
            'item:load',
            'item:unload',
            'item:fetch',
            'unfocused'
        ];

        // Build events list DOM elements
        eventsArray.forEach( event => {
            const container = document.createElement('div')
            const label = document.createElement('span')
            label.classList.add("assess-event-name", "event-label", event.replaceAll(":", "_"))
            label.innerHTML = event 
            container.appendChild(label)
            document.querySelector(".assess-events").appendChild(container)
        })

        // Function to iterate through events and bind listeners
        const bindEventListeners = () => {
            eventsArray.forEach( event => {
                window.itemsApp.on(event, () => {
                    els = document.querySelectorAll(`.assess-event-name.${event.replaceAll(":", "_")}`)
                    // Toggle class event to indicate in the UI the event triggered
                    els.forEach( el => {
                        el.classList.add('event-called')
                        setTimeout(function () {
                            el.classList.remove('event-called')
                        }, 800)
                    })
                })
            })
        }

        // Optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log('Items API has successfully initialized.')
                bindEventListeners()
            },
            errorListener: function (err) {
                console.log(err)
            }
        }

        const initializationObject = <?=$signedRequest?>;
        window.itemsApp = LearnosityItems.init(initializationObject, callbacks);

    </script>

    <style type="text/css">
        .event-label {
            -webkit-transition: all 300ms ease-in-out;
            -moz-transition: all 300ms ease-in-out;
            -ms-transition: all 300ms ease-in-out;
            -o-transition: all 300ms ease-in-out;
            transition: all 300ms ease-in-out;
            color: black;
            padding: 5px;
            border-radius: 5px;
        }

        .event-called {
            background-color: #878787;
            color: #ededed;
        }

        .assess-events {
            padding: 15px;
            font-size: 14px;
            background-color: white;
            position: relative;
        }

        .assess-events > div {
            margin-bottom: 8px;
        }

        .assess-wrapper {
            min-height: 510px;
        }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
