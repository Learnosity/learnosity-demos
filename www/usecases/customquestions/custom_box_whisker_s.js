LearnosityAmd.define([
    'underscore-v1.5.2'
], function ( _ ) {
    'use strict';

    var bnwS = function (question, response) {
        var self = this;

        this.question = question;
        this.response = response;

        Object.defineProperty(this, 'whatsWrong', { get: function () {
            var
             pack = []
            ;

            if (self.response.range_1 != self.question.valid_range_1) {
                pack.push('range_1');
            }

            if (self.response.quartile_1 != self.question.valid_quartile_1) {
                pack.push('quartile_1');
            }

            if (self.response.median != self.question.valid_median) {
                pack.push('median');
            }

            if (self.response.quartile_3 != self.question.valid_quartile_3) {
                pack.push('quartile_3');
            }

            if (self.response.range_2 != self.question.valid_range_2) {
                pack.push('range_2');
            }

            return pack;
        }});
    };

    bnwS.prototype.updateResponse = function () {
        //this.response = response;
        return this;
    };

    bnwS.prototype.isValid = function () {

        return this.whatsWrong.length <= 0;
    };

    bnwS.prototype.score = function () {
        return this.isValid() ? this.maxScore() : 0;
    };

    bnwS.prototype.maxScore = function () {
        return this.question.score || 1;
    };

    return {
        Scorer: bnwS
    };

});
