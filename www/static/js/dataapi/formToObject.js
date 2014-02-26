/**
 * Parses a form instance for specific data attributes and
 * returns an object of name|value pairs.
 *
 * Form inputs are in the format of:
 *      <input type="text" id="api-school_id" data-type="array" value="demo">
 *
 * Where each element id is prefixed with 'api-' and each element has a
 * data-type attribute which could be:
 *     - string
 *     - integer
 *     - array
 */
var formToObject = (function($) {
    'use strict';

    function parse (frm) {
        var elements = getFormElements(frm);

        return translateFormInputs(elements);
    }

    /**
     * Returns all form inputs that have id's prefixed with 'api-'
     * @param  {object} frm Form instance
     * @return {array}
     */
    function getFormElements (frm) {
        var id = frm.attr('id');
        return $('#'+id).find('[id^=api-]');
    }

    /**
     * Translate form inputs into a JavaScript object. DSL is defined by 'data' attributes.
     * @param  {object} els Form instance
     * @return {object}
     */
    function translateFormInputs (els) {
        var request = {},
            parameter,
            type,
            value;
        for (var i = 0, len = els.length; i < len; i++) {
            type = $(els[i]).data('type');
            parameter = $(els[i]).attr('id').replace('api-', '');
            value = $.trim($(els[i]).val());
            if (parameter === 'endpoint') {
                continue;
            }
            switch (type) {
                case 'array':
                    if ($.trim(value).length) {
                        request[parameter] = [];
                        $.each(value.split(','), function() {
                            request[parameter].push($.trim(this));
                        });
                    }
                    break;
                case 'integer':
                    request[parameter] = (isNaN(value) || !value.length) ? 0 : parseInt(value, 10);
                    break;
                case 'string':
                    request[parameter] = value;
                    break;
                default:
                    break;
            }
        }
        return request;
    }

    return {
        parse: parse
    };
}(jQuery));
