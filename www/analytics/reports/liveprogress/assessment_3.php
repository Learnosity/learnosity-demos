<?php

$student = array(
    'id'   => htmlspecialchars($_GET['user_id'], ENT_QUOTES),
    'name' => 'Hank Schrader'
);

include_once 'assessment.inc.php';
