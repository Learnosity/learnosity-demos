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

//simple api request object for item edit view
$request = [
    'mode' => 'item_edit',
    'reference' => Uuid::generate(),
    'config' => [
        'item_edit' => [
            'item' => [
                'reference' => [
                    'edit' => true
                ],
                'dynamic_content' => true,
                'shared_passage' => true,
                'actions' => [
                    'show' => true
                ],
                'details' => [
                    'description' => [
                        'show' => true,
                        'edit' => true
                    ],
                    'source' => [
                        'show' => true,
                        'edit' => true
                    ],
                    'note' => [
                        'show' => true,
                        'edit' => true
                    ]
                ],
                'enable_audio_recording'=>true
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Create New Items</h2>
        <p>Below is a demo of the Author API creating a new item each time. Questions and features can be added or edited and all are automatically saved in your Learnosity item bank.</p>
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
