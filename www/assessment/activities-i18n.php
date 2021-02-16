<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$language=filter_input(INPUT_GET, 'language', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options'=>['default'=>'en-US']]);
$env=filter_input(INPUT_GET, 'env', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options'=>['default'=>'prod']]);

/*
    We pull in all i18n files from an open source Github repo
*/
$baseRepoUrl = 'https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/';

$assessLabels = '[]';
$questionsLabels = '[]';

if ($language !== 'en-US' && preg_match('/^[A-Za-z\-]+$/', $language)) {
    $url = $baseRepoUrl . $language . '/label_bundles/';
    $assessLabels = file_get_contents($url . '/assess-api.json');
    $questionsLabels = file_get_contents($url . "/questions-api.json");
}

// TODO: Remove this when we have the multi lingual items in all environments.
if ($env === 'prod') {
    $url_items = '//items.learnosity.com/?' . $lts_version;
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

switch ($language) {
    case 'ar-EG':
        $activityTemplateId = 'i18n-acty1-arb';
        break;
    case 'es-ES':
        $activityTemplateId = 'i18n-acty1-spa';
        break;
    case 'de-DE':
        $activityTemplateId = 'i18n-acty1-ger';
        break;
    case 'fr-FR':
        $activityTemplateId = 'i18n-acty1-fr';
        break;
    case 'tl-PH':
        $activityTemplateId = 'i18n-acty1-tgl';
        break;
    case 'it-IT':
        $activityTemplateId = 'i18n-acty1-it';
        break;
    case 'ru-RU':
        $activityTemplateId = 'i18n-acty1-ru';
        break;
    case 'zh-CN':
        $activityTemplateId = 'i18n-acty1-cn';
        break;
    case 'pt-PT':
        $activityTemplateId = 'i18n-acty1-pt';
        break;
    case 'jp-JP':
        $activityTemplateId = 'i18n-acty1-jp';
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
        'configuration' => [
          'onsubmit_redirect_url' => './activities-i18n.php?language=' . $language
        ],
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

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>I18n and l10n support made easy</h2>
        <p>Learnosity has i18n (internationalization) and l10n (localization) support for configuration and language bundles.</p>
        <p>This demo uses learnosity-i18n which is a public repository, containing Learnosity internationalization language bundles.</p>
        <p style="margin-bottom:25px;">Click a language icon to see a translation of the assessment below:</p>
        <div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'en-US') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=en-US">
                    <img class="language-flag" src="/static/images/i18n/flag-US.png" />
                    English (US)
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'es-ES') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=es-ES">
                    <img class="language-flag" src="/static/images/i18n/flag-ES.png" />
                    Español / Spanish
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'fr-FR') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=fr-FR">
                    <img class="language-flag" src="/static/images/i18n/flag-FR.png" />
                    Français / French
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'de-DE') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=de-DE">
                    <img class="language-flag" src="/static/images/i18n/flag-DE.png" />
                    Deutsch / German
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'pt-PT') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=pt-PT">
                    <img class="language-flag" src="/static/images/i18n/flag-PT.png" />
                    Português / Portuguese
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'it-IT') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=it-IT">
                    <img class="language-flag" src="/static/images/i18n/flag-IT.png" />
                    Italiano / Italian
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'ja-JP') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=jp-JP">
                    <img class="language-flag" src="/static/images/i18n/flag-JP.png" />
                    日本語 / Japanese
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'zh-CN') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=zh-CN">
                    <img class="language-flag" src="/static/images/i18n/flag-CN.png" />
                    简体中文 / Chinese
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'ar-EG') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=ar-EG">
                    <img class="language-flag" src="/static/images/i18n/flag-EG.png" />
                    العَرَبِيَّة / Arabic
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'ru-RU') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=ru-RU">
                    <img class="language-flag" src="/static/images/i18n/flag-RU.png" />
                    Русский / Russian
                </a>
            </div>
        </div>
        <br/>
        <p>
            <b>More languages:</b>
                <a class="other-language <?php if ($language === 'en-GB') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=en-GB">English (UK)</a>
                | <a class="other-language <?php if ($language === 'tl-PH') { echo 'selected'; } ?>" href="/assessment/activities-i18n.php?language=tl-PH">Pilipino/Tagalog</a>
        </p>
        <p><b>Add your own:</b> <a href="https://help.learnosity.com/hc/en-us/articles/360002918818/">Documentation</a> | <a href="https://github.com/Learnosity/learnosity-i18n">Github repo</a> </p>

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
