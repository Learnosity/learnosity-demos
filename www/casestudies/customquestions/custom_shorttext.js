/*global LearnosityAmd*/
LearnosityAmd.define(['jquery-v1.10.2'], function ($) {
    'use strict';

    function CustomShorttext(init) {
        this.init = init;

        init.$el.html('<input type="text" />');

        var $response = $('input', init.$el);

        if (init.response) {
            $response.val(init.response);
        }

        $response.change(function (event) {
            init.events.trigger('changed', event.currentTarget.value);
        });

        init.events.trigger('ready');
    }

    function CustomShorttextScorer(question, response) {
        this.question = question;
        this.response = response;
    }

    CustomShorttextScorer.prototype.isValid = function () {
        return this.response === this.question.valid_response;
    };

    CustomShorttextScorer.prototype.score = function () {
        return this.isValid() ? this.maxScore() : 0;
    };

    CustomShorttextScorer.prototype.maxScore = function () {
        return this.question.score || 1;
    };

    return {
        Question: CustomShorttext,
        Scorer:   CustomShorttextScorer
    };
});
