<?php

$student = array(
    'id'   => htmlspecialchars($_GET['user_id'], ENT_QUOTES),
    'name' => 'Mike Ehrmantraut'
);

include_once 'assessment.inc.php';
