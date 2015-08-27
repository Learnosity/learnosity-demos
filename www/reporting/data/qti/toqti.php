<?php

$endpoint = "$URL/$version/itembank/conversion/toqti";
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
                <label class="col-md-2 control-label">QTI</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="api-items" data-type="json">
[
    {
        "type": "mcq",
        "widget_type": "response",
        "reference": "6b29c4b7-5352-444c-bca1-b328181ec2cc_3",
        "data": {
            "options": [
                {
                    "label": "[Choice A]",
                    "value": "0"
                },
                {
                    "label": "[Choice B]",
                    "value": "1"
                },
                {
                    "label": "[Choice C]",
                    "value": "2"
                },
                {
                    "label": "[Choice D]",
                    "value": "3"
                }
            ],
            "stimulus": "<p>[This is the stem.]</p>",
            "type": "mcq",
            "ui_style": {
                "choice_label": "upper-alpha",
                "type": "block"
            },
            "validation": {
                "scoring_type": "exactMatch",
                "valid_response": {
                    "score": 1,
                    "value": [
                        "2"
                    ]
                }
            }
        }
    }
]

                    </textarea>
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
