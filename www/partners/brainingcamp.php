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

//here we use our Brainingcamp config settings to define Custom Question Types.
//Contact partners@learnosity.com to get a commercial licence.

$BrainingcampConfig = json_decode('{
	"custom_question_types": [{
		"custom_type": "bcm_custom_question",
		"type": "custom",
		"group_reference": "brainingcamp",
		"name": "Brainingcamp Manipulative Question",
		"js": "https://learnosity.brainingcamp.com/bcq.umd.min.js",
		"css": "https://learnosity.brainingcamp.com/bcq.css",
		"version": "0.0.1",
		"editor_layout": "https://learnosity.brainingcamp.com/bcq.html",
		"editor_schema": {
			"hidden_question": false,
			"properties": {
				"share_code": {
					"name": "Share Code",
					"type": "text",
					"default": ""
				}
			}
		}
	}],
	"question_type_groups": [{
		"name": "Brainingcamp",
		"reference": "brainingcamp",
		"group_icon": "https://learnosity.brainingcamp.com/bc_logo@2x.png"
	}],
	"question_type_templates": {
		"bcm_custom_question": {
			"name": "Brainingcamp Manipulative",
			"description": "Add a Brainingcamp manipulative or specific manipulative activity.",
			"image": "https://learnosity.brainingcamp.com/bcq-card-img.png",
			"group_reference": "brainingcamp",
			"defaults": {
				"type": "custom",
				"js": "https://learnosity.brainingcamp.com/bcq.umd.min.js",
				"css": "https://learnosity.brainingcamp.com/bcq.css"
			}
		}
	}
}', true);


//simple API request object for item edit view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => $BrainingcampConfig
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