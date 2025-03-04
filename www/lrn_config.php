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

// Additional organisation IDs that the consumer has access to, RW and RO.
$rwAdditionalOrgId=6;
$roAdditionalOrgId=505;

/* Some products need the domain as part of the security signature.
** Learnosity whitelists "localhost" - any requests from other domains will be rejected.
 * Function below strips any port from the hostname - learnosity requires only the hostname for signature signing.
*/
$domain = explode(':', $_SERVER['HTTP_HOST'])[0];

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

$lts_version = 'v2025.1.LTS';

$url_assess                = 'https://assess.learnosity.com/?' . $lts_version;
$url_authorapi             = 'https://authorapi.learnosity.com/?' . $lts_version;
$url_data                  = 'https://data.learnosity.com/' . $lts_version;
$url_events                = 'https://events.learnosity.com/?' . $lts_version;
$url_items                 = 'https://items.learnosity.com/?' . $lts_version;
$url_questioneditor        = 'https://questioneditor.learnosity.com/?' . $lts_version;
$url_questions             = 'https://questions.learnosity.com/?' . $lts_version;
$url_reports               = 'https://reports.learnosity.com/?' . $lts_version;
$url_grading               = 'https://grading.learnosity.com/?' . $lts_version;

/**
 * Allow override file to replace config options
 **/

if (file_exists(dirname(__FILE__) . '/config_override.php')) {
    require dirname(__FILE__) . '/config_override.php';
}

include_once __DIR__ . '/../vendor/autoload.php';
