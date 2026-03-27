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

//here we use our GeoGebra config file to define Geogebra's Custom Features and Question Types.
//Contact GeoGebra to get a commercial licence.
$GeogebraConfig = gzdecode(file_get_contents('https://cdn.geogebra.org/partners/learnosity/self-host.json'));
$GeogebraConfig = json_decode($GeogebraConfig, true);


// Initialization options for Authoring Demo using Author API
$authorRequest = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => $GeogebraConfig
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


// Initialization options for Assessment Demo using Items API
$itemsRequest = [
    'activity_id' => 'demos_geogebra',
    'activity_template_id' => 'GeoGebra_Testing_Activity',
    'name' => 'GeoGebra Demo',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'config' => [
        'configuration' => [
            'onsubmit_redirect_url' => 'geogebra.php'
        ],
        'region_overrides' => [
            'right' => [
                [
                    'type' => 'save_button'
                ],
                [
                    'type' => 'fullscreen_button'
                ],
                [
                    'type' => 'accessibility_button'
                ],
                [
                    'type' => 'custom_button',
                    'options' => [
                        'name' => 'geogebra',
                        'label' => 'GeoGebra Graphing',
                        'icon_class' => 'lrn_btn ggb-calc-toggle ggb-icon-graphing'
                    ]
                ],
                [
                    'type' => 'verticaltoc_element'
                ]
            ]
        ],
        'navigation' => [
            'scroll_to_test' => false,
            'scroll_to_top' => false
        ]
    ]
];


$InitItems = new Init('items', $security, $consumer_secret, $itemsRequest);
$signedRequestItems = $InitItems->generate();

$InitAuthor = new Init('author', $security, $consumer_secret, $authorRequest);
$signedRequestAuthor = $InitAuthor->generate();

?>
<div class="jumbotron section">
    <div class="overview">
        <h2>Maintenance Mode</h2>
        <p>The Authoring Demos are currently undergoing maintenance and will return soon.</p>
    </div>
</div>
<?php
    include_once 'includes/footer.php';
