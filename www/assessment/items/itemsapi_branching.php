<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'activity_id'    => 'branchingadaptivedemo',
    'name'           => 'Items API demo - branching activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'course_id'      => $courseid,
    'session_id'     => Uuid::generate(),
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
        'title'      => 'Branching Assessment',
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
        'questionsApiVersion' => $version_questionsapi,
        'assessApiVersion'    => $version_assessapi,
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_branching.php',
            'onsave_redirect_url'   => 'itemsapi_branching.php'
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
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="//docs.learnosity.com/itemsapi/adaptive/branching.php" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Branching Assessment</h1>
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
