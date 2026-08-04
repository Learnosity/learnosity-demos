<?php

$endpoint = "$URL/sessions/responses/feedback";
$resource = 'responses-feedback';

?>

<ul class="nav nav-tabs" role="tablist" id="nav-dataapi-<?php echo $resource; ?>">
    <li class="nav-item" role="presentation"><a class="nav-link active" id="tab-request-form-<?php echo $resource; ?>-tab" href="#tab-request-form-<?php echo $resource; ?>" data-bs-toggle="tab" role="tab" aria-controls="tab-request-form-<?php echo $resource; ?>" aria-selected="true">Request Form</a></li>
    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-request-json-<?php echo $resource; ?>-tab" href="#tab-request-json-<?php echo $resource; ?>" data-bs-toggle="tab" role="tab" aria-controls="tab-request-json-<?php echo $resource; ?>" aria-selected="false">Request JSON</a></li>
    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-response-<?php echo $resource; ?>-tab" href="#tab-response-<?php echo $resource; ?>" data-bs-toggle="tab" role="tab" aria-controls="tab-response-<?php echo $resource; ?>" aria-selected="false">Response</a></li>
</ul>
<div class="tab-content">
    <!-- Render the interactive request form -->
    <div class="tab-pane active" id="tab-request-form-<?php echo $resource; ?>" role="tabpanel" aria-labelledby="tab-request-form-<?php echo $resource; ?>-tab" tabindex="0">
        <form method="post" id="frm-data-api-<?php echo $resource; ?>" data-resource="<?php echo $resource; ?>">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">URL</label>
                <div class="col-md-10">
                <input type="text" class="form-control" id="endpoint" value="<?php echo $endpoint; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">session_id</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-session_id" data-type="string" value="">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-md-2 col-md-10">
                    <button type="submit" class="ladda-button btn btn-primary btn-md" data-style="expand-right"><span class="ladda-label">Submit</span></button>
                </div>
            </div>
            <input type="hidden" name="input-request" id="input-request" value="">
        </form>
    </div>
    <!-- Render the raw request json -->
    <div class="tab-pane" id="tab-request-json-<?php echo $resource; ?>" role="tabpanel" aria-labelledby="tab-request-json-<?php echo $resource; ?>-tab" tabindex="0">
        <div class="preview">
            <pre><code id="request-<?php echo $resource; ?>"></code></pre>
        </div>
    </div>
    <!-- Render the response packet -->
    <div class="tab-pane" id="tab-response-<?php echo $resource; ?>" role="tabpanel" aria-labelledby="tab-response-<?php echo $resource; ?>-tab" tabindex="0">
        <div class="preview">
            <pre><code id="response-<?php echo $resource; ?>"><em>Submit the request form to see a response</em></code></pre>
        </div>
    </div>
</div>
