LearnosityAmd.define([
    'underscore-v1.5.2',
    'vendor/mathcore'
], function ( _, mathcore) {
    'use strict';

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

    Scorer.prototype.canValidateResponse = function() {
        return true;
    };

    return {
        Scorer: Scorer
    };
});
