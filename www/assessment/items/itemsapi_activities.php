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
    'activity_template_id' => 'demo-activity-1',
    'activity_id'          => 'my-demo-activity',
    'name'                 => 'Demo Activity',
    'course_id'            => $courseid,
    'session_id'           => Uuid::generate(),
    'user_id'              => $studentid,
    'assess_inline'        => false,
    'config'               => array(
        'administration' => array(
            'pwd' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' // `password`
        )
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/itemsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Next demo"><a href="itemsapi_workedsolutions.php"><span class="glyphicon glyphicon-circle-arrow-right"></span></a></li>
        </ul>
    </div>
    <h1>Items API – Activities</h1>
    <p>Activities are a wrapper for multiple items authored in the Learnosity Author site. They can also
    include configuration used by the <a href="<?php echo $env['www'] ?>assessment/assess/index.php">Assess API</a> to control the assessment user interface.</p>
    <p>Preview the <a href="#" data-toggle="modal" data-target="#initialisation-preview">API Initialisation Object</a> to see how simple it can be using the Items API to load activities
    authored in the Learnosity item bank.<p>
    <p><a href="#" data-toggle="modal" data-target="#settings">Customise the activity</a> you want to load.<p>
    <p>Type ctrl+shift+m to open the Administration Panel. The default password is <em>password</em>.</p>
</div>

<div class="section">
    <!-- Container for the items api to load into -->
    <div id="learnosity_assess"></div>
</div>
<script src="//items.learnosity.com"></script>
<script>
    var eventOptions = {
            readyListener: function () {
                console.log('Learnosity Items API is ready');
            }
        },
        activity = <?php echo $signedRequest; ?>;

    LearnosityItems.init(activity, eventOptions);
</script>

<?php
    include_once 'views/modals/settings-items-activities.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
