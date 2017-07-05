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
$customMode = (isset($_GET['mode'])) ? $_GET['mode'] : 'production';

// Asset version
$assetVersion = '20160426';

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
    'www'      => $UrlGenerator->getRelativePath($_SERVER['REQUEST_URI'], $baseWebPath)
);

// Make sure we have a trailing slash for the www path
if (substr($env['www'], -1) !== '/') {
    $env['www'] .= '/';
}

// Turn on remote SSL certificate verification in curl
$curl_ssl_verify = true;

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

/**
 * Allow override file to replace config options
 **/
if (file_exists(dirname(__FILE__) . '/config_override.php')) {
    require dirname(__FILE__) . '/config_override.php';
}

include_once 'sdk/src/LearnositySdk/autoload.php';
