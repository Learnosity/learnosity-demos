<?php

$student = [
    'id'   => htmlspecialchars(filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES),
    'name' => 'Mike Ehrmantraut'
];

include_once 'assessment.inc.php';
