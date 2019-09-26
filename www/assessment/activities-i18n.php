<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;


$labels = '[]';
$language = 'english';

if (isset($_GET['language'])) {
    $language = $_GET['language'];
    if ($language !== 'english') {
        $labels = file_get_contents("https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/" . $language . "/assess-api.json");
    }
}

// TODO: Remove this when we have the multi lingual items in all environments.
if (isset($_GET['env']) === false) {
    $url_items = '//items.learnosity.com';
}

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

switch ($language) {
    case 'arabic':
        $activityTemplateId = 'i18n-acty1-arb';
        break;
    case 'spanish':
        $activityTemplateId = 'i18n-acty1-spa';
        break;
    default:
        $activityTemplateId = 'i18n-acty1-eng';
        break;
}


//simple api request object for Items API
$request = [
    'activity_id' => 'itemsactivitiesdemo',
    'activity_template_id' => $activityTemplateId,
    'name' => 'Items API demo - activities',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => 'demos-site',
    'config' => [
        'regions' => 'main',
        'labelBundle' => json_decode($labels, true)
    ]
];

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
            <h2>Build Pre-Written Fixed Form Assessments (with Language Selection)</h2>
            <p>Build fixed-form activities in Learnosity, and deliver high-quality pre-authored assessments to your end-users using Activities. Activities are a pre-authored fixed form test for multiple items, along with test configuration, authored in the Learnosity Author site, or via the Author API.</p>
            <p>This demo uses <a href="https://github.com/Learnosity/learnosity-i18n">learnosity-i18n</a> which is a public repository of Learnosity internationalization language bundles.</p>
        </div>
        <form class="form-horizontal" action="/assessment/activities-i18n.php" method="get">
            <div class="form-group">
                <label class="col-md-1 control-label">Language</label>
                <div class="col-md-2">
                    <select class="form-control" name="language">
                        <option <?php if ($language === 'english') { echo 'selected=true'; } ?> value="english">English</option>
                        <option <?php if ($language === 'arabic') { echo 'selected=true'; } ?> value="arabic">Arabic (with RTL)</option>
                        <option <?php if ($language === 'spanish') { echo 'selected=true'; } ?> value="spanish">Spanish</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-10">
                    <input class="btn btn-primary" value="Change language" type="submit">
                </div>
            </div>

        </form>
    </div>

    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script <?php if ($language === 'arabic') { echo 'data-lrn-dir="rtl"'; } ?> src="<?php echo $url_items; ?>"></script>
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
