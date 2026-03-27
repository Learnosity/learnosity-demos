<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//alias(es) to eliminate the need for fully qualified classname(s) from sdk
use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

//security object. timestamp added by SDK
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];

// to get a commercial license to the Desmos tools, email partners@learnosity.com
$desmosconfig = file_get_contents('https://www.desmos.com/api/learnosity/get-config?questionGroups=all&features=extended');
$desmosconfig = json_decode($desmosconfig, true);


//simple api request object for item edit view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => $desmosconfig
            ]
        ]
    ],
    'user' => [
        'id' => 'demos-site',
        'firstname' => 'Demos',
        'lastname' => 'User',
        'email' => 'demos@learnosity.com'
    ]
];


$Init = new Init('author', $security, $consumer_secret, $request);
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
