<?php

include_once '../../../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\DataApi;
use LearnositySdk\Utils\Uuid;

$session_id = $_GET['session_id'];
$activity_id = $_GET['activity_id'];

$security = [
    'user_id'      => $studentid,
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

$request = array(
    'include_response_scores' => true,
    'session_id' => array(
        $session_id
    )
);

$endpoint = $url_data . '/latest/sessions/responses/scores';
$action = 'get';

$dataapi = new DataApi();
$response = $dataapi->request($endpoint, $security, $consumer_secret, $request, $action);

if (strlen($response->getBody())) {
    $report = $response->getBody();
} else {
    $err = $response->getError();
    echo $err['message'];
    die;
}

$report = json_decode($report, true);
$scores = $report['data'][0];

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/reportsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Student Feedback Review – Step 3</h1>
        <p>This template renders the customs score(s), as added by a teacher, per student response
        in a simple table.</p>
        <p>In this example we pull the scores from the Data API and render them as an HTML table. You could
        also use one of the supported reports in the <a href="<?php echo $env['www'] ?>/reporting/reports">Reports API</a>.</p>
        <div class="previewWrapper preview" style="display: none; height: 300px; overflow: scroll;"><pre><code id="xApiPreview"></code></pre></div>
    </div>
</div>

<div class="section">
    <!-- Container for the Reports API to load into -->
    <div class="row">
        <div class="col-md-12">
            <h1>Student Score Report</h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Student</th>
                        <?php
                        foreach ($scores['responses'] as $i => $val) {
                            echo '<th>Question ' . ($i+1) . '</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $scores['user_id']; ?></td>
                        <?php
                        foreach ($scores['responses'] as $i => $val) {
                            echo '<td>' . $val['score'] . '</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="lrn pull-right">
                <button type="button" class="ladda-button btn_save_simple_scores" data-style="expand-right" onclick="location.href='./feedback.php?session_id=<?php echo $session_id; ?>&activity_id=<?php echo $activity_id; ?>'"><span class="ladda-label">&laquo; Score again</span></button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    th:first-child, td:first-child {
        border-left: none !important;
    }
    .lrn .row {
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .learnosity-report h3 {
        font-weight: 400;
    }
</style>

<?php
    include_once 'includes/footer.php';
