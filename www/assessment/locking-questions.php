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


//simple api request object for Items API
$request = [
    'activity_id' => 'lockingquestionsdemo',
    'name' => 'Items API - Locking Questions',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => Uuid::generate(),
            'reference' => 'act1'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act2'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act3'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act4'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act5'
        ],
        [
            'id' => Uuid::generate(),
            'reference' => 'act6'
        ]
    ],
    'config' => [
        'title' => 'Demo activity - locking questions',
        'subtitle' => 'Walter White',
        'regions' => 'main'
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
            <h2>Locking Questions</h2>
            <p>
                In this demo, we customize the <em>Check Answer</em> button logic to display a message on every question attempt. When the question max <em>feedback_attempts</em> is reached the question is locked and the correct answers displayed.
                <br>Try choosing an incorrect answer for the questions below to see this in action.
            <p>
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
                $.each(itemsApp.questions(), function(idx, value) {
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
                                    this.disable();
                                    renderMsg(idx, 'Question Locked');
                                }else{
                                    renderMsg(idx, 'Question Attempted ' + counter);
                                }
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
