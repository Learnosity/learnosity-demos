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
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Browse and Tag Learning Standards: Academic Benchmarks</h2>
            <p>Academic Benchmarks learning standards metadata—such as standards text, academic subject and grade level—is visible in Learnosity’s Author API user interface, for streamlined and accurate standards alignment of items authored in Learnosity.</p>
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
