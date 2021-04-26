<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//assessment session id
$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'user_id'      => 'demo_student',
    'domain'       => $domain,
    'consumer_key' => $consumer_key,
];

//labels taken from shared label ressource (i18n demo)
$baseRepoUrl = 'https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/';

$reportsLabels = '[]';

$url = $baseRepoUrl . 'ja-JP' . '/label_bundles/';
$reportsLabels = file_get_contents($url . '/reports-api.json');

$request = array(
    'reports' => array(
        array(
            'id'             => 'report-1',
            'type'           => 'sessions-summary',
            'user_id'        => 'demo_student',
            'session_ids'    => array($session_id)
        ),
        array(
            'id'             => 'report-2',
            'type'           => 'session-detail-by-item',
            'user_id'        => 'demo_student',
            'session_id'     => $session_id,
            'show_correct_answers' => false
        )
    ),
    'label_bundle' => json_decode($reportsLabels, true),
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/articles/360000758697-Internationalizing-and-Localizing-the-Assessment-Experience" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Japanese Demo - 日本語の披露</h1>
        <p>最後に、回答とスコアが確認のために表示されます</p>
    </div>
</div>

<div class="section">
    <h1>アクティビティを再開します</h1>
    <span class="learnosity-report" id="report-1"></span>
    <h1>アクティビティの詳細</h1>
    <span class="learnosity-report" id="report-2"></span>
</div>

<script src="<?php echo $url_reports; ?>"></script>
<script>

var reportsApp = LearnosityReports.init(<?php echo $signedRequest; ?>);

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
