<?php

include_once "config.php";
include_once "util/signature.php";

$courseid = $name."demo";
$studentid = $name."Student";
$teacherid = $name."Teacher";
$schoolid = $name;

//The assess app is loaded in a iframe via assess.learnosity.com so the signature needs
// to be generated with this domain.
$assessdomain = 'assess.learnosity.com';

//Activity JSON:  http://docs.learnosity.com/api/activity.php
$activitySignature = hash("sha256", $consumer_key . '_' . $assessdomain . '_' . $timestamp . '_' . $studentid . '_' . $consumer_secret);
$activity = '{
    "sheets": [
        {
            "content": "<p>1. Use your knowledge of conversions to complete the table below. To convert from centimetres to millimetres, multiply by 10. To convert millimetres to micrometres, multiply by 1000. To reverse each of these, divide by these factors of 10 and 1000. The first one has been done for you.</p><span class=\"learnosity-response question-demoscience1'.$uniqueResponseIdSuffix.'\"></span>",
            "response_ids": [
                "question-demoscience1'.$uniqueResponseIdSuffix.'"
            ],
            "workflow": "",
            "reference": "question-demoscience1"
        },
       {
            "content": "<p>2. Identify the different bones of the human skeleton.</p><span class=\"learnosity-response question-demoscience2'.$uniqueResponseIdSuffix.'\"></span>",
            "response_ids": [
                "question-demoscience2'.$uniqueResponseIdSuffix.'"
            ],
            "workflow": "",
            "reference": "question-demoscience2"
        }
    ],
    "time": {
        "max_time": 0,
        "limit_type": "soft",
        "show_pause": true,
        "warning_time": 60,
        "show_time": true
    },
    "ui_style":"horizontal",
    "labelBundle": {
        "appName": "Assess Demo",
        "sheet": "Question"
    },
    "navigation": {
        "show_next": true,
        "toc": {
            "show_sheetcount": true
        },
        "show_submit": true,
        "show_save": false,
        "show_fullscreencontrol": true,
        "show_prev": true,
        "show_title": true,
        "outro_sheet": "",
        "show_outro": true,
        "scroll_to_top": true,
        "scroll_to_test": false,
        "show_intro": true,
        "intro_sheet": ""
    },
    "name": "Demo (2 questions)",
    "state": "initial",
    "widgetAPIActivity": {
        "consumer_key": "'.$consumer_key.'",
        "timestamp": "' . $timestamp . '",
        "signature": "'.$activitySignature.'",
        "user_id": "'.$studentid.'",
        "type": "submit_practice",
        "state": "initial",
        "id": "assessdemo",
        "name": "Assess API - Demo",
        "course_id": "'.$courseid.'",
        "questions": [

            {
            "type": "clozetext",
                "response_id": "demoscience1'.$uniqueResponseIdSuffix.'",
                "description": "The student needs to complete the conversion table.",
                "max_length": 6,
                "case_sensitive": false,
                "template": "<table><thead><tr><th><strong>cm</strong></th><th><strong>mm</strong></th><th><strong>&#181;m</strong></th></thead><tbody><tr><td>0.03</td><td>0.3</td><td>300</td></tr><tr><td>0.7</td><td>{{response}}</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>2</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>45</td></tr><tr><td>0.03</td><td>{{response}}</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>130</td></tr><tr><td>{{response}}</td><td>0.04</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>78</td></tr></tbody></table>",
                "valid_responses" : [
                    [
                        {"value" : "7"}
                    ], [
                        {"value" : "7000"}
                    ], [
                        {"value" : "0.2"},{"value" : ".2"}
                    ], [
                        {"value" : "2000"}
                    ], [
                        {"value" : "0.0045"},{"value" : ".0045"}
                    ], [
                        {"value" : "0.045"},{"value" : ".045"}
                    ], [
                        {"value" : "0.3"},{"value" : ".3"}
                    ], [
                        {"value" : "300"}
                    ], [
                        {"value" : "0.013"},{"value" : ".013"}
                    ], [
                        {"value" : "0.13"},{"value" : ".13"}
                    ], [
                        {"value" : "0.004"},{"value" : ".004"}
                    ], [
                        {"value" : "40"}
                    ], [
                        {"value" : "0.0078"},{"value" : ".0078"}
                    ], [
                        {"value" : "0.078"},{"value" : ".078"}
                    ]
                ]
            },
            {
            "response_id": "demoscience2'.$uniqueResponseIdSuffix.'",
            "type": "imageclozedropdown",
            "description" : "The student needs to choose the correct response for each blank ",
            "img_src" : "http://docs.learnosity.com/static/images/clozeskeleton.jpg",
            "response_positions" : [ {"x":"5","y":"5.5"}, {"x":"0","y":"24.5"}, {"x":"75","y":"27.5"}, {"x":"78","y":"39"}, {"x":"78","y":"43"}, {"x":"0","y":"36"}, {"x":"0","y":"41.5"}, {"x":"0","y":"56"}, {"x":"0","y":"65.5"}, {"x":"74","y":"73.2"}, {"x":"74","y":"78"} ],
            "possible_responses" : [[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"],[ "femur", "fibula", "humerus", "patella", "pelvis", "radius", "ribs", "skull", "tibia", "ulna", "vertebrae"]],
            "valid_responses" : [
                [
                    {"value" : "skull"}
                ], [
                    {"value" : "humerus"}
                ], [
                    {"value" : "ribs"}
                ], [
                    {"value" : "radius"}
                ], [
                    {"value" : "ulna"}
                ], [
                    {"value" : "vertebrae"}
                ], [
                    {"value" : "pelvis"}
                ], [
                    {"value" : "femur"}
                ], [
                    {"value" : "patella"}
                ], [
                    {"value" : "fibula"}
                ], [
                    {"value" : "tibia"}
                ]
            ]
            }
        ]
    },
    "configuration": {
        "onsubmit_redirect_url": "'.$thispage.'",
    },
    "type": "activity"
}';


?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">


        <script src="http://assess.learnosity.com"></script>
        <script type="text/javascript">
            var activity = <?php echo $activity; ?>;
        </script>

<?php include "util/headerbottom.php" ?>


<?php include "util/nav.php" ?>

    <!-- Main question content below here: -->
    <h2 class="page-heading">Assess API Demo</h2>

    <p>This page shows the Assess API and how it can leverage the Questions API to create a rich assessment experience</p>

    <div id="learnosity_assess"></div>

    <script>LearnosityAssess.init(activity, "learnosity_assess");</script>

<?php include "util/footer.php" ?>



