<?php

/*
|--------------------------------------------------------------------------
| Setup Security/User Details
|--------------------------------------------------------------------------
|
| Setup the necessary security and user details to be used
| by default when communicating with any Learnosity products.
|
*/
$consumer_key = 'yis0TYCu7U9V4o7M';

// Note - Consumer secret should never get displayed on the page - only used for creation of signature server side
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

// Some products need the domain as part of the security signature. Demos has been tested on "localhost"
$domain = $_SERVER['SERVER_NAME'];

// Generate timestamp in format YYYYMMDD-HHMM for use in signature
$timestamp = gmdate('Ymd-Hi');

// Asset version
$assetVersion = '20160426';

/*
|--------------------------------------------------------------------------
| Learnosity URLs
|--------------------------------------------------------------------------
|
| Setup any URLs for external API's to allow them to be conveniently
| changed depending on the regions.   Use protocol relative urls to ensure
| it works from http and https sites.
|
*/

$url_assess                = 'https://assess-va.learnosity.com';
$url_authorapi             = 'https://authorapi.learnosity.com?v1';
$url_data                  = 'https://data-va.learnosity.com';
$url_events                = 'https://events-va.learnosity.com';
$url_items                 = 'https://items-va.learnosity.com';
$url_questioneditor        = 'https://questioneditor.learnosity.com?v2';
$url_questioneditor_v3     = 'https://questioneditor.learnosity.com?v3';
$url_questions             = 'https://questions-va.learnosity.com';
$url_reports               = 'https://reports-va.learnosity.com';
$version_assessapi         = 'v2';
$version_dataapi           = 'v1';
$version_questionsapi      = 'v2';
$version_questioneditorapi = 'v3';

include_once 'sdk/src/LearnositySdk/autoload.php';
