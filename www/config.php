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

// Basic variables simulating any user details needed
$courseid   = 'demo_' . $consumer_key;
$studentid  = 'demo_student';
$teacherid  = 'demo_teacher';
$schoolid   = 'demo_school';
$customMode = $_GET['mode'];

/*
|--------------------------------------------------------------------------
| Environment Details
|--------------------------------------------------------------------------
|
| Setup any path/environment variables required. Handles site loading
| from the root or a subdirectory
|
*/
$rootPath    = $_SERVER['DOCUMENT_ROOT'];
$subDir      = strpos($_SERVER['REQUEST_URI'], '/www');
$baseWebPath = ($subDir !== false) ? substr($_SERVER['REQUEST_URI'], 0, $subDir + 4) : '/';

$includePaths = array(
    $rootPath,
    $rootPath . $baseWebPath,
    $rootPath . $baseWebPath . '/../src',
    $rootPath . '/src',
    get_include_path()
);
set_include_path(join(PATH_SEPARATOR, $includePaths));

include_once 'utils/UrlGenerator.php';
$UrlGenerator = new UrlGenerator();

// 2 separate statements needed for 5.3 support
$pathArr = explode('/', $_SERVER['REQUEST_URI']);
$section = $pathArr[1];

$env = array(
    'page'     => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
    'path'     => $_SERVER['REQUEST_URI'],
    'protocol' => (($_SERVER['SERVER_PORT'] === '443') ? 'https://' : 'http://'),
    'section'  => $section,
    'www'      => $UrlGenerator->getRelativePath($_SERVER['REQUEST_URI'], $baseWebPath),
    'mode'     => getEnvironmentMode($customMode)
);

// Make sure we have a trailing slash for the www path
if (substr($env['www'], -1) !== '/') {
    $env['www'] .= '/';
}

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
switch ($env['mode']) {
    case 'development':
        $url_assess           = '//assess.vg.learnosity.com?latest';
        $url_authorapi        = '//authorapi.vg.learnosity.com?latest';
        $url_authorapi_legacy = '//authorapi.vg.learnosity.com?latest';
        $url_data             = '//data.vg.learnosity.com?latest';
        $url_events           = '//events.vg.learnosity.com?latest';
        $url_items            = '//items.vg.learnosity.com?latest';
        $url_questioneditor   = '//questioneditor.vg.learnosity.com?latest';
        $url_questions        = '//questions.vg.learnosity.com?latest';
        $url_reports          = '//reports.vg.learnosity.com?latest';
        $version_questionsapi = 'v2';
        $version_assesssapi   = 'latest';
        break;
    case 'staging':
        $url_assess           = '//assess.staging.learnosity.com';
        $url_authorapi        = '//authorapi.staging.learnosity.com?v0.10';
        $url_authorapi_legacy = '//authorapi.staging.learnosity.com?v0.5';
        $url_data             = 'https://data.staging.learnosity.com';
        $url_events           = '//events.staging.learnosity.com';
        $url_items            = '//items.staging.learnosity.com';
        $url_questioneditor   = '//questioneditor.staging.learnosity.com?v2';
        $url_questions        = '//questions.staging.learnosity.com';
        $url_reports          = '//reports.staging.learnosity.com';
        $version_questionsapi = 'v2';
        $version_assesssapi   = 'v2';
        break;
    default:
        $url_assess           = '//assess.learnosity.com';
        $url_authorapi        = '//authorapi.learnosity.com?v0.10';
        $url_authorapi_legacy = '//authorapi.learnosity.com?v0.5';
        $url_data             = 'https://data.learnosity.com';
        $url_events           = '//events.learnosity.com';
        $url_items            = '//items.learnosity.com';
        $url_questioneditor   = '//questioneditor.learnosity.com?v2';
        $url_questions        = '//questions.learnosity.com';
        $url_reports          = '//reports.learnosity.com';
        $version_questionsapi = 'v2';
        $version_assesssapi   = 'v2';
        break;
}

function getEnvironmentMode($mode = null)
{
    // Allow an override via URL
    if (!empty($mode) && in_array(trim($mode), ['development', 'staging', 'production'])) {
        return trim($mode);
    }

    if (strpos($_SERVER['HTTP_HOST'], 'vg') > 0) {
        return 'development';
    } elseif (strpos($_SERVER['HTTP_HOST'], 'staging') > 0) {
        return 'staging';
    } else {
        return 'production';
    }
}

include_once 'sdk/src/LearnositySdk/autoload.php';
