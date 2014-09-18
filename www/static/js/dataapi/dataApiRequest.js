/**
 * Listens for form submission and submits an xhr request
 * to a server side proxy to handle cross-domain API requests.
 *
 * Also translates form inputs to JSON for display.
 */
(function($, config, Ladda, prettyPrint) {
    'use strict';

    /**
     * Retrieve the form in the current active tab,
     * each panel has its own form.
     * Parse the form, write the resulting JSON to
     * the 'request' tab.
     * @param  {object} frm Form handle
     * @return {object}     Object used to POST to the data api
     */
    function prepareApiRequest (frm) {
        var obj = formToObject.parse(frm),
            endpoint = $(frm).find('#endpoint').val(),
            resource = $(frm).data('resource'),
            request;

        request = {
            security: config.apiRequest.security,
            request: obj
        };

        // Write to the request JSON tab
        $('#request-'+resource).html(prettyPrint.render(request));

        return {
            endpoint: endpoint,
            request: obj,
            resource: resource
        };
    }

    /**
     * Ajax callback - writes response to 'Response' tab
     * @param  {string} resource Which resource was requested
     * @param  {object} data     JSON object
     * @param  {string} status   Text xhr status
     * @param  {xhr} xhr      xhr object
     * @return {void}
     */
    function renderResponse (resource, data, status, xhr) {
        $('#response-'+resource).html(prettyPrint.render(data));
        $('#nav-dataapi-'+resource+' a[href="#tab-response-'+resource+'"]').tab('show');
    }

    /**
     * Makes an asynchronous to the current domain as a proxy
     * to the Data API
     * @param  {object} request  Request object
     * @param  {string} endpoint Full URL of the data api
     * @param  {string} resource Final resource endpoint
     * @return {void}
     */
    function submitToApi (request, endpoint, resource) {
        $.ajax({
            url: config.www + 'xhr.php',
            data: {'request': JSON.stringify(request), 'endpoint': endpoint},
            dataType: 'json',
            type: 'POST'
        })
        .error(resource, function(xhr, status, data) {
            renderResponse(resource, xhr.responseText, null, null);
        })
        .success(resource, function(data, status, xhr) {
            renderResponse(resource, data, status, xhr);
        });
    }

    $(function() {
        // Render the Request JSON tab when it's clicked
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            var resource = $(e.currentTarget).parents('ul').attr('id').split('-').pop(),
                frm = $('#tab-request-form-'+resource).children('form');
            prepareApiRequest(frm);
        });

        // On submit, send the request to the data api for processing
        $('form').on('submit', function(e) {
            e.preventDefault();
            var frm = $(e.currentTarget).closest('form'),
                obj = prepareApiRequest(frm),
                button = $(frm).find('.ladda-button');

            var ladda = Ladda.create(button[0]);

            $(document).ajaxStart(function() {
                ladda.start();
            });
            $(document).ajaxStop(function() {
                ladda.stop();
            });

            submitToApi(obj.request, obj.endpoint, obj.resource);
        });
    });

    return {};
}(jQuery, config, Ladda, prettyPrint));
