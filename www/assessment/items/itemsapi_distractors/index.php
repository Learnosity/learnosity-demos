<?php

include_once '../../../config.php';
include_once 'utils/uuid.php';
include_once 'utils/RequestHelper.php';
include_once 'includes/header.php';

$session_id = UUID::generateUuid();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'timestamp'    => $timestamp
);

$request = array(
    'user_id'        => $studentid,
    'rendering_type' => 'inline',
    'name'           => 'Items API demo - Distractor Rationale Demo',
    'state'          => 'initial',
    'activity_id'    => 'itemsinlinedistractordemo',
    'session_id'     => $session_id,
    'course_id'      => $courseid,
    'items'          => array(
        'act1',
        'act2',
        'act3',
        'act4',
        'act5',
        'act6',
        'act7',
        'act8',
        'act9',
        'act10',
        'act11',
        'act12',
        'act13',
        'act14',
        'act15',
        'act16',
        'act17',
        'act18',
        'act19',
        'act20'),
    'type'           => 'submit_practice',
    'config'         => array(
        "questionsApiVersion" => "v2",
        'renderSubmitButton'  => false
    )
);

$RequestHelper = new RequestHelper(
    'items',
    $security,
    $consumer_secret,
    $request
);

$signedRequest = $RequestHelper->generateRequest();

?>
<link rel="stylesheet" href="demo.css">
<!-- Container for the items api to load into -->
<script src="//items.learnosity.com/"></script>
<script>
    var ItemsAPI,
        activity = <?php echo $signedRequest; ?>;
    ItemsAPI = LearnosityItems.init(activity);
</script>

<div class="jumbotron">
    <h1>Items API – Distractor Rationale</h1>
    <p>Demonstration of extending the Items API and Reports API to show custom distractor rationales.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Items API Documentation
            </a></h4>
            <h4><a href="http://docs.learnosity.com/reportsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Reports API Documentation
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
        </div>
    </div>
</div>

<!-- HTML element to load item(s) into -->
<?php
    foreach ($request['items'] as $index => $item) {
        echo('
<h2>Question ' . ($index+1) . '</h2>
<p><span class="learnosity-item" data-reference="' . $item . '"></span></p>
            ');
    }
?>
    <a id="submit-activity" class="btn btn-primary">Submit</a>

    <div class="modal fade" id="loaderModal">
        <img src="loader.svg" alt="Loading icon" width="64" height="64" />
    </div>

    <div class="modal fade" id="testSubmitModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="padding:15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body">
                    <p>Test is submitted.</p>
                    <p>On the next screen you will be shown the distractor rationales for all questions that you have attempted.  The styling and positioning of the distractors is fully controllable by the host environment.</p>
                </div>
                <div class="modal-footer">
                    <a href="report.php?sessionId=<?php echo $session_id; ?>" class="btn btn-primary">View report</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /#testSubmitModal -->

<script>

$('#submit-activity').on('click', function (e) {
    $('#loaderModal').modal({
        show: true,
        backdrop: 'static'
    });
    $(this).attr('disabled', 'disabled');
    ItemsAPI.submit({
        success: function (response_ids) {
            $('#loaderModal').modal('hide');
            // Recieves a list of the submitted user responses as [response_id]
            $('#testSubmitModal').modal('show');
        }
    });
    return false;
});
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
