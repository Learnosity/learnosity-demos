LearnosityAmd.define([
    'jquery-v1.10.2',
    'underscore-v1.5.2',
    'vendor/mathcore'
], function ($, _, mathcore) {
    'use strict';

    var padding = 10,
        defaults = {
            "is_math": true,
            "response_id": "custom-mathcore-response-<?php echo $session_id; ?>",
            "type": "custom",
            "js": "//docs.vg.learnosity.com/demos/products/questionsapi/questiontypes/assets/mathcore/mathcore.js",
            "css": "//docs.vg.learnosity.com/demos/products/questionsapi/questiontypes/assets/mathcore/mathcore.css",
            "stimulus": "Simplify following expression: <b>\\(2x^2 + 3x - 5 + 5x - 4x^2 + 20\\)</b>",
            "score": 1,
            "specs": [{
                "method": "isSimplified"
            }, {
                "method": "equivSymbolic",
                "value": "2x^2 + 3x - 5 + 5x - 4x^2 + 20"
            }]
        },
        template = _.template('<div class="response_wrapper"><input type="text" /></div>');

    var Question = function(options) {

        var $response, $input,
            self = this,
            triggerChanged = function () {
                self.clear();
                setTimeout(function () {
                    options.events.trigger('changed', $input.val());
                }, 500);
            };

        self.clear = function () {
            $response.removeClass('valid');
            $response.removeClass('notValid');
        };

        self.validate = function () {
            var scorer = new Scorer(options.question, $input.val()),
                isValid = scorer.isValid();
            self.clear();
            if (isValid) {
                $response.addClass('valid');
            } else {
                $response.addClass('notValid');
            }
        };

        options.events.on('validate', function () {
            self.validate();
        });

        if (options.state === 'review') {
            self.validate();
        }

        if (options.response) {
            $input.val(options.response);
        }

        options.$el.html(template());
        options.events.trigger('ready');

        $response = options.$el.find('.response_wrapper');
        $input = $response.find('input');

        $input.on('change keydown', triggerChanged);
        triggerChanged();
    };

    var Scorer = function (question, response) {
        this.question = question;
        this.response = response;
    };

    Scorer.prototype.isValid = function() {
        var i, temp,
            isValid = true;
        for(i = 0; i < this.question.specs.length; i ++) {
            temp = mathcore.validate(this.question.specs[i], this.response);
            isValid = isValid && temp.result;
        }
        return isValid;
    };

    Scorer.prototype.score = function() {
        return this.isValid() ? this.maxScore() : 0;
    };

    Scorer.prototype.maxScore = function() {
        return this.question.score || 1;
    };

    return {
        Question: Question,
        Scorer: Scorer
    };
});
