<?php

$student = [
    'id'   => htmlspecialchars(filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES),
    'name' => 'Walter White'
];

include_once 'assessment.inc.php';
