<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$session_id = Uuid::generate();
$state = 'initial';
if (isset($_GET['session_id'])) {
    $state = 'resume';
    $session_id = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

$request = array(
    'activity_id'    => 'itembranchingadaptivedemo',
    'name'           => 'Items API demo - Item Branching Assessment',
    'rendering_type' => 'assess',
    'state'          => $state,
    'session_id'     => $session_id,
    'user_id'        => $studentid,
    'assess_inline'  => true,
    'adaptive'       => array(
        "type"       => "itembranching",
        "steps"      => array(
            array(
                "id"                => "question-1",
                "reference"         => "itembranching-demo-algebra-1",
                /* "organisation_id"   => 2, */
                /* "pool_id"           => "2017", */
                "next"              => array(
                    "correct"             => "question-2",
                    "incorrect"           => "question-1.1"
                )
            ),
            array(
                "id"                => "question-2",
                "reference"         => "itembranching-demo-calculus-1",
                "next"              => array(
                    "type"                => "binary",
                    "correct"             => "question-3",
                    "incorrect"           => "question-2.1"
                )
            ),
            array(
                "id"                => "question-3",
                "reference"         => "itembranching-demo-algebra-1-longtext",
                "organisation_id"   => 2,
                "pool_id"           => "2017",
                "next"              => array(
                    "type"                => "binary",
                    "correct"             => "decision-1",
                    "incorrect"           => "question-3.1"
                )
            ),
            array(
                "id"                => "decision-1",
                "type"              => "global-score",
                "percentage"        => 50,
                ">="                => "open-question-2",
                "<"                 => "open-question-1",
            ),
            array(
                "id"                => "open-question-1",
                "reference"         => "itembranching-demo-open1",
                "next"              => "open-question-2"
            ),
            array(
                "id"                => "open-question-2",
                "reference"         => "itembranching-demo-open2",
                "next"              => "open-question-3"
            ),
            array(
                "id"                => "open-question-3",
                "reference"         => "itembranching-demo-open3",
                "next"              => null
            ),
            array(
                "id"                => "question-1.1",
                "reference"         => "itembranching-demo-algebra-1.1",
                "next"              => "question-2"
            ),
            array(
                "id"                => "question-2.1",
                "reference"         => "itembranching-demo-calculus-1-easier",
                "next"              => "question-3"
            ),
            array(
                "id"                => "question-3.1",
                "reference"         => "itembranching-demo-algebra-1.2",
                "next"              => "decision-1"
            )
        )
    ),
    'config' => array(
        'title'      => 'Item Branching Assessment',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'ui_style'   => 'horizontal-fixed',
        'navigation' => array(
            'intro_item'             => 'itembranching-intro',
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false,
            'toc'                    => false,
        ),
        'time' => array(
            'max_time' => 1800
        ),
        'assessApiVersion'    => "latest",
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_itembranching.php',
            'onsave_redirect_url'   => 'itemsapi_itembranching.php'
        )
    )
);

if (isset($_POST['adaptive'])) {
    foreach ($_POST['adaptive'] as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $childKey => $childValue) {
                if (strlen($childValue)) {
                    $request['adaptive'][$key][$childKey] = (float) $childValue;
                } else {
                    unset($request['adaptive'][$key][$childKey]);
                }
            }
        } else {
            if (strlen($value)) {
                $request['adaptive'][$key] = (float) $value;
            } else {
                unset($request['adaptive'][$key]);
            }
        }
    }
}

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment#branching" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API - Item Branching Assessment</h1>
    <p>A dynamic assessment that presents different selected items depending on the performance so far.
    <a href="<?php print(($_SERVER['PHP_SELF']). '?session_id=' . $session_id); ?>">Resume the session here</a>.<p>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var activity = <?php echo $signedRequest; ?>,
        itemsApp = LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
