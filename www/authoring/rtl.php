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

// Retrieve the label bundles, per API
// We store them in separate files for easier maintenance
$bundleAuthorAPI = file_get_contents(__DIR__ . '/i18n/rtl/label_bundles/author-api.json');
$bundleQuestionEditorAPI = file_get_contents('./i18n/rtl/label_bundles/questioneditor-api.json');
$bundleQuestionsAPI = file_get_contents('./i18n/rtl/label_bundles/questions-api.json');

// Note - passages aren't enabled in this demo because other features
// are not yet supported in RTL (like line-reader, media player etc)
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
                    "question_type_groups": [
                        {
                            "name": "قياسي",
                            "reference": "c569ccd8-e8d9-430e-8b99-4858b2f697cf",
                            "template_references": [
                                "9e8149bd-e4d8-4dd6-a751-1a113a4b9163",
                                "1e6039f8-0676-495d-aca9-108710a51ce5",
                                "184de6ce-4638-4cc5-91c7-e4f37a487f0c"
                            ]
                        },
                        {
                            "name": "إملأ الفراغات",
                            "reference": "7a6429b9-0c23-492a-ae07-98ede023d474",
                            "template_references": [
                                "51a8c1e7-f34f-4faf-b211-da458e891fcb",
                                "2fbba51b-e35e-441f-83c7-2662e2e81fa6",
                                "457fe101-0667-4a35-b193-b849653acb52",
                                "6e77b403-8f0c-43af-b464-9450e1ac70dc",
                                "f8364191-ada5-4806-83d4-8a36b8fad4b0",
                                "35a850a7-9d3f-4e1c-880a-a340767942b6"
                            ]
                        },
                        {
                            "name": "Passage",
                            "reference": "custom-feature",
                            "template_references": [
                                "d5d43bd6-d02a-4969-a79a-e10b344549a8"
                            ]
                        }
                    ],
                    "question_type_templates": {
                        "sharedpassage": [
                            {
                                "name": "مقطع النص",
                                "description": "تمكين مقطع النص القابل للتمييز والذي يمكن استخدامه عبر عدة عناصر.",
                                "reference": "d5d43bd6-d02a-4969-a79a-e10b344549a8",
                                "defaults": {
                                    "content": "أدخل محتوى المقطع هنا"
                                }
                            }
                        ],
                        "mcq": {
                            "description": "سؤال الاختيار من متعدد القياسية.",
                            "name": "الاختيار من متعدد - قياسي",
                            "reference": "9e8149bd-e4d8-4dd6-a751-1a113a4b9163",
                            "image": "i18n/rtl/template_thumbnails/mcq-tile.png",
                            "defaults": {
                                "options": [
                                    {
                                        "label": "[اختيار أ]",
                                        "value": "0"
                                    },
                                    {
                                        "label": "[اختيار ب]",
                                        "value": "1"
                                    },
                                    {
                                        "label": "[اختيار ج]",
                                        "value": "2"
                                    },
                                    {
                                        "label": "[اختيار د]",
                                        "value": "3"
                                    }
                                ],
                                "stimulus": "<p>[هذا هو رأس السؤال.]</p>",
                                "type": "mcq",
                                "validation": {
                                    "scoring_type": "exactMatch",
                                    "valid_response": {
                                        "score": 1,
                                        "value": []
                                    }
                                }
                            }
                        },
                        "longtextV2": {
                            "description": "مقال يصل إلى 10000 كلمة وقد يحتوي علي عناصر تحكم بتنسيق النص.",
                            "name": "مقال مع نص غني",
                            "reference": "1e6039f8-0676-495d-aca9-108710a51ce5",
                            "image": "i18n/rtl/template_thumbnails/longtext-tile.png",
                            "defaults": {
                                "stimulus": "<p>[هذا هو رأس السؤال.]</p>"
                            },
                            "hidden": [
                                "is_math",
                                "horizontal_layout",
                                "keypad.heading",
                                "showHints"
                            ],
                            "hidden_sections": [
                                "keypad",
                                "horizontal_keyboard.content",
                                "symbols",
                                "number_pad.content",
                                "text_blocks"
                            ]
                        },
                        "clozetext": [
                            {
                                "description": "املأ الفراغات بالردود النصية",
                                "name": "كلوز مع النص",
                                "reference": "457fe101-0667-4a35-b193-b849653acb52",
                                "image": "i18n/rtl/template_thumbnails/cloze-text-tile.png",
                                "defaults": {
                                    "stimulus": "",
                                    "template": "الجو ليركز كل بعد, قد هُزم أراض عليها شيء. معارضة رجوعهم انه عن. ثم دنو الطريق انتباه, بعد هامش مارد التجارية تم. بـ الحكم فاتّبع المبرمة بال. للصين الفرنسية أسر تم, والحزب الساحة البولندي دنو أم, فصل بـ المبرمة المؤلّفة. نتيجة النفط وقدّموا ما أسر.\n\n                                    شدّت الاندونيسية كل وصل, أن نفس تعديل بالجانب. و ذلك حاملات وبلجيكا، انتصارهم. جعل وقوعها، للإتحاد الموسوعة ما, مع قدما ساعة الساحلية إيو, ٣٠ حول رئيس ثمّة الخاسر. أثره، الأحمر شواطيء تم شيء, ثم وحتى الجو بحق, قد تلك معقل بخطوط كنقطة. وبداية بأضرار اليابان، بعض قد, كما بـ أسابيع الإمداد {{response}} الفرنسية. وقبل احداث ٣٠ يكن, على أدنى البرية ثم.\n\n                                    حين ٣٠ بلاده إختار مكثّفة, جعل بحشد يعبأ أجزاء إذ. يكن وحتّى غريمه مليارات بـ. دون واُسدل استمرار ولاتّساع عن, بقعة الوراء وانتهاءً بـ إيو. معقل الخطّة كل مما. جعل فمرّ يعادل عل. حكومة القوى استراليا، لم لمّ, الجنود الرئيسية دول من, اعلان وبالتحديد، يتم بل.\n\n                                    لكل أن قِبل إختار, أضف و ليبين المارق المحيط, جسيمة الشهير و حدى. هذا بـ غرّة، لهيمنة وبلجيكا،, والقرى الوراء قام هو. مدينة الثقيل قد وفي, شرسة واعتلاء التقليدي تم أخر. إعلان التاريخ، بلا أن, يتم باستحداث وباستثناء قد.\n\n                                    من كُلفة مكثّفة كان, بال جورج تكاليف و. مدن بزمام الأبرياء قد. شواطيء معزّزة أن جهة. والقرى تحرّكت حين من. و مقاومة وأكثرها الأوضاع أخذ, تعداد السيء الإمداد إذ إيو, هو {{response}} أخرى عسكرياً الفرنسي حين.\n\n                                    لم تمهيد الجنود الأوروبية، وقد, أمدها الصين بالتوقيع تعد ما. لكل لم والفلبين الرئيسية ايطاليا،, بـ للمجهود بالجانب وتتحمّل",
                                    "validation": {
                                        "scoring_type": "exactMatch",
                                        "valid_response": {
                                            "score": 1,
                                            "value": [
                                                null,
                                                null
                                            ]
                                        }
                                    },
                                    "type": "clozetext"
                                }
                            }
                        ],
                        "clozedropdown": [
                            {
                                "description": "إملأ الفراغات مع القوائم المنسدلة.",
                                "name": "كلوز مع القائمة المنسدلة",
                                "reference": "2fbba51b-e35e-441f-83c7-2662e2e81fa6",
                                "image": "i18n/rtl/template_thumbnails/cloze-dropdown-tile.png",
                                "defaults": {
                                    "stimulus": "",
                                    "template": "الجو ليركز كل بعد, قد هُزم أراض عليها شيء. معارضة رجوعهم انه عن. ثم دنو الطريق انتباه, بعد هامش مارد التجارية تم. بـ الحكم فاتّبع المبرمة بال. للصين الفرنسية أسر تم, والحزب الساحة البولندي دنو أم, فصل بـ المبرمة المؤلّفة. نتيجة النفط وقدّموا ما أسر.\n\n                                    شدّت الاندونيسية كل وصل, أن نفس تعديل بالجانب. و ذلك حاملات وبلجيكا، انتصارهم. جعل وقوعها، للإتحاد الموسوعة ما, مع قدما ساعة الساحلية إيو, ٣٠ حول رئيس ثمّة الخاسر. أثره، الأحمر شواطيء تم شيء, ثم وحتى الجو بحق, قد تلك معقل بخطوط كنقطة. وبداية بأضرار اليابان، بعض قد, كما بـ أسابيع الإمداد {{response}} الفرنسية. وقبل احداث ٣٠ يكن, على أدنى البرية ثم.\n\n                                    حين ٣٠ بلاده إختار مكثّفة, جعل بحشد يعبأ أجزاء إذ. يكن وحتّى غريمه مليارات بـ. دون واُسدل استمرار ولاتّساع عن, بقعة الوراء وانتهاءً بـ إيو. معقل الخطّة كل مما. جعل فمرّ يعادل عل. حكومة القوى استراليا، لم لمّ, الجنود الرئيسية دول من, اعلان وبالتحديد، يتم بل.\n\n                                    لكل أن قِبل إختار, أضف و ليبين المارق المحيط, جسيمة الشهير و حدى. هذا بـ غرّة، لهيمنة وبلجيكا،, والقرى الوراء قام هو. مدينة الثقيل قد وفي, شرسة واعتلاء التقليدي تم أخر. إعلان التاريخ، بلا أن, يتم باستحداث وباستثناء قد.\n\n                                    من كُلفة مكثّفة كان, بال جورج تكاليف و. مدن بزمام الأبرياء قد. شواطيء معزّزة أن جهة. والقرى تحرّكت حين من. و مقاومة وأكثرها الأوضاع أخذ, تعداد السيء الإمداد إذ إيو, هو {{response}} أخرى عسكرياً الفرنسي حين.\n\n                                    لم تمهيد الجنود الأوروبية، وقد, أمدها الصين بالتوقيع تعد ما. لكل لم والفلبين الرئيسية ايطاليا،, بـ للمجهود بالجانب وتتحمّل",
                                    "possible_responses": [
                                        [
                                            "الجو ليركز",
                                            "يتم باستحداث",
                                            "الرئيسية",
                                            "التقليدي"
                                        ],
                                        [
                                            "اليابان،",
                                            "نتيجة",
                                            "البولندي",
                                            "حكومة"
                                        ]
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    },
                                    "validation": {
                                        "scoring_type": "exactMatch",
                                        "valid_response": {
                                            "score": 1,
                                            "value": [
                                                null,
                                                null
                                            ]
                                        }
                                    },
                                    "type": "clozedropdown"
                                }
                            }
                        ],
                        "clozeassociation": [
                            {
                                "description": "إملأ الفراغات مع السحب والإسقاط.",
                                "name": "كلوز مع السحب والإسقاط",
                                "reference": "51a8c1e7-f34f-4faf-b211-da458e891fcb",
                                "image": "i18n/rtl/template_thumbnails/cloze-dragdrop-tile.png",
                                "defaults": {
                                    "stimulus": "",
                                    "template": "الجو ليركز كل بعد, قد هُزم أراض عليها شيء. معارضة رجوعهم انه عن. ثم دنو الطريق انتباه, بعد هامش مارد التجارية تم. بـ الحكم فاتّبع المبرمة بال. للصين الفرنسية أسر تم, والحزب الساحة البولندي دنو أم, فصل بـ المبرمة المؤلّفة. نتيجة النفط وقدّموا ما أسر.\n\n                                    شدّت الاندونيسية كل وصل, أن نفس تعديل بالجانب. و ذلك حاملات وبلجيكا، انتصارهم. جعل وقوعها، للإتحاد الموسوعة ما, مع قدما ساعة الساحلية إيو, ٣٠ حول رئيس ثمّة الخاسر. أثره، الأحمر شواطيء تم شيء, ثم وحتى الجو بحق, قد تلك معقل بخطوط كنقطة. وبداية بأضرار اليابان، بعض قد, كما بـ أسابيع الإمداد {{response}} الفرنسية. وقبل احداث ٣٠ يكن, على أدنى البرية ثم.\n\n                                    حين ٣٠ بلاده إختار مكثّفة, جعل بحشد يعبأ أجزاء إذ. يكن وحتّى غريمه مليارات بـ. دون واُسدل استمرار ولاتّساع عن, بقعة الوراء وانتهاءً بـ إيو. معقل الخطّة كل مما. جعل فمرّ يعادل عل. حكومة القوى استراليا، لم لمّ, الجنود الرئيسية دول من, اعلان وبالتحديد، يتم بل.\n\n                                    لكل أن قِبل إختار, أضف و ليبين المارق المحيط, جسيمة الشهير و حدى. هذا بـ غرّة، لهيمنة وبلجيكا،, والقرى الوراء قام هو. مدينة الثقيل قد وفي, شرسة واعتلاء التقليدي تم أخر. إعلان التاريخ، بلا أن, يتم باستحداث وباستثناء قد.\n\n                                    من كُلفة مكثّفة كان, بال جورج تكاليف و. مدن بزمام الأبرياء قد. شواطيء معزّزة أن جهة. والقرى تحرّكت حين من. و مقاومة وأكثرها الأوضاع أخذ, تعداد السيء الإمداد إذ إيو, هو {{response}} أخرى عسكرياً الفرنسي حين.\n\n                                    لم تمهيد الجنود الأوروبية، وقد, أمدها الصين بالتوقيع تعد ما. لكل لم والفلبين الرئيسية ايطاليا،, بـ للمجهود بالجانب وتتحمّل",
                                    "possible_responses": [
                                        "الجو ليركز",
                                        "يتم باستحداث"
                                    ],
                                    "response_container": {
                                        "pointer": "left"
                                    },
                                    "validation": {
                                        "scoring_type": "exactMatch",
                                        "valid_response": {
                                            "score": 1,
                                            "value": [
                                                null,
                                                null
                                            ]
                                        }
                                    },
                                    "type": "clozeassociation"
                                }
                            }
                        ],
                        "imageclozeassociationV2": {
                            "description": "املأ الفراغات على صورة باستخدام السحب والإفلات.",
                            "name": "تسمية الصورة مع السحب والإفلات",
                            "reference": "6e77b403-8f0c-43af-b464-9450e1ac70dc",
                            "image": "i18n/rtl/template_thumbnails/clozeimage-dragdrop-tile.png",
                            "defaults": {
                                "stimulus": "<p>[هذا هو رأس السؤال.]</p>",
                                "possible_responses": [
                                    "اختيار أ",
                                    "اختيار ب",
                                    "اختيار ج"
                                ]
                            }
                        },
                        "imageclozedropdown": {
                            "description": "املأ الفراغات على صورة باستخدام القوائم المنسدلة.",
                            "name": "تسمية الصورة مع القوائم المنسدلة",
                            "reference": "f8364191-ada5-4806-83d4-8a36b8fad4b0",
                            "image": "i18n/rtl/template_thumbnails/clozeimage-dropdown-tile.png",
                            "defaults": {
                                "possible_responses": [
                                    [
                                        "[اختيار أ]",
                                        "[اختيار ب]",
                                        "[اختيار ج]"
                                    ],
                                    [
                                        "[اختيار أ]",
                                        "[اختيار ب]",
                                        "[اختيار ج]"
                                    ],
                                    [
                                        "[اختيار أ]",
                                        "[اختيار ب]",
                                        "[اختيار ج]"
                                    ]
                                ],
                                "stimulus": "<p>[هذا هو رأس السؤال.]</p>"
                            }
                        },
                        "imageclozetext": {
                            "description": "املأ الفراغات مع مربع نص على صورة.",
                            "name": "تسمية الصورة باستخدام النص",
                            "reference": "35a850a7-9d3f-4e1c-880a-a340767942b6",
                            "image": "i18n/rtl/template_thumbnails/clozeimage-text-tile.png",
                            "defaults": {
                                "stimulus": "<p>[هذا هو رأس السؤال.]</p>"
                            }
                        },
                        "highlight": [
                            {
                                "description": "مقال يحتوي مدخل أساسي مرقمة",
                                "name": "مقال(مدخل أساسي مرقم) ",
                                "reference": "184de6ce-4638-4cc5-91c7-e4f37a487f0c",
                                "image": "i18n/rtl/template_thumbnails/highlight-tile.png",
                                "hidden_sections": [
                                    "details"
                                ],
                                "hidden": [
                                    "metadata.distractor_rationale_response_level"
                                ],
                                "defaults": {
                                    "image": {
                                        "width": 800,
                                        "height": 1000,
                                        "source": "https://assets.learnosity.com/organisations/6/ab2f6db1-71dd-4a25-9f0f-d1f6620a4eb6.svg"
                                    },
                                    "line_color": [
                                        "rgba(0, 0, 0, 0.8)"
                                    ],
                                    "stimulus": "<p>الجو ليركز كل بعد</p>",
                                    "type": "highlight",
                                    "line_width": 2
                                }
                            }
                        ]
                    },
                    "ui": {
                        "search_field": false,
                        "layout": {
                            "global_template": "edit_preview",
                            "mode": "advanced"
                        }
                    },
                    "label_bundle": ' . $bundleQuestionEditorAPI . '
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
                console.log("Author API has successfully initialized.");
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
