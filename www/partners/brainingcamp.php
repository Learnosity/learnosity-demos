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
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Brainingcamp</h2>
        <p style="text-align:justify;">
        Brainingcamp math manipulatives easily embed into your product, combining the familiarity of physical manipulatives with the convenience and powerful learning features of our digital tools.</p>
        <p style="text-align:justify;">
        With the Learnosity and Braningcamp partnership, Learnosity clients have access to Brainingcamp digital manipulatives are intuitive, easy to use, and packed with powerful learning tools like number lines, ten frames, regrouping animations, factor tracks, and so much more.
        </p>
        <p>
        In this demo, you can Author a new question using Braningcamp custom question types.<br/>
        You can then preview the result as it will be used in an Assessment.
        </p>
    </div>
</div>

<!-- Container for the author api to load into -->
<div class="section pad-sml">
    <!--    HTML placeholder that is replaced by API-->
    <div id="learnosity-author"></div>
</div>

<!-- version of api maintained in lrn_config.php file -->
<script src="<?php echo $url_authorapi; ?>"></script>
<script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Author API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var authorApp = LearnosityAuthor.init(initializationObject, callbacks);

</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';