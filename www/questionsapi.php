<?php

include_once 'config.php';
include_once '../src/utils/uuid.php';
include_once '../src/utils/RequestHelper.php';
include_once '../src/includes/header.php';

$security = array(
    "consumer_key" => $consumer_key,
    "domain"       => $domain,
    "timestamp"    => $timestamp,
    "user_id"      => $studentid
);

$RequestHelper = new RequestHelper(
    'questions',
    $security,
    $consumer_secret
);

$activitySignature = $RequestHelper->getSignature();

$uniqueResponseIdSuffix = UUID::generateUuid();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$signedRequest = '{
    "consumer_key": "'.$consumer_key.'",
    "timestamp": "' . $timestamp . '",
    "signature": "'.$activitySignature.'",
    "user_id": "'.$studentid.'",
    "type": "submit_practice",
    "state": "initial",
    "id": "questionsapi-demo",
    "name": "Questions API Demo",
    "course_id": "'.$courseid.'",
    "renderSubmitButton" : "true",
    "questions": [
        {
            "type": "clozetext",
            "response_id": "demoscience1'.$uniqueResponseIdSuffix.'",
            "description": "The student needs to complete the conversion table.",
            "max_length": 6,
            "case_sensitive": false,
            "template": "<table><thead><tr><th><strong>cm</strong></th><th><strong>mm</strong></th><th><strong>&#181;m</strong></th></thead><tbody><tr><td>0.03</td><td>0.3</td><td>300</td></tr><tr><td>0.7</td><td>{{response}}</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>2</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>45</td></tr><tr><td>0.03</td><td>{{response}}</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>130</td></tr><tr><td>{{response}}</td><td>0.04</td><td>{{response}}</td></tr><tr><td>{{response}}</td><td>{{response}}</td><td>78</td></tr></tbody></table>",
            "instant_feedback" : true,
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
            "instant_feedback" : true,
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
        },
        {
            "response_id": "demoscience3'.$uniqueResponseIdSuffix.'",
            "type": "clozedropdown",
            "description": "The student needs to classify the situation as either physical or chemical",
            "template": "<ol><li>Cooking a pizza {{response}}</li><li>Ice melting {{response}}</li><li>Chopping wood {{response}}</li><li>Fireworks {{response}}</li><li>Burning breakfast {{response}}</li><li>Ice-cream hitting the ground {{response}}</li><li>Stirring a cake mixture {{response}}</li><li>Crashing a car {{response}}</li><li>Autumn leaves changing colour {{response}}</li><li>An explosion {{response}}</li><li>Synthesising a new chemical {{response}}</li><li>Baking bread {{response}}</li><li>Boiling water {{response}}</li><li>Breaking a plate {{response}}</li></ol>",
            "possible_responses": [["Physical", "Chemical"], ["Physical", "Chemical"], ["Physical", "Chemical"], ["Physical", "Chemical"], ["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"],["Physical", "Chemical"]],
            "instant_feedback": true,
            "valid_responses": [
                [
                    {"value": "Chemical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Chemical"}
                ], [
                    {"value": "Physical"}
                ], [
                    {"value": "Physical"}
                ]
            ]
        },
        {
            "response_id": "demoscience4'.$uniqueResponseIdSuffix.'",
            "type": "clozeassociation",
            "description" : "The student needs to choose the correct response for each blank ",
            "template": "<h3>Equation 1</h3><table><tbody><tr><td>carbon</td><td>+</td><td>{{response}}</td><td>&rarr;</td><td>carbon dioxide</td></tr><tr><td>C</td><td>+</td><td>0<sub>2</sub></td><td>&rarr;</td><td>{{response}}</td></tr></tbody></table><h4>Equation 2</h4><table><tbody><tr><td>sodium hydroxide</td><td>+</td><td>{{response}} acid</td><td>&rarr;</td><td>sodium chloride</td><td>+</td><td>{{response}}</td></tr><tr><td>NaOH</td><td>+</td><td>HCl</td><td>&rarr;</td><td>{{response}}</td><td>+</td><td>H<sub>2</sub>0</td></tr></tbody></table><h4>Equation 3</h4><table><tbody><tr><td>sulfuric acid</td><td>+</td><td>calcium carbonate</td><td>&rarr;</td><td>calcium sulfate</td><td>+</td><td>carbon dioxide</td><td>+</td><td>water</td></tr><tr><td>H<sub>2</sub>SO<sub>4</sub></td><td>+</td><td>CaCO<sub>3</sub></td><td>&rarr;</td><td>{{response}}</td><td>+</td><td>{{response}}</td><td>+</td><td>{{response}}</td></tr></tbody></table><h4>Equation 4</h4><table><tbody><tr><td>{{response}}</td><td>+</td><td>sulfur</td><td>&rarr;</td><td>hydrogen sulfide</td></tr><tr><td>H<sub>2</sub></td><td>+</td><td>S</td><td>&rarr;</td><td>{{response}}</td></tr></tbody></table><h4>Equation 5</h4><table><tbody><tr><td>{{response}} carbonate</td><td>&rarr;</td><td>calcium oxide</td><td>+</td><td>{{response}} dioxide</td></tr><tr><td>CaCO<sub>3</sub></td><td>&rarr;</td><td>CaO</td><td>+</td><td>CO<sub>2</sub></td></tr></tbody></table></tbody></table>",
            "possible_responses": ["oxygen","CO<sub>2</sub>","hydrochloric","water","NaCl","CaSO<sub>4</sub>","CO<sub>2</sub>","H<sub>2</sub>0","hydrogen","H<sub>2</sub>S","calcium","carbon"],
            "instant_feedback" : true,
            "valid_responses" : [
                [
                    {"value" : "oxygen"}
                ], [
                    {"value" : "CO<sub>2</sub>"}
                ], [
                    {"value" : "hydrochloric"}
                ], [
                    {"value" : "water"}
                ], [
                    {"value" : "NaCl"}
                ], [
                    {"value" : "CaSO<sub>4</sub>"}
                ], [
                    {"value" : "CO<sub>2</sub>"}
                ], [
                    {"value" : "H<sub>2</sub>0"}
                ], [
                    {"value" : "hydrogen"}
                ], [
                    {"value" : "H<sub>2</sub>S"}
                ], [
                    {"value" : "calcium"}
                ], [
                    {"value" : "carbon"}
                ]
            ]
        },
        {
            "response_id": "demoscience5'.$uniqueResponseIdSuffix.'",
            "type": "highlight",
            "description": "<p>The student needs to plot the ozone data from this table.<p><table><thead><tr><th>Year</th><th>1980</th><th>1982</th><th>1984</th><th>1986</th><th>1988</th><th>1990</th><th>1992</th><th>1994</th><th>1996</th><th>1998</th><th>2000</th><th>2002</th><th>2004</th><th>2006</th></tr></thead><tbody><tr><td>Ozone minimum (DU)</td><td>194</td><td>195</td><td>154</td><td>124</td><td>109</td><td>108</td><td>84</td><td>-</td><td>-</td><td>99</td><td>97</td><td>91</td><td>91</td><td>102</td></tr></tbody></table>",
            "img_src": "http://docs.learnosity.com/static/images/sciencegrid.jpg",
            "line_color": "rgb(255, 20, 0)",
            "line_width": "2"
        },
        {
            "type": "clozetext",
            "response_id": "demoscience6'.$uniqueResponseIdSuffix.'",
            "description": "The student needs to estimate the vales for the ozone level for years 1994 and 1996 using their graph from the previous question.",
            "max_length": 3,
            "case_sensitive": false,
            "template": "<p>1994 {{response}}</p><p>1996 {{response}}</p>"
        },
        {
            "response_id": "demoscience7'.$uniqueResponseIdSuffix.'",
            "type": "audio",
            "description": "The student needs to describe what happened to the ozone levels over the 26-year period.",
            "show_download_link": true
        },
        {
            "response_id": "demoscience8'.$uniqueResponseIdSuffix.'",
            "type": "longtext",
            "description": "The student needs to describe what has happened to the ozone levels in the 26-year period represented by the data from question 5",
            "max_length": 400
        }
    ]
}';

?>

<div class="jumbotron">
    <h1>Questions API</h1>
    <p>Rich Question types can be embedded on any page with the Learnosity Questions API.  Every question is highly configurable to suit the assessment purpose, be it formative or summative.<p>
    <p>Try a few questions and then submit at the bottom of the page</p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_assess.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the questions api to load into -->
<script src="http://api.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityApp.init(activity);
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Demo Science 8</h2>

<p>1. Use your knowledge of conversions to complete the table below. To convert from centimetres to millimetres,
    multiply by 10. To convert millimetres to micrometres, multiply by 1000. To reverse each of these, divide by
    these factors of 10 and 1000. The first one has been done for you.</p>
<span class="learnosity-response question-demoscience1<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr />
<p>2. Identify the different bones of the human skeleton.</p>
<span class="learnosity-response question-demoscience2<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr />
<p>3. The world around you is constantly changing. Some of these changes are known as physical changes, in which no new substances are produced.
    Other changes are known as chemical changes, in which new substances are produced. <strong>Classify</strong> each of the following situations as a physical or chemical change.</p>
<span class="learnosity-response question-demoscience3<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr />
<p>4. Complete the following equations.</p>
<span class="learnosity-response question-demoscience4<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr />
<p>5. Using the table <strong>construct</strong> a line graph using the graph provided to show how the level of ozone had varied from 1980 to 2006.</p>
<table>
    <thead>
        <tr>
            <th>Year</th>
            <th>1980</th>
            <th>1982</th>
            <th>1984</th>
            <th>1986</th>
            <th>1988</th>
            <th>1990</th>
            <th>1992</th>
            <th>1998</th>
            <th>2000</th>
            <th>2002</th>
            <th>2004</th>
            <th>2006</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>Ozone minimum (DU)</td>
        <td>194</td>
        <td>195</td>
        <td>154</td>
        <td>124</td>
        <td>109</td>
        <td>108</td>
        <td>84</td>
        <td>99</td>
        <td>97</td>
        <td>91</td>
        <td>91</td>
        <td>102</td>
    </tr>
    </tbody>
</table>

<!--[if IE 8]><div class="alert alert-error">Image Highlight Question Type is not currently supported by IE8, support will be released in the near future.<br>Sorry for any inconvenience.</div><![endif]-->
<span class="learnosity-response question-demoscience5<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr>
<p>6. <strong>Deduce</strong> from the graph what you might expect the minimum ozone level to be in 1994 and 1996.</p>
<span class="learnosity-response question-demoscience6<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr>
<p>7. <strong>Describe</strong> what happened to the ozone levels over this 26-year period.</p>
<span class="learnosity-response question-demoscience7<?php echo $uniqueResponseIdSuffix ?>"></span>
<hr>
<p>8. <strong>Propose</strong> what you think the minimum ozone level will do over the next 10 years based on the data in the graph. <strong>Justify</strong> your answer.</p>
<div style="height:80px;margin-bottom:100px;">
    <span class="learnosity-response question-demoscience8<?php echo $uniqueResponseIdSuffix ?>"></span>
</div>

<!-- Tell the API where to place the submit button if using "renderSubmitButton" attribute -->
<span class="learnosity-submit-button"></span>

<?php
    include_once '../src/views/modals/initialisation-preview.php';
    include_once '../src/includes/footer.php';
