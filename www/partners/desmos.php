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

// to get a commercial license to the Desmos tools, email partnerships@desmos.com 
$desmosconfig = file_get_contents('https://www.desmos.com/api/learnosity/get-config?questionGroups=all&features=all');
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
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Desmos Graphing & Scientific Calculators</h2>
        <p>
            Below is a demo of the Learnosity Author API with Desmos Question Types. You can create Desmos custom question types effortlessly.
        </p>
        <p style="text-align:justify;">
        Through the Desmos and Learnosity partnership, clients can leverage the Graphing and 
        Scientific Calculators in two ways. First, these Calculators can be included as a feature on any Learnosity item. 
        Second, authors can create custom open-ended, graded math items within seconds.
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
