<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//alias(es) to eliminate the need for fully qualified classname(s) from sdk
use LearnositySdk\Request\Init;

//security object. timestamp added by SDK
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

//simple api request object for item list view
$request = [
    'mode' => 'item_list',
    'config' => [
        'item_edit' => [
            'item' => [
                'reference' => [
                    'edit' => true,
                ],
                'dynamic_content' => true,
                'shared_passage' => true
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Bind to Authoring Events</h2>
        <p>Better integrate Learnosity's authoring environment with your content management system. This demo shows how to bind to authoring events using the <a href="https://docs.learnosity.com/authoring/author/events#on">'on' public method</a> for custom notifications and other helpful reactions that you may require.</p>
        <p>As you work with the Author API below, actions will trigger a visual change to the corresponding event name in the list above the UI.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12 author-events0"></div>
    <div class="col-md-3 col-sm-6 col-xs-12 author-events1"></div>
    <div class="col-md-3 col-sm-6 col-xs-12 author-events2"></div>
    <div class="col-md-3 col-sm-6 col-xs-12 author-events3"></div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="section pad-sml">
            <!-- Container for the author api to load into -->
            <div id="learnosity-author"></div>
        </div>
    </div>
</div>

<!-- version of api maintained in lrn_config.php file -->
<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initializationObject = <?php echo $signedRequest; ?>;

    // event array used to build DOM elemnts and event listeners
    var eventsArray = [
        'add:widget',
        'itemduplicate:confirm',
        'itemedit:changed',
        'navigate',
        'open:activity',
        'open:item',
        'render:activity',
        'render:activitylist',
        'render:item',
        'render:itemlist',
        'save',
        'save:activity',
        'save:activity:error',
        'save:activity:success',
        'save:error',
        'save:success',
        'widgetedit:editor:ready',
        'widgetedit:preview:changed',
        'widgetedit:widget:changed',
        'widgetedit:widget:ready'
    ];

    // build events list DOM elements
    var colMax = Math.ceil(eventsArray.length/4);
    var colNum = 0;
    $.each(eventsArray, function(index, eventName) {
        $el = $('<div><span class="' + eventName + ' author-event-name event-label">' + eventName + '</span></div>');
        if (index != 0 && index % colMax == 0) { colNum++ };
        $('.author-events'+ colNum).append($el);
    });

    //optional callbacks for ready
    var callbacks = {
        readyListener: function () {
            console.log('Author API has successfully initialized.');
            bindEventListeners();
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    // function to iterate through events and bind listeners
    function bindEventListeners () {
        $.each(eventsArray, function(index, eventName) {
            authorApp.on(eventName, function(){
                console.log('Received event: ' + eventName);

                var $el = $('.author-event-name:contains("' + eventName + '")');

                // Toggle class event to indicate in the UI the event triggered
                $el.addClass('event-called');
                setTimeout(function () {
                    $el.removeClass('event-called');
                }, 800);
            });
        });
    };

    var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

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

    .author-events {
        padding: 15px;
        font-size: 14px;
        background-color: white;
        position: relative;
    }

    .author-events > div {
        margin-bottom: 8px;
    }

    .author-wrapper {
        min-height: 510px;
    }
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
