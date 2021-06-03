
<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;



$item_ref = Uuid::generate();
$activity_id = 'Demo_Activity';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS, ['options' => ['default' => Uuid::generate()]]);

$request = [
    'activity_id'    => $activity_id,
    'name'           => 'End to End Demo - Assessment',
    'rendering_type' => 'assess',
    'type'           => 'submit_practice',
    'session_id'     => $session_id,
    'user_id'        => 'demos-site',
    'items'          => getItemsArray(),
    'config'         => [
        'title' => 'Demo Activity',
        'configuration' => [
            'onsubmit_redirect_url' => 'feedback.php?session_id=' . $session_id
        ],
        'regions' => 'main',
        'labelBundle' => [
            'close' => 'Go to Reporting'
        ]
    ]
];


function getItemsArray()
{
    return explode(",", filter_input(INPUT_GET, 'itemIDs', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    ;
}


$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="overview">
        <h1>End to End Demo – Assessment</h1>
        <p>Here is a sample student assessment containing the questions created by the author in step 1.</p>
        <p>Take the test as a student would, you will then be able to provide teacher feedback after completing the assessment.</p>
    </div>
</div>

<div class="section">
    <div id="learnosity_assess"></div>
</div>

<script src="<?php echo $url_items; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;

    var itemsApp = LearnosityItems.init(initOptions);
</script>

<?php
    include_once 'includes/footer.php';
