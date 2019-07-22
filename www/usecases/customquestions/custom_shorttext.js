/*global LearnosityAmd*/
LearnosityAmd.define([
    'underscore',
    'jquery-v1.10.2'
], function (
    _,
    $
) {
    'use strict';

    function getValidResponse(question) {
        return (
            _.isObject(question) &&
            question.valid_response
        ) || '';
    }

    function CustomShorttext(init, lrnUtils) {
        this.init = init;
        this.lrnUtils = lrnUtils;
        this.question = init.question;
        this.$el = init.$el;

        this.setup();

        init.events.trigger('ready');
    }

    _.extend(CustomShorttext.prototype, {
        render: function () {
            this.$el
                .html('<div><div class="input-wrapper"><input type="text" /></div></div>')
                .append('<div data-lrn-component="suggestedAnswersList"/>')
                // Add correct answer list UI
                // .append('<div class="lrn_correctAnswers lrn_hide"><span>' + this.init.getI18nLabel('correctAnswers') + '</span><ul class="lrn_correctAnswerList"></ul></div>')
                // Add LRN Check Answer button. If you plan to have different html structure (no lrn_validate class) for this Check Anwser, you will need to write your own validation function
                // like myCustomButton.addEventListener('click', function () { this.init.getFacade().validate(); })
                .append('<div data-lrn-component="checkAnswer"/>');

            this.$el
                .find('input')
                .width(this.question.width)
                .height(this.question.height);

            this.lrnUtils.renderComponent('CheckAnswerButton', this.$el.find('[data-lrn-component="checkAnswer"]').get(0));
        },

        setup: function () {
            var init = this.init;
            var events = init.events;
            var facade = init.getFacade();

            this.updatePublicMethods(facade);
            this.render();

            this.$response = $('input', this.$el);
            this.$correctAnswers = $('.lrn_correctAnswers', this.$el);

            if (init.response) {
                this.$response.val(init.response);
            }

            // Developer is responsible to know when to clean up the validation UI as well as when to trigger the 'changed' event to update
            // the model value
            this.$response
                .on('focus', function () {
                    this.clearValidationUI();
                    this.hideCorrectAnswers();
                }.bind(this))
                .on('change', function (event) {
                    events.trigger('changed', event.currentTarget.value);
                });

            // "validate" event can be triggered when Check Answer button is clicked or when public method .validate() is called
            // so developer needs to listen to this event to decide if he wants to display the correct answers to user or not
            // options.showCorrectAnswers will tell if correct answers for this question should be display or not.
            // The value showCorrectAnswers by default is the value of showCorrectAnswers inside initOptions object that is used
            // to initialize question app or the value of the options that is passed into public method validate (like question.validate({showCorrectAnswers: false}))
            events.on('validate', function (options) {
                var result = facade.isValid(); // Use facade.isValid(true) to get the detailed report

                this.clearValidationUI();
                this.showValidationUI(result);

                if (!result && options.showCorrectAnswers) {
                    this.showCorrectAnswers();
                }
            }.bind(this));
        },

        showValidationUI: function (isCorrect) {
            this.$el
                .find('.input-wrapper')
                // Add "lrn_response_index_visible" class if you want to display the index of current response
                .addClass('lrn_response_index_visible')
                // Add this class to display default Learnosity correct, incorrect style
                .addClass(isCorrect ? 'lrn_correct' : 'lrn_incorrect')
                // After adding the class "lrn_response_index_visible", you then can inject the response index element
                .prepend('<span class="lrn_responseIndex"><span>1</span></span>')
                // Add this element if you want to display to corresponding validation (cross, tick) icon
                .append('<span class="lrn_validation_icon"/>');
        },

        clearValidationUI: function () {
            this.$correctAnswers
                .addClass('lrn_hide')
                .find('.lrn_correctAnswerList')
                .empty();

            var $validatedResponse = this.$el
                .find('.input-wrapper')
                .removeClass('lrn_incorrect lrn_correct');

            $validatedResponse.find('.lrn_validation_icon').remove();
            $validatedResponse.find('.lrn_responseIndex').remove();
        },

        showCorrectAnswers: function () {
            var self = this;
            var correctAnswerText = getValidResponse(this.question);
            var setAnswersToSuggestedList = function () {
                // Pass in string to display correct answer list without the index
                // this.suggestedAnswersList.setAnswers(correctAnswerText);

                // Pass in an array of object which contains index and label to render a list
                // of suggested answers
                self.suggestedAnswersList.setAnswers([{
                    index: 0,
                    label: correctAnswerText
                }]);
            };

            if (!this.suggestedAnswersList) {
                this.lrnUtils.renderComponent('SuggestedAnswersList', this.$el.find('[data-lrn-component="suggestedAnswersList"]').get(0))
                    .then(function (component) {
                        self.suggestedAnswersList = component;

                        setAnswersToSuggestedList();
                    });
            } else {
                setAnswersToSuggestedList();
            }
        },

        hideCorrectAnswers: function () {
            if (this.suggestedAnswersList) {
                // Clear current suggsted answer list
                this.suggestedAnswersList.reset();
            }
        },

        updatePublicMethods: function (facade) {
            var self = this;

            // Override mandatory public methods
            var _enable = facade.enable;
            facade.enable = function () {
                _enable();
                self.$response.prop('disabled', false);
            };

            var _disable = facade.disable;
            facade.disable = function () {
                _disable();
                self.$response.prop('disabled', true);
            };

            // Add new public methods
            facade.reset = function () {
                self.$response
                    .val('')
                    .trigger('changed');
            };

        }
    });

    function CustomShorttextScorer(question, response) {
        this.question = question;
        this.response = response;
        this.validResponse = getValidResponse(question);
    }

    _.extend(CustomShorttextScorer.prototype, {
        isValid: function () {
            return this.response === this.validResponse;
        },

        score: function () {
            return this.isValid() ? this.maxScore() : 0;
        },

        maxScore: function () {
            return this.question.score != null? this.question.score : null;
        },

        canValidateResponse: function () {
            return !!this.question.valid_response;
        }
    });

    return {
        Question: CustomShorttext,
        Scorer:   CustomShorttextScorer
    };
});
