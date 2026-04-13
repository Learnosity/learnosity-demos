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

//here we use Alchemie config file to define Custom Features and Question Types.
//Contact partners@learnosity.com to get a commercial licence.
$AlchemieConfig = file_get_contents('https://lti.alchem.ie/lrn/config');
$AlchemieConfig = json_decode($AlchemieConfig, true);


//simple API request object for item edit view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'dependencies' => [
            'question_editor_api' => [
                'init_options' => $AlchemieConfig
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
        <h2>Alchemie</h2>
        <p style="text-align:justify;">
        The Alchemie integration is transforming the options for chemistry question types. Now, prompts can require students to build or use a model to answer a question. Included are four new custom question types and one new feature to enable exploration of chemical structures and three-dimensional models.
        </p>
        <p style="text-align:justify;">
        With the Learnosity and Alchemie partnership, Learnosity clients have access to these new game-inspired interactives that provide students with dynamic experiences of STEM content.
        </p>
        <p>
        In this demo, you can Author a new question using Alchemie custom question types.<br/>
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