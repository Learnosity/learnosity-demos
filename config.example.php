<?php

$consumer_key = '';
//Note - Consumer secret should never get displayed on the page - only used for creation of signature server side
$consumer_secret = '';

//Setup some basic variables
$courseid = "demo_".$consumer_key;
$studentid = "demo_student";
$teacherid = "demo_teacher";
$schoolid = "demo_school";


// Generate timestamp in format YYYYMMDD-HHMM for use in signature
$timestamp = gmdate('Ymd-Hi');
$domain = $_SERVER['HTTP_HOST']; // Tested on "localhost"
$thispage = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

