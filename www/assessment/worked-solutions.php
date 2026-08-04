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
    'activity_id' => 'workedsolutionsdemo',
    'name' => 'Items API demo - worked solutions',
    'rendering_type' => 'inline',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [
        [
            'id' => 'workedsolutions_1',
            'reference' => 'workedsolutions_1'
        ],
        [
            'id' => 'workedsolutions_2',
            'reference' => 'workedsolutions_2'
        ],
        [
            'id' => 'workedsolutions_3',
            'reference' => 'workedsolutions_3'
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
                <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Add Question Hints & Worked Solutions</h2>
            <p>
            <p>Extend our standard assessments to provide powerful hint and worked-solution functionality.
                <br>You can store hints as metadata and write code to display them to the user.
                <br>For an example of how to implement hints, refer to <a href="https://support.learnosity.com/hc/en-us/articles/360000757917-Tutorial-203-Displaying-Hints">this tutorial.</a>
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <p>
            <!-- HTML element to load item(s) into -->
            <h2>Question 1</h2>
            <p><span class="learnosity-item" data-reference="workedsolutions_1"></span></p>
            <h2>Question 2</h2>
            <p><span class="learnosity-item" data-reference="workedsolutions_2"></span></p>
            <h2>Question 3</h2>
            <p><span class="learnosity-item" data-reference="workedsolutions_3"></span></p>
        </p>
    </div>

    <script src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                var metadata = getMetadata();
                var question_ids = getObjectKeys(metadata);
                // Render a button next to each question for users to see a hint (if available)
                // for that question
                for (var i = 0; i < question_ids.length; i++) {
                    var id = question_ids[i];
                    var btnHint = '<p class="col-auto"><button type="button" class="btn btn-default btn-sm ' + id + '" onclick="renderHint(\'' + id + '\')">Hint</button></p>';
                    document.getElementById(id).closest('div.row').insertAdjacentHTML('beforeend', btnHint);
                }
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);

        /**
         * Render any hint(s) retrieved from the question metadata
         * @param  {string} question_id The question to render a hint for
         */
        function renderHint(question_id) {
            var questionEl = document.getElementById(question_id);
            var itemContent = questionEl.closest('div.item-content');

            // get hints container.. (the sibling of the item content)
            var hintsElem = itemContent && [...itemContent.parentElement.children]
                .find(function (child) { return child !== itemContent; });

            if (!hintsElem) {
                return;
            }
            hintsElem.id = 'hints_' + question_id;

            // clear hints container..
            hintsElem.innerHTML = '';

            var metadata = getMetadata(question_id);
            var template = document.createElement('template');
            template.innerHTML = metadata.sample_answer || metadata.hint;
            var hints = [...template.content.querySelectorAll('div.hint')];

            var hintsClicked = questionEl.dataset.hintsClicked === undefined
                ? undefined
                : Number(questionEl.dataset.hintsClicked);
            if (hintsClicked === undefined) {
                questionEl.dataset.hintsClicked = 1;
            } else if (hintsClicked < hints.length) {
                questionEl.dataset.hintsClicked = hintsClicked + 1;
            }

            // Add the hint(s) from questions metadata and render into the div#hints element
            var shown = Number(questionEl.dataset.hintsClicked);
            hintsElem.classList.add('alert', 'alert-warning');
            for (var i = 0; i < shown; i++) {
                if (hints[i]) {
                    hintsElem.append(hints[i]);
                }
            };

            document.querySelectorAll('button[class~="' + question_id + '"]').forEach(function (button) {
                button.textContent = 'Hint (' + (hints.length - shown) + ' left) ';
            })

            // Render any LaTeX that might have been in the hint
            itemsApp.questionsApp().renderMath();
        }

        /**
         * Retrieves the metadata object from the Questions API
         * Optionally returns data for a specific key
         * @param  {string} key Optional key to filter by
         * @return {object}     Either the entire metadata object, or a subset (if key is passed)
         */
        function getMetadata(key) {
            var metadata;
            itemsApp.getMetadata(function(obj) {
                metadata = obj;
            });
            if (typeof key === 'undefined') {
                return metadata;
            } else {
                return metadata[key];
            }
        }

        /**
         * Utility function to return all keys in a passed object
         * @param  {object} obj Object to return keys from
         * @return {array}      Array of object keys
         */
        function getObjectKeys(obj) {
            var keys = [];
            for(var key in obj) {
                if(obj.hasOwnProperty(key)) {
                    keys.push(key);
                }
            }
            return keys;
        }
    </script>

    <style>
        .distractor-rationale { margin: 6px 0 24px; }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
