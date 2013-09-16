<?php include "util/headertop.php" ?>

<?php

    include_once "config.php";
    include_once "util/signature.php";
    include_once "util/uuid.php";


    //Define an activity - we use json and the convert it to PHP native for convenience
    $activityData = json_decode('{
        "rendering_type": "inline",
        "name": "Items API demo - Inline Activity.",
        "state": "initial",
        "activity_id": "itemsinlinedemo",
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
            "renderSubmitButton": true
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

    <div class="jumbotron">
      <div class="container">
        <h1>Items API</h1>
        <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
        <div class="row">
            <div class="col-md-8"> <p>See it below.</p></div>
            <div class="col-md-4"> <p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_assess.php">Continue</a></p></div>
        </div>
      </div>
    </div>


    <p>
    <span class="learnosity-item" data-reference="ccore_video_260_classification"></span>
    <span class="learnosity-item" data-reference="ccore_parcc_tecr_grade3"></span></p>

    <span class="learnosity-submit-button"></span>
    </p>


<?php include "util/footer.php" ?>

