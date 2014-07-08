<?php

include_once '../../../config.php';

use LearnositySdk\Request\Init;

$security = array(
    'consumer_key' => $consumer_key,
    'user_id'      => $teacherid,
    'domain'       => $domain
);

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
                    'id'   => 'jessepinkman',
                    'name' => 'Jesse Pinkman',
                    'hash' => hash('sha256', 'jessepinkman' . $consumer_secret)
                ),
                array(
                    'id'   => 'walterwhite',
                    'name' => 'Walter White',
                    'hash' => hash('sha256', 'walterwhite' . $consumer_secret)
                ),
                array(
                    'id'   => 'hankschrader',
                    'name' => 'Hank Schrader',
                    'hash' => hash('sha256', 'hankschrader' . $consumer_secret)
                )
            )
        )
    )
);

$Init = new Init('reports', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div id="report-1"></div>

<script src="//reports.learnosity.com"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;
    LearnosityReports.init(initOptions);
</script>
