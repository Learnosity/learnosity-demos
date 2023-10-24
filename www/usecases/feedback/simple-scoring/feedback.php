<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$activity_id = filter_input(INPUT_GET, 'activity_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'user_id'      => 'demo_student',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = [
    'reports' => [
        [
            'id'         => 'report-1',
            'type'       => 'session-detail-by-item',
            'user_id'    => 'demo_student',
            'session_id' => $session_id
        ]
    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105378-Learnosity-Analytics" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Teacher Scoring – Step 2</h1>
        <p>This template renders a student assessment in review, and loads interactive
        widgets for the teacher to save scoring against the student responses.</p>
        <p>This way, scores can be access via the Reports or Data APIs.</p>
    </div>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div class="row">
        <div noclass="col-md-6">
            <h1>Teacher Scoring</h1>
        </div>
    </div>
    <span class="learnosity-report" id="report-1"></span>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <div class="lrn pull-right">
                <button type="button" class="ladda-button btn_save_simple_scores" onclick="saveScores()" data-style="expand-right"><span class="ladda-label">Save Scores</span></button>
            </div>
        </div>
    </div>
</div>

<script src="<?=$url_reports?>"></script>
<script>

init = () => {

    const report1 = reportsApp.getReport('report-1');
    report1.on('ready:itemsApi', function(itemsApp) {

        window.itemsApp = itemsApp;

        itemsApp.getQuestions(function(questions) {

            Object.keys(questions).forEach( (response_id) =>{

                question = itemsApp.question(response_id)
                if(!question.automarkable){
                    const scoringContainer = document.createElement('div')
                    scoringContainer.style = 'padding-top:1em;'
                    scoringContainer.appendChild(document.createTextNode('Score: '))

                    scores = question.getScore()

                    const scoringInput = document.createElement('input')
                    scoringInput.type = "number"
                    scoringInput.name = response_id
                    scoringInput.classList.add("scoring-input")
                    scoringInput.setAttribute('min', 0);
                    if(scores.max_score !== null){
                        scoringInput.setAttribute('max', scores.max_score);
                    }

                    scoringContainer.appendChild(scoringInput)
                    scoringContainer.appendChild(document.createTextNode(` /${scores.max_score}`))

                    questionEl = document.getElementById(response_id)
                    questionEl.appendChild(scoringContainer)
                }
            });
        });

        // Prevent the input of letters
        // or values above the question's max_score
        restrictValuesInInputs()
    });
};

const eventOptions = {
    readyListener : init
}

const reportsApp = LearnosityReports.init(<?=$signedRequest?>, eventOptions)
window.reportsApp = reportsApp

restrictValuesInInputs = ()=>{
    const inputs = document.querySelectorAll("[type='number']")
    inputs.forEach((input) => {
        input.addEventListener("keypress", (event)=>{
            if(event.charCode < 48 || event.charCode > 57){
                event.preventDefault()
            }
        })
        input.addEventListener("change", ()=>{
            if(input.max != undefined && Number(input.value) > input.max){
                input.value = input.max
            }
        })
    })
}

saveScores = () => {
    // Spinning button
    const ladda = Ladda.create($('.ladda-button')[0]);
    ladda.start();

    //Build responses array for the request object
    const responses = [];
    const inputs = Object.values(document.getElementsByClassName("scoring-input"))
    inputs.forEach((input) => {
        if(input.value !== ""){
            responses.push({
                'response_id': input.name,
                'score': Number(input.value),
                'max_score': Number(input.max) ?? Number(input.value)
            });
        }
    })

    //Build the request object
    request = {
        'sessions': [
            {
                'session_id': '<?=$session_id?>',
                'user_id': 'demo_student',
                'responses': responses
            }
        ]
    };

    const endpoint = '<?=$url_data?>/sessions/responses/scores'
    const postObject = {
        request: JSON.stringify(request), 
        endpoint: endpoint, 
        action: 'update'
    }

    //Make call to the Data API scoring endpoint
    $.ajax({
        url: '/analytics/data/xhr.php',
        data: {'request': JSON.stringify(request), 'endpoint': endpoint, 'action': 'update'},
        dataType: 'json',
        type: 'POST'
    })
    .error(function(xhr, status, data) {
        console.log(xhr.responseText, null, null);
    })
    .success(function(data, status, xhr) {
        window.setTimeout(function () {
            window.location = './feedback_report.php?session_id=<?php echo $session_id; ?>&activity_id=<?php echo $activity_id; ?>';
        }, 7000);
    });
}

</script>

<script src="/static/vendor/ladda/spin.min.js"></script>
<script src="/static/vendor/ladda/ladda.min.js"></script>

<?php
    include_once '../includes/rubric.php';
    include_once 'includes/footer.php';
