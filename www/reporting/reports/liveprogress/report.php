<?php

include_once '../../../config.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'user_id'      => $teacherid,
    'domain'       => $domain
);

$userIds = explode(',', $_GET['user_ids']);

$request  = array(
    'reports' => array(
        array(
            'id'             => 'report-1',
            'type'           => 'live-activitystatus-by-user',
            'control_events' => true,
            'activity'       => array(
                'title' => 'Demo Test'
            ),
            'users' => array(
                array(
                    'id'   => $userIds[0],
                    'name' => 'Jesse Pinkman',
                    'hash' => hash('sha256', $userIds[0] . $consumer_secret)
                ),
                array(
                    'id'   => $userIds[1],
                    'name' => 'Walter White',
                    'hash' => hash('sha256', $userIds[1] . $consumer_secret)
                ),
                array(
                    'id'   => $userIds[2],
                    'name' => 'Hank Schrader',
                    'hash' => hash('sha256', $userIds[2] . $consumer_secret)
                )
            )
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div id="report-1"></div>

<script src="<?php echo $url_reports; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        eventOptions = {
            readyListener: init
        },
        reportsApp = LearnosityReports.init(initOptions, eventOptions);

    function init () {
        reportsApp.getReport('report-1').on('progressed', function (events) {
            console.log('Received events: ', events);
        });
    }
</script>
