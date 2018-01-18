<?php

/**
 * This is an internal test page for testing grade passback.
 *
 * For grade passback, we need a public endpoint that backoffice can send the
 * result to. This simple endpoint serves nicely.
 */

// read the request body
$requestBody = file_get_contents('php://input');

// parse it as XML
libxml_use_internal_errors(true);
$parsed = simplexml_load_string($requestBody);
libxml_use_internal_errors(false);

// pull off the score and resultSourcedId
$score = (string) $parsed->imsx_POXBody->replaceResultRequest->resultRecord->result->resultScore->textString;
$resultSourcedId = (string) $parsed->imsx_POXBody->replaceResultRequest->resultRecord->sourcedGUID->sourcedId;

// generate a unique message ID for our response
$messageId = uniqid();

header('Content-Type: text/xml');

$replaceResult = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<imsx_POXEnvelopeResponse xmlns=\"http://www.imsglobal.org/services/ltiv1p1/xsd/imsoms_v1p0\">
  <imsx_POXHeader>
    <imsx_POXResponseHeaderInfo>
      <imsx_version>V1.0</imsx_version>
      <imsx_messageIdentifier>{$messageId}</imsx_messageIdentifier>
      <imsx_statusInfo>
        <imsx_codeMajor>success</imsx_codeMajor>
        <imsx_severity>status</imsx_severity>
        <imsx_description>Score for {$resultSourcedId} is now {$score}</imsx_description>
        <imsx_messageRefIdentifier>999999123</imsx_messageRefIdentifier>
        <imsx_operationRefIdentifier>replaceResult</imsx_operationRefIdentifier>
      </imsx_statusInfo>
    </imsx_POXResponseHeaderInfo>
  </imsx_POXHeader>
  <imsx_POXBody>
    <replaceResultResponse />
  </imsx_POXBody>
</imsx_POXEnvelopeResponse>
";

print_r($replaceResult);
