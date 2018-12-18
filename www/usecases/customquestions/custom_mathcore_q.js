LearnosityAmd.define([
    'jquery-v1.10.2',
    'underscore-v1.5.2',
    'mathcore'
], function ($, _, mathcore) {
    'use strict';

    var padding = 10,
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
   
            var isValid = options.getFacade().isValid();
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

    return {
        Question: Question
    };
});
