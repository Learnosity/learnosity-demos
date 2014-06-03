<?php
include_once '../../config.php';
include_once 'Learnosity/Sdk/Request/Init.php';

use LearnositySdk\Request\Init;

// NOTE: For now, demo requests only output 1 x user_id, 1 x activity_id and/or 1 x session_id
// If future implementation allows for arrays (e.g. column onClick, row onClick), all of this must change
$_G = array(
    'session_id',
    'user_id',
    'activity_id',
    'report'
);

foreach ($_G as $key => $var) {
    if (isset($_GET[$var])) {
        $_G[$var] = trim(preg_replace('@[^a-zA-Z0-9_\-]@', '', $_GET[$var]));
    }
    unset($_G[$key]);
}

if (count($_G)) {

    $security = array(
        'consumer_key' => $consumer_key,
        'domain'       => $domain
    );

    $buildReport = null;
    switch ($_G['report']) {
        case 'sessions-summary':
            $reportTitle = 'Sessions Summary';
            $buildReport = array(
                'id'          => 'demo-report',
                'type'        => 'sessions-summary',
                'user_id'     => $_G['user_id'],
                'session_ids' => array(
                    $_G['session_id']
                )
            );
            break;
        case 'session-detail':
            $reportTitle = 'Session Detail';
            $buildReport = array(
                'id'          => 'demo-report',
                'type'        => 'session-detail',
                'user_id'     => $_G['user_id'],
                'session_id' => $_G['session_id']
            );
            break;
        case 'sessions-summary-by-tag':
            $reportTitle = 'Sessions Summary By Tag';
            $buildReport = array(
                'id'          => 'demo-report',
                'type'        => 'sessions-summary-by-tag',
                'user_id'     => $_G['user_id'],
                'ui'          => 'table',
                'hierarchy'   => 'author',
                'session_ids' => array(
                    $_G['session_id']
                )
            );
            break;
        case 'lastscore-by-activity':
            $reportTitle = 'Latest Score By Activity';
            $buildReport = array(
                'id'           => 'demo-report',
                'type'         => 'lastscore-by-activity',
                'scoring_type' => 'partial',
                'user_id'      => $_G['user_id'],
                'activities'   => array(
                    array(
                        'id' => $_G['activity_id'],
                        'name' => 'Generated Activity' // todo: need more data
                    )
                )
            );
            break;
        case 'lastscore-by-activity-by-user':
            $reportTitle = 'Latest Score By Activity By User';
            $buildReport = array(
                'id'           => 'demo-report',
                'type'         => 'lastscore-by-activity-by-user',
                'scoring_type' => 'partial',
                'ui'           => 'numeric',
                'users'        => array(
                    array(
                        'id' => $_G['user_id'],
                        'name' => 'Generated User' // todo: need more data
                    )
                ),
                'activities' => array(
                    array(
                        'id' => $_G['activity_id'],
                        'name' => 'Generated Activity' // todo: need more data
                    )
                )
            );
            break;
        case 'lastscore-by-tag-by-user':
            $reportTitle = 'Latest Score By Tag By User';
            $buildReport = array(
                'id'    => 'demo-report',
                'type'  => 'lastscore-by-tag-by-user',
                'users' => array(
                    array(
                        'id' => $_G['user_id'], // todo: need more data
                        'name' => 'Generated User'
                    )
                ),
                'activity_id' => $_G['activity_id'],
                'hierarchy' => 'questiontype'
            );
            break;
        case 'lastscore-by-item-by-user':
            $reportTitle = 'Latest Score By Item By User';
            $buildReport = array(
                'id'           => 'demo-report',
                'type'         => 'lastscore-by-item-by-user',
                'scoring_type' => 'partial',
                'users'        => array(
                    array(
                        'id' => $_G['user_id'], // todo: need more data
                        'name' => 'Generated User'
                    )
                ),
                'activity_id' => $_G['activity_id']
            );
            break;
        default:
            break;
    }

    $request = array(
        'reports' => array(
            $buildReport
        )
    );

    $Init = new Init('reports', $security, $consumer_secret, $request);
    $signedRequest = $Init->generate();

    ?>
    <div class="lrn-reports-demo-wrapper">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="lrn-reports-demos-modal-label">Onclick Report</h4>
            <div class="alert alert-info">
                <?php echo (isset($_G['user_id']) ? '<strong>User ID:</strong> ' . $_G['user_id'] . ',<br>' : ''); ?>
                <?php echo (isset($_G['activity_id']) ? '<strong>Activity ID:</strong> ' . $_G['activity_id'] . ',<br>' : ''); ?>
                <?php echo (isset($_G['session_id']) ? '<strong>Session ID:</strong> ' . $_G['session_id'] . '<br>' : ''); ?>
            </div>
        </div>
        <section>
            <h3 class="report-title"><?php echo $reportTitle; ?></h3>
            <span class="learnosity-report" id="demo-report"></span>
        </section>
    </div>
    <script type="text/javascript">
        var config = <?php echo $signedRequest; ?>;
        config.configuration = {
            questionsApiVersion: "v2"
        };
        LearnosityReports.init(config);
    </script>
    <?php
}
