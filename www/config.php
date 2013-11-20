<?php

$consumer_key = 'yis0TYCu7U9V4o7M';
// Note - Consumer secret should never get displayed on the page - only used for creation of signature server side
$consumer_secret = '74c5fd430cf1242a527f6223aebd42d30464be22';

// Setup some basic variables
$courseid  = 'demo_' . $consumer_key;
$studentid = 'demo_student';
$teacherid = 'demo_teacher';
$schoolid  = 'demo_school';

// Generate timestamp in format YYYYMMDD-HHMM for use in signature
$timestamp = gmdate('Ymd-Hi');
$domain    = $_SERVER['SERVER_NAME']; // Tested on "localhost"
$thispage  = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
