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
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'demos-site',
    'items' => [
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6'
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
            <h2>Formative Distractor Rationale</h2>
            <p>
                Distractor rationale are hints shown to a student when they select an incorrect answer.<br>Try choosing
                an incorrect answer for the questions below to see distractor rationale in action.<br>You can specify distractor rationale
                in the author API and then write code to display them.<br> For an example of how to implement distractor rationale, refer to <a href="https://docs.learnosity.com/tutorials/tutorial_202">this tutorial.</a>
            <p>
        </div>
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

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                $.each(itemsApp.questions(), function (index, question) {
                    question.on('validated', function () {
                        var outputHTML = '';
                        var map, qid;
                        if (question.isValid()) {
                            return;
                        }
                        if (question.getResponse().type === 'array') {
                            map = question.mapValidationMetadata('distractor_rationale_response_level');
                            $.each(map.incorrect, function (i, data) {
                                /*  Each item in the `map.incorrect` array is an object that contains a `value` property that
                                    holds the response value; an `index` property that refers to the shared index of both the
                                    response area and the metadata; and a `metadata` property containing the metadata value. */

                                var distractor = data.metadata;

                                outputHTML += '<li>' + distractor + '</li>';
                            });
                            if (outputHTML) {
                                outputHTML = '<ul>' + outputHTML + '</ul>';
                            }
                        } else {
                            outputHTML = question.getMetadata().distractor_rationale;
                        }
                        if (!outputHTML) {
                            outputHTML = 'Have you answered all possible responses?';
                        }
                        qid = question.getQuestion().response_id;
                        renderDistractor(qid, outputHTML);
                        MathJax.Hub.Queue(['Typeset', MathJax.Hub, qid]);
                    });
                });

                $.each(itemsApp.questions(), function (index, question) {
                    question.on('changed', function () {
                        removeDistractor(this.getQuestion().response_id);
                    });
                });

            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);

        // Host page rendering logic
        function renderDistractor (id, content) {
            var template;
            if ($("#" + id + "_distractor").length) {
                $("#" + id + "_distractor").html(content).fadeIn();
            } else {
                template = "<div id=\"" + id + "_distractor\" class=\"distractor-rationale alert alert-danger\">" + content + "</div>";
                $("#" + id).append(template);
            }
        }
        function removeDistractor (id) {
            $("#" + id + '_distractor').fadeOut();
        }
    </script>

    <style>
        .distractor-rationale { margin: 6px 0 24px; }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
