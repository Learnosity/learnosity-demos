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
    'adaptive'       => array(
        'type' => 'branching',
        'sequence' => array(
            array(
                'activity_id' => 'sequence-1A'
            ),
            array(
                'decision' => array(
                    array(
                        'activity_id' => 'decision-1A',
                        'score' => 3
                    ),
                    array(
                        'activity_id' => 'decision-1B',
                        'score' => 4
                    ),
                    array(
                        'activity_id' => 'decision-1B',
                        'score' => 7
                    ),
                    array(
                        'activity_id' => 'decision-1C',
                        'score' => 8,
                        'sequence' => array(
                            array(
                                'activity_id' => 'sequence-2A'
                            ),
                            array(
                                'activity_id' => 'sequence-2B'
                            )
                        )
                    )
                )
            ),
            array(
                'activity_id' => 'sequence-1B'
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
        'assessApiVersion'    => 'v2',
        'questionsApiVersion' => 'v2',
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
            <li data-toggle="tooltip" data-original-title="Next demo"><a href="itemsapi_inline.php"><span class="glyphicon glyphicon-circle-arrow-right"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Branching Assessment</h1>
    <p>A dynamic assessment that presents different testlets depending on performance in the first testlet.<p>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="//items.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
