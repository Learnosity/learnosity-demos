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
    'activity_id' => 'itemsactivitiesdemo',
    'activity_template_id' => 'demo-activity-1',
    'name' => 'Items API demo - activities',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'ANONYMIZED_USER_ID'
];

// For more information: https://reference.learnosity.com/items-api/initialization#requestObject
// activity_id: Arbitrary string used for reporting only to compare a subset of users submitting the same assessment.
// activity_template_id: Item bank reference of the activity, used to fetch its items and configuration options
// session_id: V4 UUID that uniquely identifies a specific assessment save or submission
// user_id: Anonymized unique student identifier.

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Build Pre-Written Fixed Form Assessments</h2>
            <p>Build fixed-form activities in Learnosity, and deliver high-quality pre-authored assessments to your end-users using Activities. Activities are a pre-authored fixed form test for multiple items, along with test configuration, authored in the Learnosity Author site, or via the Author API.</p>
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
            readyListener: function () {
                console.log("Items API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
