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
    'activity_id'    => 'itemadaptivedemo',
    'name'           => 'Items API demo - adaptive activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'session_id'     => Uuid::generate(),
    'user_id'        => $studentid,
    'assess_inline'  => true,
    'adaptive'       => array(
        'type'                      => 'itemadaptive',
        'initial_ability'           => 0,
        'item_difficulty_tolerance' => 0.1,
        'item_difficulty_offset' => 0,
        'eap' => array(
            'mean'               => 0,
            'standard_deviation' => 1,
            'theta_min'          => -4,
            'theta_max'          => 4,
            'num_points'         => 50
        ),
        'termination_criteria' => array(
            'min_items' => 5,
            'max_items' => 50,
            'error_below' => 0.7
        ),
        'required_tags' => array(
            array('type' => 'adaptive-lifecycle', 'name' => 'operational')
        )
    ),
    'config' => array(
        'title' => 'Adaptive Assessment',
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        ),
        'navigation' => array(
            'intro_item'             => 'adaptive-intro',
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false,
            'show_acknowledgements'  => true
        ),
        'time' => array(
            'max_time' => 1800
        ),
        'questionsApiVersion' => $version_questionsapi,
        'assessApiVersion'    => $version_assessapi,
        'configuration'       => array(
            'onsubmit_redirect_url' => 'itemsapi_adaptive.php',
            'onsave_redirect_url'   => 'itemsapi_adaptive.php'
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
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Adaptive Assessment</h1>
    <p>A dynamic assessment that adapts to the user's ability in real time.<p>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
