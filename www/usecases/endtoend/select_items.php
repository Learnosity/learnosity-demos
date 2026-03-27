<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'mode'      => 'item_list',
    'config'    => [
        'item_list' => [
            'item' => [
                'enable_selection' => true,
                'status' => true
            ]
        ]
    ],
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
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
    include_once 'includes/footer.php';
