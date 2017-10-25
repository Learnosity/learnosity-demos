<!DOCTYPE html>
<html>

<head>
    <?php
    // https://docs.learnosity.com/authoring/questioneditor/initialisation#type
    $htmlEditorSupportedValues = ['wysihtml', 'ckeditor'];

    if (isset($_GET["htmleditor"])) {
        if (in_array($_GET["htmleditor"], $htmlEditorSupportedValues)) {
            $htmlEditor = $_GET["htmleditor"];
        } else {
            die("Please provide proper value for 'htmleditor' URL parameter (https://docs.learnosity.com/authoring/questioneditor/initialisation#type).");
        }
    } else {
        $htmlEditor = "wysihtml";
    }

    $qeUrl = "//questioneditor.learnosity.com/?v3";

    if (isset($_GET["env"])) {
        switch ($_GET["env"]) {
            case "staging":
                $qeUrl = "//questioneditor.staging.learnosity.com/?v3";
                break;
            case "vg":
                $qeUrl = "//questioneditor.vg.learnosity.com/?latest";
                break;
            case "prod":
                $qeUrl = "//questioneditor.learnosity.com/?v3";
                break;
            default:
                $qeUrl = "//questioneditor.learnosity.com/?v3";
        }
    }
    ?>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QE V3 - Algorithmic Math Demo</title>
    <link type="text/css" rel="stylesheet" href="//docs.learnosity.com/demos/products/questioneditorapi/v3/algorithmicMath/build/v1.0.0/css/algorithmicMath.css">

    <!-- LEARNOSITY JS SDK to generate Security data for Algorithmic Math -->
    <script src="//docs.learnosity.com/demos/other/jssdk/learnosity.dev.sdk.js"></script>

    <!-- LEARNOSITY APIS -->
    <script src="<?php echo $qeUrl ?>"></script>

    <!-- LEARNOSITY Algorithmic Math -->
    <script src="//docs.learnosity.com/demos/products/questioneditorapi/v3/algorithmicMath/build/v1.0.0/js/algorithmicMath.js"></script>

    <!-- Algorithmic Math - QE template -->
    <script type="text/template" data-lrn-qe-layout="algorithmic-formulaV2-layout">
        <div class="lrn-qe-edit-form">
            <span data-lrn-qe-label="stimulus"></span>
            <span data-lrn-qe-input="stimulus" class="lrn-qe-ckeditor-lg"></span>

            <div>
                <span data-lrn-qe-label="template" class="lrn-qe-inline lrn-qe-margin-right-none"></span>
                <span class="lrn-qe-note-text">(Max 6 variables)</span>
            </div>

            <div class="lrn-qe-template-markup-controls lrn-qe-row-flex">
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6">
            <span class="lrn-qe-inline-block lrn-qe-margin-right-sm lrn-qe-btn-add-variables-wrapper"
                  data-lrn-qe-action-add="metadata.dynamic_content_data.variables"></span>
                    <button type="button" class="lrn-qe-btn lrn-qe-btn-default lrn-qe-btn-add-response"
                            data-action="addResponse" title="Add Response">
                        <span class="lrn-qe-editor-toolbar-i-response lrn-qe-margin-right-sm"></span>
                        <span class="lrn-qe-btn-name">Response</span>
                    </button>
                </div>
                <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-6 lrn-qe-datatable-controls">
                    <div class="lrn-qe-reloading">
                        <span class="lrn-qe-loader">Calculating...</span>
                    </div>
                    <button type="button" class="lrn-qe-btn lrn-qe-btn-edit-datatable"
                            data-action="editDatatable" title="Edit data">
                        <span class="lrn-qe-i-dynamic-data lrn-qe-margin-right-sm"></span>
                        <span class="lrn-qe-btn-name">Data</span>
                    </button>
                </div>
            </div>

            <div data-component="templateMarkup" class="lrn-qe-form-group-wrapper"></div>

            <div class="lrn-qe-hide" data-lrn-mathcore-failed-notification>
                We could not auto create the correct answers for you. Your math problem is too complex or not valid.
            </div>

            <div data-component="useEquation"></div>

            <div data-component="variableList" class="lrn-qe-row-flex"></div>

            <div class="lrn-qe-row-flex">
                <div data-lrn-qe-loop="metadata.dynamic_content_data.variables[*]" class="lrn-qe-col-xs-12 lrn-qe-col-sm-6 lrn-qe-margin-top-md lrn-qe-margin-bottom-md">
                    <span class="lrn-qe-hide" data-lrn-qe-action-remove="metadata.dynamic_content_data.variables[*]"></span>
                    <fieldset class="lrn-qe-fieldset">
                        <div class="lrn-qe-legend">
                            Variable<span class="lrn-qe-padding-left-xs" data-lrn-component="label"></span>
                        </div>

                        <div class="lrn-qe-row-flex">
                            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-3">
                                <span data-lrn-qe-label="metadata.dynamic_content_data.variables[*].min" class="lrn-qe-text-bold"></span>
                                <span data-lrn-qe-input="metadata.dynamic_content_data.variables[*].min" class="lrn-qe-form-control-sm"></span>
                            </div>
                            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-3">
                                <span data-lrn-qe-label="metadata.dynamic_content_data.variables[*].max" class="lrn-qe-text-bold"></span>
                                <span data-lrn-qe-input="metadata.dynamic_content_data.variables[*].max" class="lrn-qe-form-control-sm"></span>
                            </div>
                            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-3">
                                <span data-lrn-qe-label="metadata.dynamic_content_data.variables[*].step" class="lrn-qe-text-bold"></span>
                                <span data-lrn-qe-input="metadata.dynamic_content_data.variables[*].step" class="lrn-qe-form-control-sm"></span>
                            </div>
                            <div class="lrn-qe-col-xs-12 lrn-qe-col-sm-3">
                                <span data-lrn-qe-label="metadata.dynamic_content_data.variables[*].decimal_place" class="lrn-qe-text-bold"></span>
                                <span data-lrn-qe-input="metadata.dynamic_content_data.variables[*].decimal_place" class="lrn-qe-form-control-sm"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <span data-lrn-qe-label="validation.valid_response.score" class="lrn-qe-inline-block lrn-qe-margin-left-none lrn-qe-margin-right-none"></span>
            <span data-lrn-qe-input="validation.valid_response.score" class="lrn-qe-inline-block lrn-qe-text-center lrn-qe-form-control-xs lrn-qe-margin-left-none"></span>

            <!--  lrn-qe-hide input to allow Question API update its validation valid_response value correctly  -->
            <div class="lrn-qe-hide" data-lrn-qe-adv-content>
                <div data-lrn-qe-loop="validation.valid_response.value[*]">
                    <span data-lrn-qe-input="validation.valid_response.value[*].value"></span>
                    <span data-lrn-qe-input="validation.valid_response.value[*].method"></span>
                </div>
                <span data-lrn-qe-action-add="validation.valid_response.value"></span>
            </div>
        </div>
    </script>

    <style>
        .lrn-demo-btn {
            background: #f8f8f8;
            border: 1px solid #ccc;
            padding: 10px 20px;
            font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
            font-size: 12px;
        }

        .lrn-demo-btn:hover,
        .lrn-demo-btn:focus {
            background: #ebebeb;
        }

        .lrn-demo-questions-note {
            margin: 0 80px 30px 80px;
            padding: 10px;
            border: 2px dashed #ccc;
            font-size: 16px;
            color: #99a3aa;
            text-align: center;
            font-family: Helvetica;
        }

        .lrn-demo-question {
            display: block;
            width: 100%;
            text-align: left;
            border: 1px solid transparent;
            background: #f1f1f1;
            position: relative;
            padding: 20px 0 50px 60px;
            margin-bottom: 30px;
            min-height: 120px;
        }

        .lrn-demo-question:hover,
        .lrn-demo-question:focus {
            border-color: #1877b1;
        }

        .lrn-demo-question:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 40px;
            bottom: 0;
            background: #72d4cb;
        }

        .lrn-demo-question > span:first-child {
            display: block;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            color: #99a3aa;
        }

        .lrn-demo-question > span:last-child {
            color: #44505d;
        }

        .lrn-demo-wigetSelection,
        .lrn-demo-toolbar {
            padding: 0;
            margin: 0;
            list-style: none;
            text-align: center;
        }

        .lrn-demo-wigetSelection li,
        .lrn-demo-toolbar li {
            display: inline-block;
        }

        .lrn-demo-wigetSelection {
            margin-bottom: 30px;
        }

        .lrn-demo-wigetSelection button {
            min-width: 150px;
        }

        .lrn-demo-wigetSelection button:last-child {
            margin-left: -5px;
        }

        .lrn-demo-author-form {
            margin-bottom: 100px;
        }

        .lrn-demo-toolbar {
            margin: 0;
            background: #f7f7f7;
            padding: 10px 20px;
            list-style: none;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
        }

        .lrn-demo-btn-save {
            background: #1877b1;
            color: #fff;
            margin-right: 10px;
        }

        .lrn-demo-btn-save:hover,
        .lrn-demo-btn-save:focus {
            background: #0b5684;
        }

        .lrn-demo-toolbar button {
            min-width: 120px;
        }
    </style>
</head>

<body>
<div class="container">
    <header class="header">
        <div class="header-content">
            <span class="logo"></span>Algorithmic Math
        </div>
    </header>
    <div class="my-editor shadow-page">
        <ul class="lrn-demo-wigetSelection" data-demo-component="widgetSelection">
            <li>
                <button class="lrn-demo-btn" type="button" data-value="mcq">MCQ</button>
            </li>
            <li>
                <button class="lrn-demo-btn" type="button" data-value="algorithmicMath">Algorithmic Math</button>
            </li>
        </ul>

        <div class="lrn-demo-questions" data-demo-component="questions">
            <div class="lrn-demo-questions-note">Select the question you would like to add/edit</div>
        </div>

        <div data-demo-component="author" class="lrn-demo-author-form">
            <div data-demo-component="questionEditor"></div>
        </div>

        <ul class="lrn-demo-toolbar" data-demo-component="toolbar">
            <li>
                <button class="lrn-demo-btn lrn-demo-btn-save" type="button" data-demo-component="toolbar.save">Save</button>
            </li>
            <li>
                <button class="lrn-demo-btn lrn-demo-btn-cancel" type="button" data-demo-component="toolbar.cancel">Cancel</button>
            </li>
        </ul>
    </div>
</div>

<script>

(function () {
    var htmlEditor = '<?php echo $htmlEditor; ?>';

    // =============================================================================
    // Configuration of the demo app, this will varied depending the client's usage
    // =============================================================================
    const CONFIG = {
        ALGORITHMIC_MATH: {
            INIT_OPTIONS: {
                security: Learnosity.init(
                    'questions',
                    { consumer_key: 'yis0TYCu7U9V4o7M', user_id: '12345678' },
                    '74c5fd430cf1242a527f6223aebd42d30464be22',
                    {}
                ),
                workersPath: 'build/v1.0.0/workers/'
            }
        },
        QUESTION_EDITOR_API: {
            INIT_OPTIONS: {
                DEFAULT: {
                    configuration: {
                        consumer_key: 'yis0TYCu7U9V4o7M'
                    },
                    rich_text_editor: {
                        type: htmlEditor
                    },
                    widgetType: 'response',
                    ui: {
                        change_button: false,
                        source_button: false,
                        undo_redo_button: false
                    }
                },
                ALGORITHMIC_MATH: {
                    configuration: {
                        consumer_key: 'yis0TYCu7U9V4o7M'
                    },
                    rich_text_editor: {
                        type: htmlEditor
                    },
                    widgetType: 'response',
                    question_type_templates: {
                        formulaV2: [
                            {
                                "name": "Algorithmic Math",
                                "description": "Algorithmic Math question type",
                                "group_reference": "math",
                                "defaults": {
                                    "is_math": true,
                                    "stimulus": "<p>[This is the algorithmic math question type demo.]</p>",
                                    "type": "formulaV2"
                                }
                            }
                        ]
                    },
                    ui: {
                        change_button: false,
                        source_button: false,
                        undo_redo_button: false,
                        layout: {
                            edit_panel: {
                                formulaV2: [
                                    {
                                        layout: 'algorithmic-formulaV2-layout'
                                    }
                                ]
                            }
                        }
                    },
                    label_bundle: {
                        'metadata.dynamic_content_data.variables.button.add': 'Add Variable',
                        'validation.valid_response.score': 'Score value',
                        'template': 'Math Problem'
                    },
                    custom_metadata: {
                        dynamic_content_data: {
                            type: "object",
                            attributes: {
                                equation: {
                                    name: 'Equation',
                                    type: 'string',
                                    required: false
                                },
                                variables: {
                                    name: 'Variables',
                                    type: 'array',
                                    items: {
                                        type: 'object',
                                        attributes: {
                                            name: {
                                                name: 'Name',
                                                type: 'string'
                                            },
                                            min: {
                                                name: 'Min',
                                                type: 'number',
                                                required: true,
                                                default: 0
                                            },
                                            max: {
                                                name: 'Max',
                                                type: 'number',
                                                required: true,
                                                default: 1
                                            },
                                            step: {
                                                name: 'Step',
                                                type: 'number',
                                                required: true,
                                                default: 1
                                            },
                                            decimal_place: {
                                                name: 'Decimal',
                                                type: 'number',
                                                required: false,
                                                default: 0
                                            }
                                        }
                                    }
                                },
                                added_answers: {
                                    namme: 'Added answers',
                                    type: 'array',
                                    required: false,
                                    items: {
                                        type: 'object',
                                        attributes: {
                                            row_index: {
                                                name: 'Row index',
                                                type: 'number'
                                            },
                                            value: {
                                                name: 'Value',
                                                type: 'number'
                                            }
                                        }
                                    }
                                },
                                exclude: {
                                    name: 'Exclude rows',
                                    required: false,
                                    type: 'array',
                                    items: {
                                        type: 'number'
                                    }
                                }
                            }
                        }
                    }
                }
            },
            SUPPORTED_WIDGETS: {
                mcq: {
                    "options": [
                        {
                            "label": "[Choice A]",
                            "value": "0"
                        },
                        {
                            "label": "[Choice B]",
                            "value": "1"
                        },
                        {
                            "label": "[Choice C]",
                            "value": "2"
                        },
                        {
                            "label": "[Choice D]",
                            "value": "3"
                        }
                    ],
                    "stimulus": "<p>[This is the stem.]</p>",
                    "type": "mcq",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [
                                "0",
                                "1"
                            ]
                        }
                    },
                    "instant_feedback": true,
                    "ui_style": {
                        "type": "horizontal"
                    }
                },
                algorithmicMath: {
                    "is_math": true,
                    "stimulus": "Sally has {{var:x}} apples, she gives {{var:y}} apples to Jack. How many apples does she have left?",
                    "type": "formulaV2",
                    "validation": {
                        "scoring_type": "exactMatch",
                        "valid_response": {
                            "score": 1,
                            "value": [{
                                "method": "equivLiteral",
                                "value": "{{var:correctAnswer}}",
                                "options": {
                                    "inverseResult": false,
                                    "decimalPlaces": 10
                                }
                            }]
                        }
                    },
                    "metadata": {
                        "dynamic_content_data": {
                            "variables": [
                                {"name": "x", "min": 10, "max": 15, "step": 1},
                                {"name": "y", "min": 1, "max": 14, "step": 1}
                            ],
                            "equation": "{{var:x}}-{{var:y}}={{response}}"
                        }
                    }
                }
            }
        }
    };

    const STATE = {
        AUTHORING: 'authoring',
        PREVIEWING: 'previewing'
    };

    const EVENTS = {
        SAVE: 'save',
        CREATE: 'create',
        UPDATE: 'update',
        CANCEL: 'cancel'
    };

    const elementUtils = {
        hide(element) {
            element.style.display = 'none';
        },

        show(element) {
            element.style.display = '';
        }
    };

    // ============================================================================================
    // Demo App's Components ======================================================================
    // ============================================================================================

    /**
     * A light-weight utility class that is responsible to listen and dispatch event
     */
    class EventBus {
        constructor() {
            this.repository = {};
        }

        subscribe(evtType, fn) {
            const { repository } = this;

            repository[evtType] = repository[evtType] || [];

            if (typeof fn === 'function' && repository[evtType].indexOf(fn) < 0) {
                repository[evtType].push(fn);
            }

            return this;
        }

        dispatch(evtType, data) {
            const { repository } = this;

            if (repository[evtType]) {
                repository[evtType].forEach(fn => fn(data));
            }

            return this;
        }
    }

    /**
     * This class is responsible to trigger CREATE event after user select a question type to create
     * */
    class WidgetSelection {
        constructor(options) {
            const onWidgetSelectionClick = this.onWidgetSelectionClick.bind(this);

            this.eventBus = options.eventBus;
            this.el = document.querySelector('[data-demo-component="widgetSelection"]');
            this.buttons = this.el.querySelectorAll('button');

            this.buttons.forEach(button => button.addEventListener('click', onWidgetSelectionClick));
        }

        onWidgetSelectionClick(e) {
            const btn = e.currentTarget;
            const widgetType = btn.dataset.value;
            const widgetName = btn.textContent || btn.innerText;

            this.eventBus.dispatch(EVENTS.CREATE, { widgetType, widgetName});
        }

        setState(state) {
            const disabled = state === STATE.AUTHORING ? 'disabled' : '';

            this.buttons.forEach(btn => btn.disabled = disabled);
        }
    }

    /**
     * A class that is responsible to dispatch SAVE or CANCEL event back the main app instance
     * */
    class Toolbar {
        constructor(options) {
            this.eventBus = options.eventBus;

            this.el = document.querySelector('[data-demo-component="toolbar"]');
            this.components = {
                saveButton: document.querySelector('[data-demo-component="toolbar.save"]'),
                cancelButton: document.querySelector('[data-demo-component="toolbar.cancel"]')
            };

            this.addEvents();
        }

        addEvents() {
            const { saveButton, cancelButton } = this.components;

            cancelButton.addEventListener('click', () => this.eventBus.dispatch(EVENTS.CANCEL));
            saveButton.addEventListener('click', () => this.eventBus.dispatch(EVENTS.SAVE));
        }

        setState(state) {
            const { el } = this;
            const { hide, show } = elementUtils;


            if (state === STATE.AUTHORING) {
                show(el);
            } else {
                hide(el);
            }
        }
    }

    /**
     * A class that is used to display what question has been created
     * */
    class QuestionsForm {
        constructor(options) {
            this.eventBus = options.eventBus;
            this.questions = [];
            this.el = document.querySelector('[data-demo-component="questions"]');

            this.el.addEventListener('click', this.onEditClick.bind(this));
        }

        onEditClick(e) {
            if (e.target) {
                const element = (() => {
                    if (e.target.matches('button')) {
                        return e.target;
                    } else if (e.target.parentElement.matches('button')) {
                        return e.target.parentElement;
                    }
                })();

                if (element) {
                    const index = element.dataset.index;
                    const data = this.questions[index];

                    this.eventBus.dispatch(EVENTS.UPDATE, {
                        index,
                        widgetName: data.widgetName,
                        json: data.json
                    });
                }
            }
        }

        add(data) {
            const { questions } = this;
            const element = this.createQuestionElement(questions.length, data);

            this.el.appendChild(element);
            this.questions.push(data);
        }

        update(index, data) {
            const el = this.el;
            const oldElement = el.querySelector(`[data-index="${index}"]`).parentElement;
            const newElement = this.createQuestionElement(index, data);

            el.replaceChild(newElement, oldElement);
            this.questions[index] = data;
        }

        setState(state) {
            const { show, hide } = elementUtils;
            const { el } = this;

            if (state === STATE.AUTHORING) {
                hide(el);
            } else {
                show(el);
            }
        }

        get ready() {
            return this._ready;
        }

        createQuestionElement(index, data) {
            const element = document.createElement('DIV');

            element.innerHTML =
                `<button class="lrn-demo-btn lrn-demo-question" type="button" title="Click to edit" data-index="${index}">
                    <span>${data.widgetName}</span>
                    <span>Click to edit your question</span>
                </button>`;

            return element;
        }
    }


    /**
     * Most important component of the app. This component will initialize a new questionEditor app with different
     * initOptions each time it's asked to create or edit a widget's json.
     * The reason we need to initialize new questionEditorApp instance is so we can pass different
     * initOptions' custom_metadata like default custom_metadata for all question types and special custom_metadata
     * for algorithmic Math question.
     *
     * ** NOTE THAT ** keep initializing question Editor is not a good approach, only re-initializing the app if you need
     * to use different initOptions like in the case of Algorithmic Math
     * */
    class AuthorForm {
        constructor(options) {
            this.eventBus = options.eventBus;
            this.el = document.querySelector('[data-demo-component="author"]');
        }

        /**
         * Ini
         * @param type
         * @param widgetJson
         */
        loadQuestionEditorAPI(type, widgetJson) {
            const { INIT_OPTIONS, SUPPORTED_WIDGETS } = CONFIG.QUESTION_EDITOR_API;
            const json = widgetJson || SUPPORTED_WIDGETS[type];
            let initOptions = type === 'algorithmicMath' ? INIT_OPTIONS.ALGORITHMIC_MATH : INIT_OPTIONS.DEFAULT;

            initOptions = Object.assign({}, initOptions, { widget_json: json });

            this.questionEditorApp = LearnosityQuestionEditor.init(initOptions, '[data-demo-component="questionEditor"]');
            this.questionEditorApp.on('editor:ready', () => {
                const { security, workersPath } = CONFIG.ALGORITHMIC_MATH.INIT_OPTIONS;

                // This flag is used to tell if questionEditorApp is ready to be used or not
                this._ready = true;

                // Create new algorithmicMathApp
                if (type === 'algorithmicMath') {
                    this.algorithmicMathApp = new LRNAlgorithmicMath({
                        security,
                        workersPath,
                        questionEditorApp: this.questionEditorApp
                    });
                }
            });

            this._ready = false;
        }

        setState(state) {
            const { el } = this;
            const { show, hide } = elementUtils;

            if (state === STATE.AUTHORING) {
                show(el);
            } else { // Clean up questionEditorApp & algorithmicMathApp
                const { questionEditorApp, algorithmicMathApp } = this;

                hide(el);

                algorithmicMathApp && algorithmicMathApp.reset();
                questionEditorApp && questionEditorApp.reset();

                this.questionEditorApp = null;
                this.algorithmicMathApp = null;
            }
        }

        createWidget(widgetType) {
            this.loadQuestionEditorAPI(widgetType);
        }

        editWidget(widgetJson) {
            this.loadQuestionEditorAPI(widgetJson.type === 'formulaV2' ? 'algorithmicMath' : widgetJson.type, widgetJson);
        }

        getWidget() {
            if (this.ready) {
                return this.questionEditorApp.getWidget();
            }
        }

        get ready() {
            return this._ready;
        }
    }


    /**
     * Main Demo application.
     * This class is responsible to initialize all necessary components and link them together.
     * User interaction happens on each component will be sent back to this class instance to handle
     */
    class App {

        constructor() {
            const eventBus = new EventBus();
            const defaultOptions = { eventBus };

            this.eventBus = eventBus;

            // Create all necessary components for the app
            this.components = {
                widgetSelection: new WidgetSelection(defaultOptions),
                questionForm: new QuestionsForm(defaultOptions),
                authorForm: new AuthorForm(defaultOptions),
                toolbar: new Toolbar(defaultOptions)
            };

            this.subscribeEvents();

            // Set initial state for the app
            this.setState(STATE.PREVIEWING);
        }

        subscribeEvents() {
            const { eventBus } = this;

            eventBus
                .subscribe(EVENTS.CREATE, this.onCreate.bind(this))
                .subscribe(EVENTS.UPDATE, this.onUpdate.bind(this))
                .subscribe(EVENTS.CANCEL, this.onCancel.bind(this))
                .subscribe(EVENTS.SAVE, this.onSave.bind(this));
        }

        onCreate({widgetType, widgetName}) {
            const { authorForm } = this.components;

            this._action = {
                type: EVENTS.CREATE,
                payload: {
                    widgetName
                }
            };

            this.setState(STATE.AUTHORING);

            authorForm.createWidget(widgetType);
        }

        onUpdate({ index, json, widgetName }) {
            const { authorForm } = this.components;

            this._action = {
                type: EVENTS.UPDATE,
                payload: {
                    index,
                    widgetName
                }
            };

            this.setState(STATE.AUTHORING);

            authorForm.editWidget(json);
        }

        onCancel() {
            this._action = null;
            this.setState(STATE.PREVIEWING);
        }

        onSave() {
            const { questionForm, authorForm } = this.components;
            const widgetJson = authorForm.getWidget();
            const action = this._action;

            if (action.type === EVENTS.CREATE) {
                questionForm.add({
                    widgetName: action.payload.widgetName,
                    json: widgetJson
                });
            } else if (action.type === EVENTS.UPDATE) {
                questionForm.update(action.payload.index, {
                    widgetName: action.payload.widgetName,
                    json: widgetJson
                });
            }

            this.setState(STATE.PREVIEWING);
        }

        /**
         * Calling this method will trigger setState of all children components
         * @param state
         */
        setState(state) {
            for (let name in this.components) {
                this.components[name].setState(state);
            }

            this.state = state;
        }
    }


    // =============================================
    // App usage ===================================
    // =============================================
    const app = new App();
})();
</script>
</body>

</html>
