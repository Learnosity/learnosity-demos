<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
$pageTitle = 'Learnosity Author - Right-to-Left Language Support';
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

/*
Retrieve the label bundles, per API, that contain the Arabic
translations. We need one for Author API and the embedded
Question Editor API (loaded by Author API internally).
We store them in separate files for easier maintenance and a cleaner
initialization object for this demo file.
*/
$bundleAuthorAPI = file_get_contents(__DIR__ . '/i18n/ar-EG/label_bundles/author-api.json');
$bundleQuestionEditorAPI = file_get_contents('./i18n/ar-EG/label_bundles/questioneditor-api.json');
$bundleQuestionsAPI = file_get_contents('./i18n/ar-EG/label_bundles/questions-api.json');

/*
Retrieve the Question Editor custom question templates and groups
needed for RTL content (like placeholder response options and
question stimulus etc).
We store them in separate files for easier maintenance and a
cleaner initialization object for this demo file.
*/
$questionTypeTemplates = file_get_contents('./i18n/ar-EG/qe_custom_types/question_type_templates.json');
$questionTypeGroups = file_get_contents('./i18n/ar-EG/qe_custom_types/question_type_groups.json');

/*
Note - passages aren't enabled in this demo because other features
are not yet supported in RTL (like line-reader, media player etc).
Note - Today we need to pass Questions API labelBundles twice (see
below in `dependencies`), this will be addressed in a future release.
*/
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
            "tags_on_create": [
                {
                    "type": "context",
                    "name": "publicly-created"
                }
            ]
        },
        "item_list": {
            "filter": {
                "restricted": {
                   "current_user": false,
                   "tags": {
                    "either": [
                        {
                            "type": "i18n",
                            "name": [
                                "arabic"
                            ]
                        },
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
        "widget_templates": {
            "widget_types": {
                "show": false
            }
        },
        "label_bundle": ' . $bundleAuthorAPI . ',
        "dependencies": {
            "question_editor_api": {
                "init_options": {
                    "group_defaults": false,
                    "question_type_groups": ' . $questionTypeGroups . ',
                    "question_type_templates": ' . $questionTypeTemplates . ',
                    "ui": {
                        "search_field": false,
                        "layout": {
                            "global_template": "edit_preview",
                            "mode": "advanced"
                        }
                    },
                    "label_bundle": ' . $bundleQuestionEditorAPI . ',
                    "dependencies": {
                        "questions_api": {
                            "init_options": {
                                "labelBundle": ' . $bundleQuestionsAPI . '
                            }
                        }
                    }
                }
            },
            "questions_api": {
                "init_options": {
                    "labelBundle": ' . $bundleQuestionsAPI . '
                }
            }
        }
    },
    "user": {
        "id": "labs-site",
        "firstname": "Labs",
        "lastname": "User",
        "email": "labs@learnosity.com"
    }
}', true);

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Right-to-Left Language Support</h2>
            <p>This demo demonstrates the Learnosity approach to handling right-to-left languages. In this demo, everything is localised to Arabic using <a href="https://reference.learnosity.com/author-api/initialization#config_label_bundle">label bundles</a>.</p>
            <p>See an article on how to <a href="https://help.learnosity.com/hc/en-us/articles/360000858898-Configuring-Author-API-to-Initialize-in-RTL-Right-to-Left-Mode-Arabic-and-Hebrew-Language-Support-">configure Author API for right-to-left support</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>" data-lrn-dir="rtl"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log('Author API has successfully initialized.');
                removeFormulaEditor();
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

        // Remove the formulaEditor button, Math isn't supported in RTL
        function removeFormulaEditor () {
            authorApp.on('widgetedit:widget:ready', function (event) {
                $elFormattingOptions = $.find('button.lrn-qe-formatting-option');
                $elFormattingOptions.forEach(function (el) {
                    if ($(el).attr('data-lrn-qe-value') && $(el).attr('data-lrn-qe-value') === 'formulaEditor') {
                        $(el).remove();
                    }
                });
            });
        }
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
