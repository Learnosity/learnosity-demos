<?php

$endpoint = "$URL/$version/itembank/conversion";
$resource = 'qti';

?>

<ul class="nav nav-tabs" id="nav-dataapi-<?php echo $resource; ?>">
    <li class="active"><a href="#tab-request-form-<?php echo $resource; ?>" data-toggle="tab">Request Form</a></li>
    <li><a href="#tab-request-json-<?php echo $resource; ?>" data-toggle="tab">Request JSON</a></li>
    <li><a href="#tab-response-<?php echo $resource; ?>" data-toggle="tab">Response</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab-request-form-<?php echo $resource; ?>">
        <form class="form-horizontal" role="form" method="post" id="frm-data-api-<?php echo $resource; ?>" data-resource="<?php echo $resource; ?>">
            <input type="hidden" id="api-mode" data-type="string" value="from_qti">
            <div class="form-group">
                <label class="col-md-2 control-label">URL</label>
                <div class="col-md-10">
                <input type="text" class="form-control" id="endpoint" value="<?php echo $endpoint; ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">QTI</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="api-items" data-type="array">
<?xml version="1.0" encoding="UTF-8"?>
<assessmentItem xmlns="http://www.imsglobal.org/xsd/imsqti_v2p1"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/qti/qtiv2p1/imsqti_v2p1.xsd"
    identifier="choice2" title="Saturday's Disco" adaptive="false" timeDependent="false">
    <responseDeclaration identifier="RESPONSE" cardinality="single" baseType="identifier">
        <correctResponse>
            <value>A</value>
        </correctResponse>
    </responseDeclaration>
    <outcomeDeclaration identifier="SIGNSCORE" cardinality="single" baseType="integer">
        <defaultValue>
            <value>0</value>
        </defaultValue>
    </outcomeDeclaration>
    <itemBody>
        <p>Look at the text in the notice.</p>
        <p>
            <img src="sign3.png" alt="WAIT FOR LIFT DOORS TO CLOSE BEFORE PRESSING BUTTON"/>
        </p>
        <choiceInteraction responseIdentifier="RESPONSE" shuffle="false" maxChoices="1">
            <prompt>What does it say?</prompt>
            <simpleChoice identifier="A">Press the button after the doors close.</simpleChoice>
            <simpleChoice identifier="B">Press the button while the doors are closing.</simpleChoice>
            <simpleChoice identifier="C">Press the button to close the lift doors.</simpleChoice>
        </choiceInteraction>
    </itemBody>
    <responseProcessing>
        <responseCondition>
            <responseIf>
                <match>
                    <variable identifier="RESPONSE"/>
                    <correct identifier="RESPONSE"/>
                </match>
                <setOutcomeValue identifier="SIGNSCORE">
                    <baseValue baseType="integer">1</baseValue>
                </setOutcomeValue>
            </responseIf>
        </responseCondition>
    </responseProcessing>
</assessmentItem></textarea>
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
