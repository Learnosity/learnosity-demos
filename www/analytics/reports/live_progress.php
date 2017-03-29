<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Utils\Uuid;

$studentIds = array(Uuid::generate(), Uuid::generate(), Uuid::generate(), Uuid::generate());

?>

<!-- Basic styles to remove padding from the main layout -->
<link rel="stylesheet" href="<?php echo $env['www']; ?>static/css/quad.css">

<div class="container quad">
    <div class="row">
        <div class="col-md-6 quad-left">
            <iframe src="./liveprogress/report.php?user_ids=<?php echo implode(',', $studentIds); ?>"></iframe>
        </div>
        <div class="col-md-6 quad-right">
            <iframe src="./liveprogress/assessment_1.php?user_id=<?php echo $studentIds[0]; ?>"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 quad-left">
            <iframe src="./liveprogress/assessment_2.php?user_id=<?php echo $studentIds[1]; ?>"></iframe>
        </div>
        <div class="col-md-6 quad-right">
            <iframe src="./liveprogress/assessment_3.php?user_id=<?php echo $studentIds[2]; ?>"></iframe>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
