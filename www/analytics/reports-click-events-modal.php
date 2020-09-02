<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;

$session_id  = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_id     = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$activity_id = filter_input(INPUT_GET, 'activity_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'reports' => [
        [
            'id'          => 'click-event-report',
            'type'        => 'sessions-summary',
            'user_id'     => $user_id,
            'session_ids' => [
                $session_id
            ]
        ]
    ]
];

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<div class="lrn-reports-demo-wrapper">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="lrn-reports-demos-modal-label">Onclick Report</h4>
        <div class="alert alert-info">
            <?php echo (isset($user_id) ? '<strong>User ID:</strong> ' . $user_id . ',<br>' : ''); ?>
            <?php echo (isset($activity_id) ? '<strong>Activity ID:</strong> ' . $activity_id . ',<br>' : ''); ?>
            <?php echo (isset($session_id) ? '<strong>Session ID:</strong> ' . $session_id . '<br>' : ''); ?>
        </div>
    </div>
    <section>
        <h3 class="report-title">Sessions Summary</h3>
        <span class="learnosity-report" id="click-event-report"></span>
    </section>
</div>

<script type="text/javascript">
    var initializationObjectModal = <?php echo $signedRequest; ?>;
    var reportsAppModal = LearnosityReports.init(initializationObjectModal);
</script>