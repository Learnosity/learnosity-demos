<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;

$reportVariables = [
    'session_id',
    'user_id',
    'activity_id',
    'report',
    'context'
];

if (count($reportVariables)) {
    $security = [
        'consumer_key' => $consumer_key,
        'domain'       => $domain
    ];

    foreach ($reportVariables as $key => $var) {
        if (isset($_GET[$var])) {
            $reportVariables[$var] = trim(preg_replace('@[^a-zA-Z0-9_\-]@', '', $_GET[$var]));
        }
        unset($reportVariables[$key]);
    }

    $reportTitle = 'Sessions Summary';
    $request = [
        'reports' => [
            [
                'id'          => 'demo-report',
                'type'        => 'sessions-summary',
                'user_id'     => $reportVariables['user_id'],
                'session_ids' => [
                    $reportVariables['session_id']
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
                <?php echo (isset($reportVariables['user_id']) ? '<strong>User ID:</strong> ' . $reportVariables['user_id'] . ',<br>' : ''); ?>
                <?php echo (isset($reportVariables['activity_id']) ? '<strong>Activity ID:</strong> ' . $reportVariables['activity_id'] . ',<br>' : ''); ?>
                <?php echo (isset($reportVariables['session_id']) ? '<strong>Session ID:</strong> ' . $reportVariables['session_id'] . '<br>' : ''); ?>
            </div>
        </div>
        <section>
            <h3 class="report-title"><?php echo $reportTitle; ?></h3>
            <span class="learnosity-report" id="demo-report"></span>
        </section>
    </div>
    <?php
    if (!isset($reportVariables['context']) || $reportVariables['context'] !== 'modal') {
    ?>
    <script src="<?php echo $url_reports; ?>"></script>
    <?php
    }
    ?>
    <script type="text/javascript">
        var config = <?php echo $signedRequest; ?>;
        window.reportsApp = LearnosityReports.init(config);

    </script>
    <?php
}
