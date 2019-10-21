<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$assessLabels = '[]';
$questionsLabels = '[]';
$language = 'default';

if (isset($_GET['language'])) {
    $language = $_GET['language'];
    if ($language !== 'default') {
        $url = 'https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/' . $language;
        $assessLabels = file_get_contents($url . '/assess-api.json');
        $questionsLabels = file_get_contents($url . "/questions-api.json");
    }
}

// TODO: Remove this when we have the multi lingual items in all environments.
if (isset($_GET['env']) === false) {
    $url_items = '//items.learnosity.com';
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

switch ($language) {
    case 'ar-EG':
        $activityTemplateId = 'i18n-acty1-arb';
        break;
    case 'es':
        $activityTemplateId = 'i18n-acty1-spa';
        break;
    case 'fr':
        $activityTemplateId = 'i18n-acty1-fr';
        break;
    default:
        $activityTemplateId = 'i18n-acty1-eng';
        break;
}


//simple api request object for Items API
$request = [
    'activity_id' => 'itemsactivitiesdemo',
    'activity_template_id' => $activityTemplateId,
    'name' => 'Items API demo - activities',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'demos-site',
    'config' => [
        'regions' => 'main',
        'labelBundle' => json_decode($assessLabels, true),
        'questions_api_init_options' => [
            'labelBundle' => json_decode($questionsLabels, true),
        ],
        'navigation' => [
            'scroll_to_top' => false,
            'scroll_to_test' => false
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
    <style>
        .language-button-container {
            display: inline-block;
            margin-right: 25px;
        }

        .language-button {
            height: 46px;
            display: flex;
            background-color: #F7F7F7;
            color: black;
            padding-right: 25px;

            box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
            border-radius: 2px;
            position: relative;
            transition-property: transform;
            transition-duration: 0.2s;
            align-items: center;
        }

        .language-button:focus {
            box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25), inset 0px 0px 0px 1px black;
            outline: none;
        }


        .language-button:focus,
        .language-button-container:hover .language-button {
            text-decoration: none;
            color: black;
            background-color: #EAEAEA;
        }

        .language-button-container:hover .language-button {
            transform: translate(0px, -5px);
        }

        .selected {
            background-color: #EAEAEA;
            border: 2px solid #355BD5;
        }

        .other-language.selected {
            padding: 3px;
        }

        .language-flag {
            height: 20px;
            width: 28px;
            margin-right: 5px;
            margin-left: 13px;
        }
    </style>
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>I18n and l10n support made easy</h2>
            <p>Learnosity is built from the ground up with i18n (Internationalization) and l10n (Localization) support with support for configuration and language bundles.</p>
            <p>This demo uses learnosity-i18n which is a public repository of Learnosity internationalization language bundles.</p>
            <p style="margin-bottom:25px;">Selected examples:</p>
            <div>
                <div class="language-button-container">
                    <a class="language-button <?php if ($language === 'default') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=default">
                        <img class="language-flag" src="/static/images/i18n/flag-US.png" />
                        English (US)
                    </a>
                </div>
                <div class="language-button-container">
                    <a class="language-button <?php if ($language === 'es') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=es">
                        <img class="language-flag" src="/static/images/i18n/flag-ES.png" />
                        Español / Spanish
                    </a>
                </div>
                <div class="language-button-container">
                    <a class="language-button <?php if ($language === 'fr') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=fr">
                        <img class="language-flag" src="/static/images/i18n/flag-FR.png" />
                        Français / French
                    </a>
                </div>
                <div class="language-button-container">
                    <a class="language-button <?php if ($language === 'ar-EG') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=ar-EG">
                        <img class="language-flag" src="/static/images/i18n/flag-EG.png" />
                        العَرَبِيَّة / Arabic
                    </a>
                </div>
            </div>
            <br/>
            <p>
                <b>More languages:</b>
                <a class="other-language <?php if ($language === 'en-GB') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=en-GB">English / UK</a>
                 | Deutsch / German | Filipino
            </p>
            <p><b>Add your own:</b> Documentation | <a href="https://github.com/Learnosity/learnosity-i18n">Github repo</a> </p>

        </div>
    </div>
    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
        <div id="learnosity_assess"></div>
    </div>
    <script <?php if ($language === 'ar-EG') { echo 'data-lrn-dir="rtl"'; } ?> src="<?php echo $url_items; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Items API has successfully initialized.");
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
