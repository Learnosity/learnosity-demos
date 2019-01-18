<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

/*
 * Hey there, demos visitor!
 *
 * You might have reached this page via the View source link on the demos site, an are know a bit bemused as this was
 * not the code you were looking for.
 *
 * For ease of demonstration, the root of the live progress demos (this file) only shows 4 iframes containing the
 * report, and 3 assessements. The source for the iframes is whas you are looking for.
 *
 * Fear not, you can easily reach them. As you can see below, they are in the `liveprogress` subdirectory, and are named
 * `report.php`, and `assessment_n.php`, respectively. All assessments pages look the same, and actually include a
 * common file, `assessment.inc.php`, which is probably what you'd be most inretested in.
 *
 * Assuming you are viewing this file in Github, you can easily access those files by hitting the `t` key now, which
 * will bring up a file-search form. You can then just start typing the name of the file you're after, and hit `Enter`
 * when it is shown. As mentioned before, the most interesting files are
 * - www/analytics/liveprogress/report.php (e.g., type `livproreport` in the search form),
 * - www/analytics/liveprogress/assessment.inc.php (e.g., type `liveproassessinc` in the search form).
 */

 $studentIds = [
     Uuid::generate(),
     Uuid::generate(),
     Uuid::generate(),
     Uuid::generate()
 ];

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
