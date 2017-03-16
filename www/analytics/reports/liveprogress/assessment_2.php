<?php

$student = array(
    'id'   => htmlspecialchars($_GET['user_id'], ENT_QUOTES),
    'name' => 'Walter White'
);

include_once 'assessment.inc.php';
