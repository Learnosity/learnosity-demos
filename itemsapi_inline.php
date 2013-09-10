<?php include "util/headertop.php" ?>

<?php

    include_once "config.php";
    include_once "util/signature.php";
    include_once "util/uuid.php";

    $courseid = $name."demo";
    $studentid = $name."Student";
    $teacherid = $name."Teacher";
    $schoolid = $name;

    //Define an activity - we use json and the convert it to PHP native for convenience
    $activityData = json_decode('{
        "rendering_type": "inline",
        "name": "Items API demo - Inline Activity.",
        "state": "initial",
        "activity_id": "emberDemo2013",
        "session_id": "'.UUID::generateUuid().'",
        "course_id": "'.$courseid.'",
        "items": ["ccore_video_260_classification", "ccore_parcc_tecr_grade3"],
        "type": "submit_practice",
        "security": {
            "consumer_key": "'.$consumer_key.'",
            "domain": "'.$domain.'",
            "user_id": "'.$studentid.'",
            "timestamp": "'.$timestamp.'"
        },
        "config": {
            "renderSaveButton": true
        }
    }', true);

    //Sign the activity using the signature utils
    $signedActivity = SignatureUtils::signRequest($activityData, $consumer_secret, 'items');
?>

    <script src="http://items.learnosity.com/"></script>
    <script>
        var activity = <?php echo json_encode($signedActivity); ?>;
        LearnosityItems.init(activity);
    </script>

<?php include "util/headerbottom.php" ?>

<?php include "util/nav.php" ?>


    <p>
    <span class="learnosity-item" data-reference="ccore_video_260_classification"></span>
    <span class="learnosity-item" data-reference="ccore_parcc_tecr_grade3"></span></p>

    <span class="learnosity-save-button"></span>
    </p>


<?php include "util/footer.php" ?>

