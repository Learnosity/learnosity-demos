<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//file/URL util
include_once 'utils/file.php';

use LearnositySdk\Request\Init;

function validateLanguageParam(string $language)
{
    $pattern = '/^[a-z]{2}-[A-Z]{2}$/';
    if (preg_match($pattern, $language)) {
        return $language;
    } else {
        return 'pt-PT';
    }
}

$language = filter_var($_GET['language'] ?? "", FILTER_CALLBACK, ['options' => 'validateLanguageParam']);
$env = filter_input(INPUT_GET, 'env', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => 'prod']]);

/*
    We pull in all i18n files from an open source Github repo:
     - label bundles per API
     - question template groups
     - question templates
     - question template thumbnails
*/
$baseRepoUrl = 'https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/';

/*
    For Arabic, we don't render any default Question Editor groups,
    but for every other language we do. This has the most impact
    (for this demo) for Features.
*/
$hasGroupDefaults = ($language === 'ar-EG') ? 'false' : 'true';

/*
    For demos that have them, retrieve the Question Editor custom question
    templates and groups needed for translated content (like placeholder
    response options and question stimulus etc).
    We store them in separate files for easier maintenance and a cleaner
    initialization object for this demo file.

    Normally, these would be passed in the standard `request` object, this
    is a separate step for this demo purely to account for some demos that
    don't have the templates and/or groups set up.
*/
if (preg_match('/^[A-Za-z\-]+$/', $language)) {
    $questionsLabels = file_get_contents($baseRepoUrl . $language . '/label_bundles/questions-api.json');
    $authorLabels = file_get_contents($baseRepoUrl . $language . '/label_bundles/author-api.json');
    $questioneditorLabels = file_get_contents($baseRepoUrl . $language . '/label_bundles/questioneditor-api.json');
}
if (urlExists($baseRepoUrl . $language . '/qe_custom_types/question_type_templates.json')) {
    $questionTypeTemplates = file_get_contents($baseRepoUrl . $language . '/qe_custom_types/question_type_templates.json');
    $request['config']['dependencies']['question_editor_api']['init_options']['question_type_templates'] = json_decode($questionTypeTemplates, true);
}
if (urlExists($baseRepoUrl . $language . '/qe_custom_types/question_type_groups.json')) {
    $questionTypeGroups = file_get_contents($baseRepoUrl . $language . '/qe_custom_types/question_type_groups.json');
    $request['config']['dependencies']['question_editor_api']['init_options']['question_type_groups'] = json_decode($questionTypeGroups, true);
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

/*
 We turn the search field off for this demo, because we haven't
 yet translated the search terms (in the templates JSON file).
 */

//simple api request object for Author API
$request = json_decode('{
    "mode": "item_list",
    "config": {
        "global": {
            "hide_tags": [
                {
                    "type": "context"
                }
            ]
        },
        "item_edit": {
            "item": {
                "title": {
                    "show": true,
                    "edit": true,
                    "mandatory": false
                }
            },
            "tags_on_create": [
                {
                    "type": "context",
                    "name": "publicly-created"
                },
                {
                    "type": "i18n",
                    "name": "' . $language . '"
                }
            ]
        },
        "item_list": {
            "filter": {
                "restricted": {
                   "current_user": false,
                   "tags": {
                        "all": [
                            {
                                "type": "i18n",
                                "name": [
                                    "' . $language . '"
                                ]
                            }
                        ],
                        "either": [
                            {
                                "type": "context",
                                "name": [
                                    "publicly-created"
                                ]
                            }
                        ]
                   }
                }
             }
        },
        "label_bundle": ' . $authorLabels . ',
        "dependencies": {
            "question_editor_api": {
                "init_options": {
                    "ui": {
                        "search_field": false,
                        "layout": {
                            "global_template": "edit_preview"
                        }
                    },
                    "group_defaults": ' . $hasGroupDefaults . ',
                    "question_type_groups": ' . $questionTypeGroups . ',
                    "question_type_templates": ' . $questionTypeTemplates . ',
                    "label_bundle": ' . $questioneditorLabels . '
                }
            },
            "questions_api": {
                "init_options": {
                    "labelBundle": ' . $questionsLabels . '
                }
            }
        }
    },
    "user": {
        "id": "demos-site",
        "firstname": "demos",
        "lastname": "User",
        "email": "demos@learnosity.com"
    }
}', true);

$Init = new Init('author', $security, $consumer_secret, $request);
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
                <a class="language-button <?php if ($language === 'pt-PT') { echo 'selected'; } ?>" href="/authoring/item-list-i18n.php?language=pt-PT">
                    <img class="language-flag" src="/static/images/i18n/flag-PT.png" />
                    Português / Portuguese
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'es-ES') { echo 'selected'; } ?>" href="/authoring/item-list-i18n.php?language=es-ES">
                    <img class="language-flag" src="/static/images/i18n/flag-ES.png" />
                    Español / Spanish
                </a>
            </div>
            <div class="language-button-container">
                <a class="language-button <?php if ($language === 'ar-EG') { echo 'selected'; } ?>" href="/authoring/item-list-i18n.php?language=ar-EG">
                    <img class="language-flag" src="/static/images/i18n/flag-EG.png" />
                    العَرَبِيَّة / Arabic
                </a>
            </div>
        </div>
        <br/>
        <p><b>Add your own:</b> <a href="https://help.learnosity.com/hc/en-us/articles/360002918818/">Documentation</a> | <a href="https://github.com/Learnosity/learnosity-i18n">Github repo</a></p>
    </div>
</div>
<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script <?php if ($language === 'ar-EG') {
    echo 'data-lrn-dir="rtl"';
        } ?> src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initializationObject = <?php echo $signedRequest; ?>;

    //optional callbacks for ready
    var callbacks = {
        readyListener: function () {
            console.log('Author API has successfully initialized.');
        },
        errorListener: function (err) {
            console.log(err);
        }
    };

    var authorApp = LearnosityAuthor.init(initializationObject, callbacks);
</script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
