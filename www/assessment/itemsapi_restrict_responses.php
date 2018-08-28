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


//simple api request object for item list view, with optional creation of items
$request = [
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API - Restrict Responses',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'demos-site',
    'items' => [
        'act2',
        'act3',
        'act17',
        'act4',
        'act5'
    ],
    'config' => [
        'ignore_question_attributes' => ['validation'],
        'title' => 'Restrict Responses',
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Items API - Restrict Responses</h2>
            <p>This demos uses Items API (assess) to set a callback function on <em>item:beforeunload</em> and display a message when student haven't answered all the possible responses.<p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                var assessApp = itemsApp.assessApp();

                // bind a callback function to the item:beforeunload event
                assessApp.on('item:beforeunload', function (event) {
                    console.log('event item:beforeunload fired!');

                    // loop through question responses to check if the student is missing responses
                    $.each(itemsApp.getCurrentItem().response_ids, function (index, response_id) {
                        var questionObject = itemsApp.question(response_id);
                        var valid_response_count = questionObject.getQuestion().metadata.valid_response_count;
                        var questionResponse = questionObject.getResponse();

                        if (valid_response_count) {
                            // calculate the currentResponseCount using .reduce() to count the student responses
                            var currentResponseCount = (questionResponse) ? questionResponse
                                .value
                                .reduce(function(acc, curr) {
                                    return acc + (curr ? 1 : 0);
                                }, 0) : 0;

                            if (currentResponseCount < valid_response_count) {
                                // display a custom dialog to the student
                                itemsApp.assessApp().dialogs().custom.show({
                                    'header': 'More answers required',
                                    'body': 'This question requires ' + valid_response_count + ((valid_response_count == 1) ? ' answer!':' answers!')
                                });

                                // preventDefault() to stop the assessment navigation
                                event.preventDefault();
                                return false;
                            }
                        }
                    });
                });
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
