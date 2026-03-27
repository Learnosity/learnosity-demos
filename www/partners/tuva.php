<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    "consumer_key"    => $consumer_key ,
    "domain"          => $domain
];

$request = [
    'activity_id' => 'Activity_Test',
    'activity_template_id' => 'Tuva-Demo-Activity',
    'rendering_type' => 'assess',
    'user_id' => 'ANONYMIZED_USER_ID',
    'session_id' => Uuid::generate(),
    'type' => 'submit_practice',
    'name' => 'Test Assessment',
    'config'         => [
        'configuration' => [
            'onsubmit_redirect_url' => 'tuva.php'
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h2>Maintenance Mode</h2>
        <p>The Authoring Demos are currently undergoing maintenance and will return soon.</p>
    </div>
</div>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
