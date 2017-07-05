<?php

$endpoint = "$URL/$version/scoring";
$resource = 'scoring';

?>

<ul class="nav nav-tabs" id="nav-dataapi-<?php echo $resource; ?>">
    <li class="active"><a href="#tab-request-form-<?php echo $resource; ?>" data-toggle="tab">Request Form</a></li>
    <li><a href="#tab-request-json-<?php echo $resource; ?>" data-toggle="tab">Request JSON</a></li>
    <li><a href="#tab-response-<?php echo $resource; ?>" data-toggle="tab">Response</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab-request-form-<?php echo $resource; ?>">
        <form class="form-horizontal" role="form" method="post" id="frm-data-api-<?php echo $resource; ?>" data-resource="<?php echo $resource; ?>">
            <div class="form-group">
                <label class="col-md-2 control-label">URL</label>
                <div class="col-md-10">
                <input type="text" class="form-control" id="endpoint" value="<?php echo $endpoint; ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">questions</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="api-questions" data-type="json">
[
  {
    "response_id": "10000",
    "options": [
      {
        "label": "A",
        "value": "0"
      },
      {
        "label": "B",
        "value": "1"
      },
      {
        "label": "C",
        "value": "2"
      },
      {
        "label": "D",
        "value": "3"
      }
    ],
    "stimulus": "<p>Choose the right response</p>",
    "type": "mcq",
    "ui_style": {},
    "validation": {
      "scoring_type": "exactMatch",
      "valid_response": {
        "score": 1,
        "value": [
          "0"
        ]
      }
    }
  },
  {
    "response_id": "10001",
    "options": [
      {
        "label": "A",
        "value": "0"
      },
      {
        "label": "B",
        "value": "1"
      },
      {
        "label": "C",
        "value": "2"
      },
      {
        "label": "D",
        "value": "3"
      }
    ],
    "stimulus": "<p>Choose the right response</p>",
    "type": "mcq",
    "ui_style": {},
    "validation": {
      "scoring_type": "exactMatch",
      "valid_response": {
        "score": 1,
        "value": [
          "3"
        ]
      }
    }
  }
]</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">responses</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="api-responses" data-type="json">
{
  "10000": {
    "value": [
      "0"
    ],
    "type": "array",
    "apiVersion": "v2.105.2"
  },
  "10001": {
    "value": [
      "3"
    ],
    "type": "array",
    "apiVersion": "v2.105.2"
  }
}</textarea>
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
