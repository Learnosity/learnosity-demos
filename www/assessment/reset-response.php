<?php
include_once '../env_config.php';
include_once 'includes/header.php';
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

/* Demo configuration and signature sign */
$requestDemo = [
    'name' => 'Reset Response Demo 1',
    'rendering_type' => 'inline',
    'type' => 'local_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'organisation_id' => $roAdditionalOrgId,
    'items' => [
        [
            'id' => 'demo_reset_response_act_1_no_edit',
            'reference' => 'demo_reset_response_act_1_no_edit'
        ],
        [
            'id' => 'demo_reset_response_act_2_no_edit',
            'reference' => 'demo_reset_response_act_2_no_edit'
        ],
        [
            'id' => 'demo_reset_response_act_3_no_edit',
            'reference' => 'demo_reset_response_act_3_no_edit'
        ]
    ]
];

$InitDemo = new Init('items', $security, $consumer_secret, $requestDemo);
$signedRequest = $InitDemo->generate();

?>
    <div class="jumbotron section">
        <div class="overview">
            <h2>Reset Response</h2>
            <br>
            <p>Use the <a href="https://reference.learnosity.com/questions-api/methods#question-ResetResponse"><code>resetResponse</code></a> public method to allow user to reset the response of a question.</p>
            <p>Below is a demo of the <a href="https://reference.learnosity.com/questions-api/methods/question/resetResponse"><code>resetResponse</code></a> public method showing what can be achieved with a button that lets the user reset their response to a question. This can be useful in certain situations where end-users can be penalised for choosing an incorrect response. This public method provides a way for students to "reset" their response and leave a question unattempted if they’re not confident about the correct answer. This functionality is not available by default.</p>
        </div>
    </div>

    <!--  Question 1  -->
    <div class="section pad-sml">
        <h3">Multiple Choice</h3>
        <hr>
        <span class="learnosity-item" data-reference="demo_reset_response_act_1_no_edit"></span>
        <div class="button-wrapper">
            <button
                type="button"
                class="resetResponseButton"
                data-reference="demo_reset_response_act_1_no_edit"
            >
                <span>Reset Response</span>
            </button>
        </div>
        <div class="button-note">
            <br>
            <p>NOTE: The Reset Response button is a custom button that calls the <a href="https://reference.learnosity.com/questions-api/methods/question/resetResponse"><code>resetResponse</code></a> public method.</p>
        </div>
    </div>

    <!--  Question 2  -->
    <div class="section pad-sml">
        <h3">Choice Matrix</h3>
        <hr>
        <span class="learnosity-item" data-reference="demo_reset_response_act_2_no_edit"></span>
        <div class="button-wrapper">
            <button
                type="button"
                class="resetResponseButton"
                data-reference="demo_reset_response_act_2_no_edit"
            >
                <span>Reset Response</span>
            </button>
        </div>
        <div class="button-note">
            <br>
            <p>NOTE: The Reset Response button is a custom button that calls the <a href="https://reference.learnosity.com/questions-api/methods/question/resetResponse"><code>resetResponse</code></a> public method.</p>
        </div>
    </div>

    <!--  Question 3  -->
    <div class="section pad-sml">
        <h3">Cloze Dropdown</h3>
        <hr>
        <span class="learnosity-item" data-reference="demo_reset_response_act_3_no_edit"></span>
        <div class="button-wrapper">
            <button
                type="button"
                class="resetResponseButton"
                data-reference="demo_reset_response_act_3_no_edit"
            >
                <span>Reset Response</span>
            </button>
        </div>
        <div class="button-note">
            <br>
            <p>NOTE: The Reset Response button is a custom button that calls the <a href="https://reference.learnosity.com/questions-api/methods/question/resetResponse"><code>resetResponse</code></a> public method.</p>
        </div>
    </div>

    <!--  Load items API  -->
    <script src="<?php echo $url_items; ?>"></script>
    <script>

        // Function that calls the Learnosity resetResponse public method
        const resetResponse = itemReference => {
            const item = itemsApp.getItems()[itemReference];
            const responseIds = item.response_ids;

            responseIds.forEach(responseId => {
                itemsApp.question(responseId).resetResponse();
            });
        };

        // When the app has loaded, set an event listener on each Reset Response button.
        const callback = {
            readyListener() {
                document
                    .querySelectorAll('.resetResponseButton')
                    .forEach((button) => {
                        button.addEventListener('click', e => {
                            const itemReference = e.currentTarget.getAttribute('data-reference');

                            resetResponse(itemReference);
                        });
                    });
            }
        }

        // Initialise Items API
        const itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, callback);
    </script>

    <style>
        .button-note {
            text-align: right;
        }

        .button-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .resetResponseButton {
            color: #ffffff;
            background-color: #ef3232;
            font-size: 1.1428571429em;
            border: none;
            padding: 6px 12px;
            border-radius: 0.125em;
            margin-right: 7px;
            margin-top: -10px;
        }

        /* Custom CSS rules to make the Question's Check Answer button the same width as the Reset Response button */
        .lrn_validate,
        .resetResponseButton {
            max-width: 140px;
            width: 100%;
        }
    </style>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
