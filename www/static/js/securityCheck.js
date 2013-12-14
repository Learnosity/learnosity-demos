/*global $, require, jsSHA, window, LearnosityApp, _, CodeMirror, js_beautify */
$(function () {
    "use strict";
    var concatenated = "",
        activityTemplate = 'var activity={"consumer_key":"<%= act.consumer_key %>","timestamp":"<%= act.timestamp %>","signature":"<%= act.signature %>","user_id":"<%= act.user_id %>", ... };',
        defaults = {
            consumer_key: 'soCnIErF4fojFiKe',
            domain: location.hostname,
            timestamp: window.timestamp,
            user_id: '12345678',
            consumer_secret: '457e0592c9a63b9d6cd39966c49db45c7ceee784'
        },
        domain = "questions.learnosity.com",
        LearnosityApp = {},
        questionsApiComms;

    function initialiseQuestionsAPI() {
        LearnosityApp._internal = {};
        LearnosityApp._internal.config = {
            apiHost: 'http://' + domain + "/latest"
        };
        window.LearnosityApp = LearnosityApp;

        var apiModules = 'http://' + domain + '/latest/app/';
        require.config({
            baseUrl: apiModules,
            paths: {
                vendor: '../vendor'
            }
        });
        require(['comms'], function (comms) {
            questionsApiComms = comms;
        });
    }

    function updateActJsonArea() {
        var actText = _.template(activityTemplate, { act: {
            consumer_key: $('#consumer_key').val(),
            timestamp: $('#timestamp').val(),
            user_id: $('#user_id').val(),
            signature: $('#signature').val()
        } });

        CodeMirror.runMode(js_beautify(actText), {name: "javascript", json: true}, $('#actJson')[0]);
    }

    function loadDefaults() {
        $('#consumer_key').val(defaults.consumer_key);
        $('#domain').val(defaults.domain);
        $('#domain_override').val(defaults.domain);
        $('#timestamp').val(defaults.timestamp);
        $('#user_id').val(defaults.user_id);
        $('#consumer_secret').val(defaults.consumer_secret);
        $('#signature').val('');
        $('#serverresponse').html('');
    }

    function concatenateStringAndGenerateSignature() {
        concatenated = "";
        concatenated += $('#consumer_key').val();
        concatenated += '_';
        concatenated += $('#domain_override').val();
        concatenated += '_';
        concatenated += $('#timestamp').val();
        concatenated += '_';
        concatenated += $('#user_id').val();
        concatenated += '_';
        concatenated += $('#consumer_secret').val();


        var conc = "";
        conc += '<span title="consumer_key" class="conpart">' + $('#consumer_key').val() + '</span>';
        conc += '<strong>_</strong>';
        conc += '<span title="domain" class="conpart2">' + $('#domain_override').val() + '</span>';
        conc += '<strong>_</strong>';
        conc += '<span title="timestamp" class="conpart">' + $('#timestamp').val() + '</span>';
        conc += '<strong>_</strong>';
        conc += '<span title="user_id" class="conpart2">' + $('#user_id').val() + '</span>';
        conc += '<strong>_</strong>';
        conc += '<span title="consumer_secret" class="conpart">' + $('#consumer_secret').val() + '</span>';

        $('#concatenation').html(conc);


        var shaObj = new jsSHA(concatenated);
        $('#signature').val(shaObj.getHash("SHA-256", "HEX"));
    }

    function testSuccess(response) {
        $('#serverresponse').html("Authentication successful");
    }

    function testError(response) {
        $('#serverresponse').html(response.status + ' - ' + response.response.meta.message);
    }

    function submitToServer(withSecurity) {
        $('#serverresponse').html('');
        if (questionsApiComms) {
            questionsApiComms.request({
                url: '/authenticate',
                security: {
                    consumer_key: $('#consumer_key').val(),
                    domain:       $('#domain_override').val(),
                    timestamp:    $('#timestamp').val(),
                    user_id:      $('#user_id').val(),
                    signature:    $('#signature').val()
                },
                success: testSuccess,
                failure: testError
            });
        }
    }


    $('form').on('submit', function (e) {
        e.preventDefault();
    });

    $('#domain').val(location.hostname);

    $(':text').keypress(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $(this).blur();
        }
    });

    $('.signaturePart').change(function () {
        concatenateStringAndGenerateSignature();
        updateActJsonArea();
    });

    $('#signature').change(function () {
        updateActJsonArea();
    });


    $('#resetbtn').click(function () {
        loadDefaults();
        concatenateStringAndGenerateSignature();
        updateActJsonArea();
    });

    $('#testbtn').click(function () {
        submitToServer(true);
    });

    initialiseQuestionsAPI();
    loadDefaults();
    concatenateStringAndGenerateSignature();
    updateActJsonArea();
});
