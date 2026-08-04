<?php

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


//simple api request object for Items API
$request = [
    'activity_id' => 'itemsassessdemo',
    'name' => 'Items API demo - assess activity',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID',
    'items' => [

        'Demo3',
        'Demo6',
        'Demo7',
        'Demo8',
        'Demo9',   
        'Demo10'

    ],
    'config' => [
        'title' => 'Demo activity - showcasing question types and assess options',
        'subtitle' => "Walter White",
        'regions' => 'main'
    ]
];

// For more information: https://reference.learnosity.com/items-api/initialization#requestObject
// activity_id: Arbitrary string used for reporting only to compare a subset of users submitting the same assessment.
// items: Sets the content to be shown in the session. Can be an array of unique string Item references,
// or an array of Item objects for advanced usage.
// session_id: V4 UUID that uniquely identifies a specific assessment save or submission
// user_id: Anonymized unique student identifier.

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#" data-bs-toggle="modal" data-bs-target="#initialisation-preview" aria-label="Preview API Initialisation Object" data-bs-title="Preview API Initialisation Object"><span class="bi bi-search" aria-hidden="true"></span></a></li>
            <li class="list-inline-item"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" aria-label="Visit the documentation" data-bs-title="Visit the documentation"><span class="bi bi-book" aria-hidden="true"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h2>Generate Just-in-Time Fixed Form Assessments</h2>
        <p>Build your activities on the fly, and deliver content from your item bank without having to pre-author a fixed-form activity.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the Items API assessment player to load into -->
    <div id="learnosity_assess"></div>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var initializationObject = <?php echo $signedRequest; ?>;

    //optional callbacks for ready
    var callbacks = {
        readyListener: function() {
            console.log("Items API has successfully initialized.");
        },
        errorListener: function(err) {
            console.log(err);
        }
    };

    var itemsApp = LearnosityItems.init(initializationObject, callbacks);
</script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
