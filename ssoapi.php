<?php include "util/headertop.php" ?>

<?php

include "config.php";
include "util/signature.php";

$courseid = $name."demo";
$studentid = $name."Student";
$teacherid = $name."Teacher";
$schoolid = $name;


//Student SSO JSON Object: http://docs.learnosity.com/dashboards/sso/userjson.php
$student_json = '{
            "consumer_key":"'.$consumer_key.'",
            "timestamp":"' . $timestamp . '",
            "user_id":"'.$studentid.'",
            "domain":"'.$domain.'",
            "module":"student",
            "courses": [{
                "id": "'.$courseid.'"
            }],
            "user": {
                "firstname": "'.$name.'",
                "lastname": "Student"
            },
            "return_link" : {
                "url": "'.$thispage.'",
                "label": "Back to Demos"
            }
        }';
//Teacher SSO JSON Object: http://docs.learnosity.com/dashboards/sso/userjson.php
$teacher_json = '{
            "consumer_key":"'.$consumer_key.'",
            "timestamp":"' . $timestamp . '",
            "user_id":"'.$teacherid.'",
            "domain":"'.$domain.'",
            "module": "teacher",
            "user": {
                "firstname": "Susan",
                "lastname": "Sanders"
            },
            "school": {
                "id": "'.$schoolid.'",
                "name": "'.$name.' Demo School"
            },
            "classes" : [
                {"id":"1244","name":"Class 1","course_id":"'.$courseid.'"}
            ],
            "students" : [
                {"id":"'.$studentid.'","class_ids":["1244"],"firstname":"'.$name.'","lastname":"Student"}
            ],
            "return_link" : {
                "url": "'.$thispage.'",
                "label": "Back to Demos"
            }
        }';

// Generate student signature
$studentSSO = SignatureUtils::signRequest(json_decode($student_json,TRUE), $consumer_secret, 'sso');

// Generate teacher signature
$teacherSSO = SignatureUtils::signRequest(json_decode($teacher_json, TRUE), $consumer_secret, 'sso');


?>


        <script src="http://sso.learnosity.com"></script>

        <script type="text/javascript">
        // Create json objects from $student_array and $teacher_array.
        var studentSignon = <?php echo json_encode($studentSSO); ?>;
        var teacherSignon = <?php echo json_encode($teacherSSO); ?>;
        </script>

        <?php include "util/headerbottom.php" ?>

        <?php include "util/nav.php" ?>

        <!-- Quick buttons to login as a teacher or a student using SSO interface -->
        <button class="btn" onclick="LearnositySSO.signon(studentSignon)">Student Sign-on</button>
        <button class="btn" onclick="LearnositySSO.signon(teacherSignon)">Teacher Sign-on</button>


<?php include "util/footer.php" ?>

