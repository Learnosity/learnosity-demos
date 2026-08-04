<?php

$endpoint = "$URL/itembank/items";
$resource = 'items';

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
                <label class="col-md-2 col-form-label">reference(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-references" data-type="array" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">question types(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-questions:types" data-type="objectarray" value="mcq, association">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">question reference(s)</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-questions:references" data-type="objectarray" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">item pool id</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="api-item_pool_id" data-type="string" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">status(s)</label>
                <div class="col-md-10">
                    <div class="checkbox">
                        <label for="api-status~unpublished3">
                            <input type="checkbox" id="api-status~unpublished3" data-type="checkboxarray" value="unpublished">
                            Unpublished
                        </label>
                        <br>
                        <label for="api-status~published3">
                            <input type="checkbox" id="api-status~published3" data-type="checkboxarray" value="published">
                            Published
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">limit</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" id="api-limit" data-type="integer" min="1" max="1000" value="5">
                </div>
            </div>
           <div class="form-group row">
                <label class="col-md-2 col-form-label">
                    next
                    <span class="bi bi-question-circle-fill"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        title="The 'next' value may be returned from an initial call to the Data API. Use it to retrieve the next pageset of data if there are any." tabindex="0">
                    </span>
                </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="api-next" data-type="string" value="">
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
