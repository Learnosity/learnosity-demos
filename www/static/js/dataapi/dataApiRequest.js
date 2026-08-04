/**
 * Listens for form submission and submits a request to a server side proxy
 * to handle cross-domain API requests.
 *
 * Also translates form inputs to JSON for display.
 *
 * Plain ES6 - no jQuery. See docs/bootstrap-5-upgrade.md
 */
(function (config, Ladda, prettyPrint) {
    'use strict';

    /**
     * Retrieve the form in the current active tab,
     * each card has its own form.
     * Parse the form, write the resulting JSON to
     * the 'request' tab.
     * @param  {HTMLFormElement} frm Form element
     * @return {object}              Object used to POST to the data api
     */
    function prepareApiRequest (frm) {
        const obj = formToObject.parse(frm);
        const endpoint = frm.querySelector('#endpoint').value;
        const resource = frm.dataset.resource;
        const actionField = frm.querySelector('#action');
        const action = (actionField && actionField.value) || 'get';

        let security = config.apiRequest.security;
        if (['responses-feedback-update', 'responses-feedback'].includes(resource)) {
            security = config.apiRequest.security_postgres;
        }

        // Write to the request JSON tab
        document.getElementById('request-' + resource).innerHTML = prettyPrint.render({
            action: action,
            security: security,
            request: obj
        });

        return { endpoint: endpoint, request: obj, resource: resource, action: action };
    }

    /**
     * Writes a response to the 'Response' tab and switches to it.
     * @param  {string} resource       Which resource was requested
     * @param  {object|string} data    Parsed JSON, or an error string
     * @return {void}
     */
    function renderResponse (resource, data) {
        document.getElementById('response-' + resource).innerHTML = prettyPrint.render(data);
        const tab = document.querySelector(
            '#nav-dataapi-' + resource + ' a[href="#tab-response-' + resource + '"]'
        );
        if (tab) {
            bootstrap.Tab.getOrCreateInstance(tab).show();
        }
    }

    /**
     * Posts to a script on the current domain, which proxies the Data API so the
     * request can be signed server side. Note the contract with xhr.php: it reads
     * `endpoint`, `request` and `action` out of $_POST.
     * @param  {object} request  Request object
     * @param  {string} endpoint Full URL of the data api
     * @param  {string} resource Final resource endpoint
     * @param  {string} action   Data API action
     * @return {Promise<void>}
     */
    async function submitToApi (request, endpoint, resource, action) {
        const body = new URLSearchParams({
            request: JSON.stringify(request),
            endpoint: endpoint,
            action: action
        });

        try {
            const response = await fetch('xhr.php', { method: 'POST', body: body });
            const text = await response.text();
            // The proxy echoes the API's error message as plain text when the upstream
            // request fails, so a parse failure is still a response worth showing.
            try {
                renderResponse(resource, JSON.parse(text));
            } catch (e) {
                renderResponse(resource, text);
            }
        } catch (error) {
            renderResponse(resource, error.message);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Render the Request JSON tab when it's clicked
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach((tab) => {
            tab.addEventListener('show.bs.tab', function (e) {
                const resource = e.currentTarget.closest('ul').id.split('-').pop();
                const frm = document.querySelector('#tab-request-form-' + resource + ' form');
                if (frm) {
                    prepareApiRequest(frm);
                }
            });
        });

        // On submit, send the request to the data api for processing
        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                const frm = e.currentTarget;
                const obj = prepareApiRequest(frm);
                const button = frm.querySelector('.ladda-button');
                const spinner = button ? Ladda.create(button) : null;

                if (spinner) {
                    spinner.start();
                }
                await submitToApi(obj.request, obj.endpoint, obj.resource, obj.action);
                if (spinner) {
                    spinner.stop();
                }
            });
        });
    });
}(config, Ladda, prettyPrint));
