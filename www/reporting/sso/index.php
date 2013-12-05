<?php

include_once '../../config.php';
include_once '../../../src/utils/signature.php';
include_once '../../../src/includes/header.php';

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
$studentSSO = SignatureUtils::signRequest(json_decode($student_json, true), $consumer_secret, 'sso');

// Generate teacher signature
$teacherSSO = SignatureUtils::signRequest(json_decode($teacher_json, true), $consumer_secret, 'sso');

?>

<div class="jumbotron">
    <h1>Single Sign On API</h1>
    <p>Get quick access to the data using the Learnosity Dashboards – or simply use the Learnosity API's to build your own solution.<p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/ssoapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="/">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<script src="http://sso.learnosity.com"></script>
<script>
// Create json objects from $student_json and $teacher_json
var studentSignon = <?php echo json_encode($studentSSO); ?>;
var teacherSignon = <?php echo json_encode($teacherSSO); ?>;
</script>

<!-- Quick buttons to login as a teacher or a student using SSO interface -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h2>Login as a Student</h2>
            <button class="btn btn-primary btn-lg" onclick="LearnositySSO.signon(studentSignon)">Student Sign-on</button>
        </div>
        <div class="col-md-4">
            <h2>Login as a Teacher</h2>
            <button class="btn btn-primary btn-lg" onclick="LearnositySSO.signon(teacherSignon)">Teacher Sign-on</button>
        </div>
    </div>
</div>

<?php include_once '../../../src/includes/footer.php';
