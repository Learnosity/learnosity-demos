<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'itemsassessdemo',
    'name'           => 'Items API - Restrict Responses',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'type'           => 'submit_practice',
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'items'          => array('act2','act3','act17','act4','act5'),    
    'config'         => array(
        'ignore_question_attributes' => array('validation'),
        'title'                      => 'Restrict Responses',
        'ui_style'                   => 'main'
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Items API - Restrict Responses</h1>
        <p>This demos uses Items API (assess) to set a callback function on <em>item:beforeunload</em> and display a message when student haven't answered all the possible responses.<p>        
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
            readyListener: init
        },
        itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    function init () {
        var assessApp = itemsApp.assessApp();

        // bind a callback function to the item:beforeunload event
        assessApp.on('item:beforeunload', function (event) {
            console.log('event item:beforeunload fired!');

            var questions = assessApp.getQuestions();
            var responses = assessApp.getResponses();

            // loop through question responses to check if the student is missing responses
            $.each(itemsApp.getCurrentItem().response_ids, function (index, response_id) {

                var valid_response_count = questions[response_id].metadata.valid_response_count;
                var questionResponse = responses[response_id];

                if (valid_response_count) {
                    // calculate the currentResponseCount using .reduce() to count the student responses
                    var currentResponseCount = (questionResponse !== undefined) ? questionResponse
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
    }
    
</script>

<?php
    include_once 'views/modals/settings-items.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';