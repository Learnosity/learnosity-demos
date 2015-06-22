/**
 * Parses a form instance for elements with specific data attributes and
 * returns an object of name|value pairs.
 *
 * Form inputs are in the format of:
 *      <input type="text" id="api-school_id" data-type="array" value="demo">
 *
 * Where each element id is prefixed with 'api-' and each element has a
 * data-type attribute which could be:
 *     - array
 *     - boolean
 *     - integer
 *     - string
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
     * Translate form inputs into a JavaScript object. DSL is defined
     * by 'data' attributes. We also expect elements to have specific
     * 'id' prefixing.
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
            parameter = $(els[i]).attr('id').replace('api-', '').split('~')[0];
            value = $.trim($(els[i]).val());
            if (parameter === 'endpoint') {
                continue;
            }
            switch (type) {
                case 'objectarray':
                    if (value.length) {
                        var param = parameter.split(':'), val = [];
                        $.each(value.split(','), function() {
                            val.push($.trim(this));
                        });
                        if (val.length) {
                            if (request[param[0]] === undefined) {
                                request[param[0]] = {}
                            }
                            request[param[0]][param[1]] = val;
                        }
                    }
                    break;
                case 'array':
                    if (value.length) {
                        request[parameter] = [];
                        $.each(value.split(','), function() {
                            request[parameter].push($.trim(this));
                        });
                    }
                    break;
                case 'checkboxarray':
                    if ($(els[i]).is(':checked')) {
                        if (request[parameter] === undefined) {
                            request[parameter] = [];
                        }
                        request[parameter].push($(els[i]).val());
                    }
                    break;
                case 'boolean':
                    if (!$(els[i]).is(':checked')) {
                        continue;
                    }
                    request[parameter] = (value === '1') ? true : false;
                    break;
                case 'integer':
                    if (!value.length) {
                        continue;
                    }
                    request[parameter] = (isNaN(value)) ? 0 : parseInt(value, 10);
                    break;
                case 'string':
                    if (!value.length) {
                        continue;
                    }
                    request[parameter] = value;
                    break;
                case 'json':
                    try {
                        request[parameter] = JSON.parse(value);
                    } catch (e) {}
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
