<?php

include_once "config.php";
include_once "util/signature.php";
include_once "util/uuid.php";

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <?php include "util/headerbottom.php" ?>

    <?php include "util/nav.php" ?>

    <?php

    $activityData = json_decode('{
        "rendering_type": "assess",
        "name": "Items API demo - Assess activity.",
        "state": "initial",
        "activity_id": "itemsassessdemo",
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
            "configuration": {
                "onsubmit_redirect_url": "'.$thispage.'"
            }
        }
    }', true);


    $signedActivity = SignatureUtils::signRequest($activityData, $consumer_secret, 'items');

?>


    <div class="jumbotron">
      <div class="container">
        <h1>Items API Assess</h1>
        <p>Or with the flick of a switch make the items into an assessment.  Truly write once - use anywhere.<p>
        <p class='text-right'><a class="btn btn-primary btn-lg" href="ssoapi.php">Continue</a></p>

      </div>
    </div>




    <!-- Container for the assess app to load into -->
    <div id="learnosity_assess"></div>

    <script src="http://items.learnosity.com/"></script>
    <script>
        var activity = <?php echo json_encode($signedActivity); ?>;
        LearnosityItems.init(activity);
    </script>

<?php include "util/footer.php" ?>
