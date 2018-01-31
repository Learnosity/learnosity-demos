<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$sessionId = Uuid::generate();
$state = 'initial';
if (isset($_GET['session_id'])) {
    $state = 'resume';
    $sessionId = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

$request = array(
    'activity_id'    => 'itembranchingadaptivedemo',
    'name'           => 'Items API - Item Branching dynamic activity',
    'rendering_type' => 'assess',
    'state'          => $state,
    'session_id'     => $sessionId,
    'user_id'        => $studentid,
    'assess_inline'  => true,
    'adaptive'       => array(
        'type'       => 'itembranching',
        'steps'      => array(
            array(
                'id'                => 'item-1',
                'reference'         => 'French_Demo1',
                'next'              => array(
                    'correct'             => 'item-3',
                    'incorrect'           => 'item-2'
                )
            ),
            array(
                'id'                => 'item-2',
                'reference'         => 'French_Demo2',
                'next'              => 'item-3'
            ),
            array(
                'id'                => 'item-3',
                'reference'         => 'French_demo4',
                'next'              => 'decision-1',
            ),
            array(
                'id'                => 'decision-1',
                'type'              => 'global-score',
                'percentage'        => 50,
                '>='                => 'item-5',
                '<'                 => 'item-4',
            ),
            array(
                'id'                => 'item-4',
                'reference'         => 'French_Demo3',
                'next'              => 'item-5'
            ),
            array(
                'id'                => 'item-5',
                'reference'         => 'French_Demo5',
                'next'              => null
            ),
        )
    ),
    'config' => array(
        'title'      => 'Item Branching Assessment',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'regions'   => 'main',
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
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_adaptive_report.php?session_id=' . $sessionId,
            'onsave_redirect_url'   => 'itemsapi_itembranching.php',
            'responsive_regions' => true
        ),
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment#itembranching" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API &mdash; Item Branching Assessment</h1>
    <p>A simple dynamic assessment that selects the next item or branch based on past performance, according to a pre-defined configuration.<p>
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
