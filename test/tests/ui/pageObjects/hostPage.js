const TEST_PAGE = '/index.html';
const USER_ID = 'testUser';
const GlobalParameters = require ('../lib/globalParameters.js');
const LearnositySDK = require('learnosity-sdk-nodejs');
const AssessApp = require('./assessApp');
const QuestionsApp = require('./questionsApp');
const ItemsApp = require('./itemsApp');
const ReportsApp = require('./reportsApp');
const QuestionEditorApp = require('./questionEditorApp');
const AuthorApp = require('./authorApp');
const AuthorSite = require('./authorSite');
const DataApp = require('./dataApp');

/**
 * Class for Host Page which initializes Assess App on the page
 * @type {HostPage}
 */
module.exports = class HostPage {
    constructor(env, learnosityRegion) {

        this.url = TEST_PAGE;

        this.env = env;
        this.learnosityRegion = learnosityRegion;
        this.userId = USER_ID;
        this.assessApiVersion = testConfig.env === 'vg' ? 'latest' : 'v2';
        this.questionsApiVersion = testConfig.env === 'vg' ? 'latest' : 'v2';
        this.itemsApiVersion = testConfig.env === 'vg' ? 'latest' : 'v1';
        this.reportsApiVersion = testConfig.env === 'vg' ? 'latest' : 'v0';
        this.authorApiVersion = testConfig.env === 'vg' ? 'latest' : 'v1';
        this.questionEditorApiVersion = testConfig.env === 'vg' ? 'latest' : 'v3';
        this.dataApiVersion = testConfig.env === 'vg' ? 'latest' : 'v1';
    }

    /**
     * Open Page in WebDriver
     */
    load(url = this.url) {
        browser.url(url);
    }

    /**
     * Get client JS errors
     */
    getQuestionsAppErrors() {
        return browser.execute(function () {
            return window.LearnosityApp.errors;
        }).value;
    }

    getAssessAppErrors() {
        return browser.execute(function () {
            return window.LearnosityAssess.errors;
        }).value;
    }

    getItemsAppErrors() {
        return browser.execute(function () {
            return window.LearnosityItems.errors;
        }).value;
    }

    getReportsAppErrors() {
        return browser.execute(function () {
            return window.LearnosityReports.errors;
        }).value;
    }

    getEventsAppErrors() {
        return browser.execute(function () {
            return window.LearnosityEvents.errors;
        }).value;
    }

    getQuestionEditorAppErrors() {
        return browser.execute(function () {
            return window.LearnosityQuestionEditor.errors;
        }).value;
    }

    getAuthorAppErrors() {
        return browser.execute(function () {
            return window.LearnosityAuthor.errors;
        }).value;
    }

    /**
     * Initialize Assess on the page and return Assess App object
     */
    initAssessApp(activity) {
        activity.user_id = this.userId;

        const consumerCredentials = GlobalParameters.getConsumerCredentials(this.env, this.learnosityRegion);
        const securityObject = GlobalParameters.getSecurityObject(this.env, this.learnosityRegion, this.userId);
        const assessApiSrcPath = GlobalParameters.getApiSrc('assess', this.env, this.learnosityRegion, this.assessApiVersion);

        // Add assess container to DOM
        browser.execute(() => {
            var span = document.createElement('div');
            var bodyElement = document.getElementsByTagName('body')[0];

            span.className = 'assess';

            bodyElement.appendChild(span);
        });

        const initOptions = new LearnositySDK().init(
            'assess',
            securityObject,
            consumerCredentials.secret,
            activity
        );

        browser.execute((scriptPath, initOptions) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                var initOptionOnThePage = JSON.parse(initOptions);

                window.assessApp = window.LearnosityAssess.init(initOptionOnThePage, '.assess', {
                    readyListener: () => {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, assessApiSrcPath, JSON.stringify(initOptions));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.assessApp && window.apiReadyForTesting;
            }).value;
        });

        return new AssessApp();
    }

    /**
     * Initialize Questions on the page and return Questions App object
     */
    initQuestionsApp(activity, state) {
        const consumerCredentials = GlobalParameters.getConsumerCredentials(this.env, this.learnosityRegion);
        const securityObject = GlobalParameters.getSecurityObject(this.env, this.learnosityRegion, this.userId);
        const questionsApiSrcPath = GlobalParameters.getApiSrc('questions', this.env, this.learnosityRegion, this.questionsApiVersion);

        activity.user_id = this.userId;
        activity.state = state;

        // Add span tags to DOM
        browser.execute((activity) => {
            activity = JSON.parse(activity);
            activity.questions.forEach(function (question) {

                var span = document.createElement('span');
                var bodyElement = document.getElementsByTagName('body')[0];

                span.className = 'learnosity-response ' + 'question-' + question.response_id;

                bodyElement.appendChild(span);
            });
        }, JSON.stringify(activity));

        const initOptions = new LearnositySDK().init(
            'questions',
            securityObject,
            consumerCredentials.secret,
            activity
        );

        browser.execute((scriptPath, initOptions) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                window.initOptionOnThePage = JSON.parse(initOptions);

                window.questionsApp = window.LearnosityApp.init(window.initOptionOnThePage, {
                    readyListener: function () {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, questionsApiSrcPath, JSON.stringify(initOptions));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.questionsApp && window.apiReadyForTesting;
            }).value;
        });

        return new QuestionsApp();
    }

    /**
     * Initialize Items on the page and return Items App object
     */
    initItemsApp(activity, state) {
        activity.state = state;

        const consumerCredentials = GlobalParameters.getConsumerCredentials(this.env, this.learnosityRegion);
        const securityObject = GlobalParameters.getSecurityObject(this.env, this.learnosityRegion, activity.user_id);
        const itemsApiSrcPath = GlobalParameters.getApiSrc('items', this.env, this.learnosityRegion, this.itemsApiVersion);

        // Add span tags to DOM
        browser.execute((activity) => {
            activity = JSON.parse(activity);
            if (activity.rendering_type === 'assess') {
                var div = document.createElement('div');
                var bodyElement = document.getElementsByTagName('body')[0];

                div.id = 'learnosity_assess';

                bodyElement.appendChild(div);
            } else {
                activity.items.forEach(function (item) {

                    var div = document.createElement('div');
                    var bodyElement = document.getElementsByTagName('body')[0];

                    div.className = 'learnosity-item';
                    div.setAttribute('data-reference', item);

                    bodyElement.appendChild(div);
                });
            }
        }, JSON.stringify(activity));

        const initOptions = new LearnositySDK().init(
            'items',
            securityObject,
            consumerCredentials.secret,
            activity
        );

        browser.execute((scriptPath, initOptions) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                window.initOptionOnThePage = JSON.parse(initOptions);

                window.itemsApp = window.LearnosityItems.init(window.initOptionOnThePage, {
                    readyListener: () => {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, itemsApiSrcPath, JSON.stringify(initOptions));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.itemsApp && window.apiReadyForTesting;
            }).value;
        });

        return new ItemsApp(activity.user_id);
    }

    /**
     * Initialize Reports on the page and return Reports App object
     */
    initReportsApp(request) {
        const consumerCredentials = GlobalParameters.getConsumerCredentials(this.env, this.learnosityRegion);
        const securityObject = GlobalParameters.getSecurityObject(this.env, this.learnosityRegion, this.userId);
        const reportsApiSrcPath = GlobalParameters.getApiSrc('reports', this.env, this.learnosityRegion, this.reportsApiVersion);

        // Add span tags to DOM
        if (request.hasOwnProperty('reports')) {
            browser.execute((request) => {
                request = JSON.parse(request);
                request.reports.forEach(function (report) {

                    var span = document.createElement('span');
                    var bodyElement = document.getElementsByTagName('body')[0];

                    span.className = 'learnosity-report';
                    span.setAttribute('id', report.id);

                    bodyElement.appendChild(span);
                });
            }, JSON.stringify(request));
        }

        const initOptions = new LearnositySDK().init(
            'reports',
            securityObject,
            consumerCredentials.secret,
            request
        );

        browser.execute((scriptPath, initOptions) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                window.initOptionOnThePage = JSON.parse(initOptions);

                window.reportsApp = window.LearnosityReports.init(window.initOptionOnThePage, {
                    readyListener: () => {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, reportsApiSrcPath, JSON.stringify(initOptions));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.reportsApp && window.apiReadyForTesting;
            }).value;
        });

        return new ReportsApp();
    }

    /**
     * Initialize Question Editor on the page and return Question Editor App object
     */
    initQuestionEditorApp(request) {
        const questionEditorApiSrcPath = GlobalParameters.getApiSrc('questionEditor', this.env, this.learnosityRegion, this.questionEditorApiVersion);

        // Add div tag to DOM
        browser.execute((request) => {
            request = JSON.parse(request);

            var div = document.createElement('div');
            var bodyElement = document.getElementsByTagName('body')[0];

            div.className = 'learnosity-question-editor';

            bodyElement.appendChild(div);
        }, JSON.stringify(request));

        browser.execute((scriptPath, request) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                window.initOptionOnThePage = JSON.parse(request);

                window.questionEditorApp = window.LearnosityQuestionEditor.init(window.initOptionOnThePage, {
                    readyListener: () => {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, questionEditorApiSrcPath, JSON.stringify(request));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.questionEditorApp && window.apiReadyForTesting;
            }).value;
        });

        return new QuestionEditorApp();
    }

    /**
     * Initialize Author on the page and return Author App object
     */
    initAuthorApp(request) {
        const consumerCredentials = GlobalParameters.getConsumerCredentials(this.env, this.learnosityRegion);
        const securityObject = GlobalParameters.getSecurityObject(this.env, this.learnosityRegion);
        const authorApiSrcPath = GlobalParameters.getApiSrc('authorapi', this.env, this.learnosityRegion, this.authorApiVersion);

        // Add div tag to DOM
        browser.execute(() => {

            var div = document.createElement('div');
            var bodyElement = document.getElementsByTagName('body')[0];

            div.id = 'learnosity-author';

            bodyElement.appendChild(div);
        });

        const initOptions = new LearnositySDK().init(
            'author',
            securityObject,
            consumerCredentials.secret,
            request
        );

        browser.execute((scriptPath, initOptions) => {
            var script = document.createElement('script');
            var bodyElement = document.getElementsByTagName('body')[0];

            function init() {
                window.initOptionOnThePage = JSON.parse(initOptions);

                window.authorApp = window.LearnosityAuthor.init(window.initOptionOnThePage, {
                    readyListener: () => {
                        window.apiReadyForTesting = true;
                    }
                });
            }

            script.src = scriptPath;
            script.onload = init;

            bodyElement.appendChild(script);
        }, authorApiSrcPath, JSON.stringify(initOptions));

        browser.waitUntil(function () {
            return browser.execute(function () {
                return window.authorApp && window.apiReadyForTesting;
            }).value;
        });

        return new AuthorApp();
    }

    /**
     * Initialize Data on the page and return Author App object
     */
    initDataApp() {
        return new DataApp();
    }

    /**
     * Initialize Data on the page and return Author App object
     */
    initAuthorSite() {
        return new AuthorSite();
    }
};
