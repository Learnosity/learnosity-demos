<?php

/**
 *--------------------------------------------------------------------------
 * Learnosity SDK - Bootstrap
 *--------------------------------------------------------------------------
 *
 * Uses the built-in Composer autoloader to autoload dependencies.
 *
 * Usage - include this file in any location that you want to use the
 * Learnosity SDK.
 *
 *   https://github.com/Learnosity/learnosity-sdk-php/examples/index.php
 *
 */

/**
 * NOTE: Composer imports required libraries to
 * vendor/<organization_namespace>/<project_namespace>
 */
$autoloadVendorDirs = [
    __DIR__ . '/vendor', // standalone package
    __DIR__ . '/../../../vendor', // composer vendored package
];

foreach ($autoloadVendorDirs as $vendorDir) {
    $autoloadFile = "{$vendorDir}/autoload.php";

    if (file_exists($autoloadFile)) {
        require_once($autoloadFile);
        break;
    }
}
