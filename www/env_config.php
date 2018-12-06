<?php

/*
|--------------------------------------------------------------------------
| Environment Details
|--------------------------------------------------------------------------
|
| Setup any path/environment variables required. Handles site loading
| from the root or a subdirectory
|
*/

// Asset version - for cachebusting JS & CSS
$assetVersion = '20181206';


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

$env = array(
    'www'      => $UrlGenerator->getRelativePath($_SERVER['REQUEST_URI'], $baseWebPath)
);

// Make sure we have a trailing slash for the www path
if (substr($env['www'], -1) !== '/') {
    $env['www'] = '/';
}
// Turn on remote SSL certificate verification in curl
$curl_ssl_verify = true;
