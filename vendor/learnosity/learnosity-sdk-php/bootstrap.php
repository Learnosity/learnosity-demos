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
 */

$autoloadFile = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoloadFile)) {
    require_once($autoloadFile);
} else {
    $autoloadFile = __DIR__ . '/../../../vendor/autoload.php';

    require_once($autoloadFile);
}
