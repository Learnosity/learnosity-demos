<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

//alias(es) to eliminate the need for fully qualified classname(s) from sdk
use LearnositySdk\Request\Init;


//security object. timestamp added by SDK
$security = [
    'consumer_key' => $consumer_key,
    'domain' => $domain
];


//simple api request object for item list view
$request = [
    'mode' => 'item_list',
    'config' => [
        'item_edit' => [
            'item' => [
                'reference' => [
                    'show' => true,
                    'edit' => true
                ],
                'dynamic_content' => true,
                'shared_passage' => true
            ]
        ],
        'global' => [
            'ab_standards' => [
                'enable' => true,
                'aligned_tag_type' => 'lrn_ab_aligned',
                'tag_standard_hierarchy' => false,
                'edit_standards' => true,
                'filter' => true
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
