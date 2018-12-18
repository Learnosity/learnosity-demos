/*global LearnosityAmd*/
LearnosityAmd.define([], function () {
    'use strict';

    function PercentageBarScorer(question, response) {
        this.question = question;
        this.response = response;
    }

    PercentageBarScorer.prototype.updateResponse = function(response) {
        this.response = response;
        return this;
    };

    PercentageBarScorer.prototype.isValid = function() {
        return this.response === this.question.valid_response;
    };

    PercentageBarScorer.prototype.score = function() {
        return this.isValid() ? this.maxScore() : 0;
    };

    PercentageBarScorer.prototype.maxScore = function () {
        return this.question.score || 1;
    };

    PercentageBarScorer.prototype.canValidateResponse = function() {
        return !!this.question.valid_response;
    };

    return {
        Scorer: PercentageBarScorer
    };
});
