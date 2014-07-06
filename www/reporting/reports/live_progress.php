<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>

<!-- Basic styles to remove padding from the main layout -->
<link rel="stylesheet" href="<?php echo $env['www']; ?>static/css/quad.css">

<div class="container quad">
    <div class="row">
        <div class="col-md-6 quad-left">
            <iframe src="./liveprogress/report.php"></iframe>
        </div>
        <div class="col-md-6 quad-right">
            <iframe src="./liveprogress/assessment_1.php"></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 quad-left">
            <iframe src="./liveprogress/assessment_2.php"></iframe>
        </div>
        <div class="col-md-6 quad-right">
            <iframe src="./liveprogress/assessment_3.php"></iframe>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
