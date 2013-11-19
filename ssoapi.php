<?php include "src/includes/headertop.php" ?>

<?php

include "config.php";
include "src/utils/signature.php";

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
                "firstname": "Demo",
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
                "firstname": "Demo",
                "lastname": "Teacher"
            },
            "school": {
                "id": "'.$schoolid.'",
                "name": "Demo School"
            },
            "classes" : [
                {"id":"1244","name":"Class 1","course_id":"'.$courseid.'"}
            ],
            "students" : [
                {"id":"'.$studentid.'","class_ids":["1244"],"firstname":"Demo","lastname":"Student"}
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

        <?php include "src/includes/headerbottom.php" ?>


    <div class="jumbotron">
      <div class="container">
        <h1>Single Sign On API</h1>
        <p>Get quick access to the data using the Learnosity Dashboards - or simply use the Learnosity API's to build your own solution.<p>

      </div>
    </div>


        <div class="row">
            <div class="col-md-4">Login as a Student  <button class="btn" onclick="LearnositySSO.signon(studentSignon)">Student Sign-on</button></div>
            <div class="col-md-4">Login as a Teacher  <button class="btn" onclick="LearnositySSO.signon(teacherSignon)">Teacher Sign-on</button></div>
        </div>

      </div>
    </div>

        <!-- Quick buttons to login as a teacher or a student using SSO interface -->




<?php include "src/includes/footer.php" ?>

