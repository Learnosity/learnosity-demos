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
$assetVersion = '20260804';

// Front-end bundle basename in www/static/dist/. 'all.min' is the Bootstrap 3
// build (gulpfile.js); 'all.bs5.min' is the Bootstrap 5 build (build.mjs).
// Flipping this one value switches the whole site between the two stacks.
// See docs/bootstrap-5-upgrade.md
$assetBundle = 'all.bs5.min';

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
