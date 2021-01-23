<?php

/*
|--------------------------------------------------------------------------
| Environment Details
|--------------------------------------------------------------------------
|
| Setup any path/environment variables required.
|
*/

// Asset version - for cachebusting JS & CSS
$assetVersion = '20201015';

// Add 'www' and 'src' to the include path
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$srcPath = $rootPath . '/../src';
$includePath = implode(
    PATH_SEPARATOR,
    [ $rootPath, $srcPath, get_include_path() ]
);
set_include_path($includePath);

// Turn on remote SSL certificate verification in curl
$curl_ssl_verify = true;
