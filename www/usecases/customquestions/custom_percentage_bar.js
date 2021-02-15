/*global LearnosityAmd*/
LearnosityAmd.define(['jquery-v1.10.2'], function ($) {
    'use strict';

    var PercentageBar = function (options) {
        var template = '<div class="percentage-bar-wrapper"><div class="percentage-bar-inner"><ul class="percentage-bar-num percentage-bar-value"><li class="percentage-bar-min"></li><li class="percentage-bar-max"></li></ul><span class="percentage-bar-val"></span><input type="range" id="rangeSlider" class="percentage-bar"><ul class="percentage-bar-num percentage-bar-percentage"><li class="percentage-bar-min"></li><li class="percentage-bar-max"></li></ul></div></div>',
            $bar, $barMinValue, $barMaxValue, $barPercentageMin, $barPercentageMax, $currentValue, $percentageBarWrapper,
            prepend_unit = "",
            append_unit = "",
            min_percentage = 0,
            max_percentage = 100,
            self = this;

        this.$el = options.$el;

        this.$el.html(template);

        // Cache selections
        $bar =                  $('.percentage-bar', this.$el);
        $barMinValue =          $('.percentage-bar-value .percentage-bar-min', this.$el);
        $barMaxValue =          $('.percentage-bar-value .percentage-bar-max', this.$el);
        $barPercentageMin =     $('.percentage-bar-percentage .percentage-bar-min', this.$el);
        $barPercentageMax =     $('.percentage-bar-percentage .percentage-bar-max', this.$el);
        $currentValue =         $('.percentage-bar-val', this.$el);
        $percentageBarWrapper = $('.percentage-bar-wrapper', this.$el);

        if (typeof options.question.prepend_unit !== 'undefined') {
            prepend_unit = options.question.prepend_unit;
        }

        if (typeof options.question.append_unit !== 'undefined') {
            append_unit = options.question.append_unit;
        }

        if (typeof options.question.min_percentage !== 'undefined') {
            min_percentage = options.question.min_percentage;
        }

        if (typeof options.question.max_percentage !== 'undefined') {
            max_percentage = options.question.max_percentage;
        }

        $barMinValue.text(prepend_unit + options.question.min_value + append_unit);
        $barMaxValue.text(prepend_unit + options.question.max_value + append_unit);

        $bar.attr({
            min: options.question.min_value,
            max: options.question.max_value,
            step: options.question.step
        });

        $barPercentageMin.text(min_percentage + '%');
        $barPercentageMax.text(max_percentage + '%');
        $bar.css('background-color', options.question.bar_color);

        if (options.response) {
            $bar.val(options.response);
        } else {
            $bar.val(options.question.init_value);
        }

        $currentValue.text(prepend_unit + $bar.val() + append_unit);

        // IE10 doesn't support oninput hence we need onchange as well
        $bar.on('input change', function () {
            $currentValue.text(prepend_unit + $bar.val() + append_unit);
            options.events.trigger('changed', $bar.val());
            $percentageBarWrapper.removeClass('percentage-bar-valid').removeClass('percentage-bar-invalid');
        });

        // Create scorer
        this.scorer = new PercentageBarScorer(options.question, $bar.val());

        function validate()
        {
            if (self.scorer.updateResponse($bar.val()).isValid()) {
                $percentageBarWrapper.addClass('percentage-bar-valid');
            } else {
                $percentageBarWrapper.addClass('percentage-bar-invalid');
            }
        }

        options.events.on('validate', function () {
            validate();
        });

        if (options.state === 'review') {
            validate();
        }

        options.events.trigger('ready');
    };

    function PercentageBarScorer(question, response)
    {
        this.question = question;
        this.response = response;
    }

    PercentageBarScorer.prototype.updateResponse = function (response) {
        this.response = response;
        return this;
    };

    PercentageBarScorer.prototype.isValid = function () {
        return this.response === this.question.valid_response;
    };

    PercentageBarScorer.prototype.score = function () {
        return this.isValid() ? this.maxScore() : 0;
    };

    PercentageBarScorer.prototype.maxScore = function () {
        return this.question.score || 1;
    };

    PercentageBarScorer.prototype.canValidateResponse = function () {
        return !!this.question.valid_response;
    };

    return {
        Question: PercentageBar,
        Scorer:   PercentageBarScorer
    };
});
