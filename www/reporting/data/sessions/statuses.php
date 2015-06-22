<?php

$endpoint = "$URL/$version/sessions/statuses";
$resource = 'sessionstatuses';

?>

<ul class="nav nav-tabs" id="nav-dataapi-<?php echo $resource; ?>">
    <li class="active"><a href="#tab-request-form-<?php echo $resource; ?>" data-toggle="tab">Request Form</a></li>
    <li><a href="#tab-request-json-<?php echo $resource; ?>" data-toggle="tab">Request JSON</a></li>
    <li><a href="#tab-response-<?php echo $resource; ?>" data-toggle="tab">Response</a></li>
</ul>
<div class="tab-content">
    <!-- Render the interactive request form -->
    <div class="tab-pane active" id="tab-request-form-<?php echo $resource; ?>">
        <form class="form-horizontal" role="form" method="post" id="frm-data-api-<?php echo $resource; ?>" data-resource="<?php echo $resource; ?>">
            <div class="form-group">
                <label class="col-md-2 control-label">URL</label>
                <div class="col-md-10">
                <input type="text" class="form-control" id="endpoint" value="<?php echo $endpoint; ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">user(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-user_id" data-type="array" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">activity(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-activity_id" data-type="array" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">session(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-session_id" data-type="array" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">status(s)</label>
                <div class="col-md-10">
                    <div class="checkbox">
                        <label for="api-status~incomplete4">
                            <input type="checkbox" id="api-status~incomplete4" data-type="checkboxarray" value="incomplete">
                            Incomplete
                        </label>
                        <br>
                        <label for="api-status~completed4">
                            <input type="checkbox" id="api-status~completed4" data-type="checkboxarray" value="completed">
                            Completed
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">sort</label>
                <div class="col-md-2">
                    <select class="form-control" id="api-sort" data-type="string">
                        <option value="asc" selected>Asc</option>
                        <option value="desc">Desc</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                    mintime
                    <span class="glyphicon glyphicon-question-sign"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="A unix timestamp or ISO 8601 datetime string, indicating a minimum point in time from when to return values.">
                    </span>
                </label>
                <div class="col-md-2">
                    <input type="input" class="form-control" id="api-mintime" data-type="string" value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                    maxtime
                    <span class="glyphicon glyphicon-question-sign"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="A unix timestamp or ISO 8601 datetime string, indicating a maximum point in time to return values.">
                    </span>
                </label>
                <div class="col-md-2">
                    <input type="input" class="form-control" id="api-maxtime" data-type="string" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">count only?</label>
                <div class="col-md-10">
                    <div class="radio">
                        <label>
                            <input type="radio" name="count" id="api-count" data-type="boolean" value="1">
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="count" id="api-count" data-type="boolean" value="0" checked>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">limit</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="api-limit" data-type="integer" min="1" max="1000" value="5">
                </div>
            </div>
           <div class="form-group">
                <label class="col-md-2 control-label">
                    next
                    <span class="glyphicon glyphicon-question-sign"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="The 'next' value may be returned from an initial call to the Data API. Use it to retrieve the next pageset of results if there are any.">
                    </span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="api-next" data-type="string" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="ladda-button" data-style="expand-right"><span class="ladda-label">Submit</span></button>
                </div>
            </div>
            <input type="hidden" name="input-request" id="input-request" value="">
        </form>
    </div>
    <!-- Render the raw request json -->
    <div class="tab-pane" id="tab-request-json-<?php echo $resource; ?>">
        <div class="preview">
            <pre><code id="request-<?php echo $resource; ?>"></code></pre>
        </div>
    </div>
    <!-- Render the response packet -->
    <div class="tab-pane" id="tab-response-<?php echo $resource; ?>">
        <div class="preview">
            <pre><code id="response-<?php echo $resource; ?>"><em>Submit the request form to see a response</em></code></pre>
        </div>
    </div>
</div>
