<?php

$endpoint = "$URL/$version/sessions/responses";
$resource = 'responses';

?>

<div class="container">
    <div class="row">
        <div class="col-md-11">

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
                            <label class="col-md-2 control-label">school(s)</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="api-school_id" data-type="array" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">limit</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="api-limit" data-type="integer" min="1" max="1000" value="10">
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

        </div>
    </div>
</div>
