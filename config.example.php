<?php

$consumer_key = '';
//Note - Consumer secret should never get displayed on the page - only used for creation of signature server side
$consumer_secret = '';

$name = "";


// Generate timestamp in format YYYYMMDD-HHMM for use in signature
$timestamp = gmdate('Ymd-Hi');
$domain = $_SERVER['HTTP_HOST']; // Tested on "localhost"
$thispage = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

