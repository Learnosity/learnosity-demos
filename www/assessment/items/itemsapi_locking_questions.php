<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Inline Activity.',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedemo',
    'session_id'     => Uuid::generate(),
    'items'          => array('act1','act2','act3','act4','act5','act6'),
    'type'           => 'local_practice',
    'config'         => [
        'configuration' => [
            'responsive_regions' => true
        ],
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    ]
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Locking Questions</h1>
    <p>
        In this demo we customize the <em>Check Answer</em> button logic to display a message on every question attempt. When the question max <em>feedback_attempts</em> is reached the question is locked and the correct answers displayed.
        <br>Try choosing an incorrect answer for the questions below to see this in action.
    <p>
</div>

<div class="section">
    <p>
        <span class="learnosity-item" data-reference="act1"></span>
        <span class="learnosity-item" data-reference="act2"></span>
        <span class="learnosity-item" data-reference="act3"></span>
        <span class="learnosity-item" data-reference="act4"></span>
        <span class="learnosity-item" data-reference="act5"></span>
        <span class="learnosity-item" data-reference="act6"></span>
    </p>
</div>

<!-- Container for the items api to load into -->
<script src="<?php echo $url_items; ?>"></script>
<script>
    var eventOptions = {
        readyListener: function () {
            $.each(itemsInstance.questions(), function(idx, value) {
                var counter = 0;

                value.on('validated', function() {
                    counter++;

                    var thisQuestion = this.getQuestion();

                    if(this.isValid()) {
                        this.disable();
                        renderMsg(idx, 'Question Locked');
                    } else {
                        if(typeof thisQuestion.feedback_attempts != "undefined") {
                            if(counter === thisQuestion.feedback_attempts) {
                                this.validate({
                                    "showCorrectAnswers" : true
                                });
                                this.disable();
                                renderMsg(idx, 'Question Locked');
                            }else{
                                renderMsg(idx, 'Question Attempted ' + counter);
                            }
                        }
                    }
                });
            });
        }
    };

    var itemsInstance = LearnosityItems.init(<?php echo $signedRequest; ?>, eventOptions);

    // Host page rendering logic
    function renderMsg (id, content) {
        var template;
        if ($("#" + id + "_msg").length) {
            $("#" + id + "_msg").html(content).fadeIn();
        } else {
            template = "<div id=\"" + id + "_msg\" class=\"question-msg alert alert-danger\">" + content + "</div>";
            $("#" + id).append(template);
        }
    }

</script>

<style>
    .question-msg { margin: 6px 0 24px; }
</style>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
