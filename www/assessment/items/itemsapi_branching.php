<?php

include_once '../../config.php';
include_once '../../../src/utils/uuid.php';
include_once '../../../src/utils/RequestHelper.php';
include_once '../../../src/includes/header.php';

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'activity_id'    => 'branchingadaptivedemo',
    'name'           => 'Items API demo - branching activity',
    'rendering_type' => 'assess',
    'state'          => 'initial',
    'course_id'      => $courseid,
    'session_id'     => UUID::generateUuid(),
    'user_id'        => $studentid,
    'adaptive'       => array(
        "type" => "branching",
        "sequence" => array(
            array(
                "activity_id" => "sequence-1A"
            ),
            array(
                "decision" => array(
                    array(
                        "activity_id" => "decision-1A",
                        "score" => 3
                    ),
                    array(
                        "activity_id" => "decision-1B",
                        "score" => 4
                    ),
                    array(
                        "activity_id" => "decision-1B",
                        "score" => 7
                    ),
                    array(
                        "activity_id" => "decision-1C",
                        "score" => 8,
                        "sequence" => array(
                            array(
                                "activity_id" => "sequence-2A"
                            ),
                            array(
                                "activity_id" => "sequence-2B"
                            )
                        )
                    )
                )
            ),
            array(
                "activity_id" => "sequence-1B"
            )
        )
    ),
    'config' => array(
        'title' => 'Branching Assessment',
        'navigation' => array(
            'intro_item'             => 'branching-intro',
            'show_prev'              => false,
            'show_progress'          => false,
            'show_fullscreencontrol' => false
        ),
        'time' => array(),
        'assessApiVersion' => 'v2',
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

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>

<div class="jumbotron">
    <h1>Items API – Branching Assessment</h1>
    <p>A dynamic assessment that presents different testlets depending on performance in the first testlet.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="//docs.learnosity.com/itemsapi/adaptive/branching.php" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_inline.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="//items.learnosity.com"></script>
<script>
    var activity = <?php echo $signedRequest; ?>;
    LearnosityItems.init(activity);
</script>

<?php
    include_once '../../../src/views/modals/settings-items-adaptive.php';
    include_once '../../../src/views/modals/initialisation-preview.php';
    include_once '../../../src/includes/footer.php';
