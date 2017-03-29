<?php

$student = array(
    'id'   => htmlspecialchars($_GET['user_id'], ENT_QUOTES),
    'name' => 'Jesse Pinkman'
);

include_once 'assessment.inc.php';
