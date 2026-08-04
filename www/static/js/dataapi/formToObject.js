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
 *
 * Plain ES6 - no jQuery. See docs/bootstrap-5-upgrade.md
 */
const formToObject = (function () {
    'use strict';

    /**
     * @param {HTMLFormElement} frm Form element
     * @return {object}
     */
    function parse (frm) {
        return translateFormInputs(getFormElements(frm));
    }

    /**
     * Returns all form inputs that have id's prefixed with 'api-'
     * @param  {HTMLFormElement} frm Form element
     * @return {Array<HTMLElement>}
     */
    function getFormElements (frm) {
        return [...frm.querySelectorAll('[id^=api-]')];
    }

    /**
     * Splits a comma separated value into trimmed, non-empty parts.
     * @param  {string} value
     * @return {Array<string>}
     */
    function splitList (value) {
        return value.split(',').map((part) => part.trim());
    }

    /**
     * Translate form inputs into a JavaScript object. DSL is defined
     * by 'data' attributes. We also expect elements to have specific
     * 'id' prefixing.
     * @param  {Array<HTMLElement>} els Form inputs
     * @return {object}
     */
    function translateFormInputs (els) {
        const request = {};

        els.forEach((el) => {
            const type = el.dataset.type;
            const parameter = el.id.replace('api-', '').split('~')[0];
            const value = (el.value || '').trim();

            if (parameter === 'endpoint') {
                return;
            }

            switch (type) {
                case 'objectarray':
                    if (value.length) {
                        const param = parameter.split(':');
                        const val = splitList(value);
                        if (val.length) {
                            if (request[param[0]] === undefined) {
                                request[param[0]] = {};
                            }
                            request[param[0]][param[1]] = val;
                        }
                    }
                    break;
                case 'array':
                    if (value.length) {
                        request[parameter] = splitList(value);
                    }
                    break;
                case 'array_single':
                    if (value.length) {
                        request[parameter] = [value];
                    }
                    break;
                case 'checkboxarray':
                    if (el.checked) {
                        if (request[parameter] === undefined) {
                            request[parameter] = [];
                        }
                        request[parameter].push(el.value);
                    }
                    break;
                case 'boolean':
                    if (!el.checked) {
                        return;
                    }
                    request[parameter] = value === '1';
                    break;
                case 'integer':
                    if (!value.length) {
                        return;
                    }
                    request[parameter] = isNaN(value) ? 0 : parseInt(value, 10);
                    break;
                case 'string':
                    if (!value.length) {
                        return;
                    }
                    request[parameter] = value;
                    break;
                case 'json':
                    try {
                        request[parameter] = JSON.parse(value);
                    } catch (e) { /* leave the parameter unset on malformed JSON */ }
                    break;
                default:
                    break;
            }
        });

        return request;
    }

    return {
        parse: parse
    };
}());
