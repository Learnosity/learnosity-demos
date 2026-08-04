<?php

$pageTitle = "Create New Activities - Learnosity Demos";

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


$request = [
    'mode'      => 'activity_edit',
    'reference' => Uuid::generate(),
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    ],
    'config' => [
        'activity_list' => [
            'toolbar' => [
                'add_random' => true
                ]
        ]
    ]
];

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#"  data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
                <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000105358-Learnosity-Author" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Create New Activities</h2>
            <p>
                The activity edit mode allows authors to create and edit activities that are automatically saved to your Learnosity-hosted item bank.
            </p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the author api to load into -->
        <div id="learnosity-author"></div>
    </div>

    <script src="<?php echo $url_authorapi; ?>"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                authorApp.navigate('activities/new/random');
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
