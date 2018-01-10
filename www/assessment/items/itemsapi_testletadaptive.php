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

$request = array(
    'activity_id'    => 'branchingadaptivedemo',
    'name'           => 'Items API - Testlet Adaptive activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'session_id'     => $sessionId,
    'user_id'        => $studentid,
    'assess_inline'  => true,
    'adaptive'       => array(
        'type'                      => 'branching',
        'item_difficulty_tolerance' => 1,
        'min_item_difficulty'       => -4,
        'max_item_difficulty'       => 2,
        'initial_ability'           => 0,
        'eap'                       => array(
            'mean' => -0.25,
            'standard_deviation' => 0.95,
            'theta_min' => -3,
            'theta_max' => 2.25,
            'num_points' => 40
        ),
        'sequence' => array(
            array(
                'required_tags' => array(
                    'Testlet' => array(
                        'sequence-1A'
                    )
                )
            ),
            array(
                'required_tags' => array(
                    'Testlet' => array(
                        'sequence-1B'
                    )
                )
            ),
            array(
                'required_tags' => array(
                    'Testlet' => array(
                        'decision-1A'
                    )
                )
            )
        )
    ),
    'config' => array(
        'title'      => 'Testlet Adaptive Assessment',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'ui_style'   => 'horizontal-fixed',
        'navigation' => array(
            'intro_item'             => 'branching-intro',
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false,
            'scroll_to_top'          => true,
            'scroll_to_test'         => false,
        ),
        'time' => array(
            'max_time' => 1800
        ),
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_adaptive_report.php?session_id=' . $sessionId,
            'onsave_redirect_url'   => 'itemsapi_testletadaptive.php',
            'responsive_regions'    => true
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment#testletAdaptive" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API &mdash; Testlet Adaptive Assessment</h1>
    <p>A dynamic assessment that presents different testlets depending on performance in the first testlet.<p>
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
