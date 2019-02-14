<?php

/**
 * This autoloader is deprecated; please use the bootstrap.php file directly.
 *
 * Usage - see the following example.
 *
 *   https://github.com/Learnosity/learnosity-sdk-php/examples/index.php
 *
 */

$bootstrap = __DIR__ . '/../../bootstrap.php';
error_log('Warning: using ' . __DIR__ . '/autoload.php is deprecated. ' .
          "Please use `require_once '" . realpath($bootstrap) . "';` instead.");
require_once $bootstrap;
