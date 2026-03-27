<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$session_id = Uuid::generate();

$security = [
    'user_id'      => 'demos-site',
    'domain'       => $domain,
    'consumer_key' => $consumer_key
];

$request = '{
  "id": "custom-shorttext",
  "type": "local_practice",
  "state": "initial",
  "session_id": "' . $session_id . '",
  "questions": []
}';


$init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $init->generate();

?>
<div class="jumbotron section">
    <div class="overview">
        <h2>Maintenance Mode</h2>
        <p>The Authoring Demos are currently undergoing maintenance and will return soon.</p>
    </div>
</div>
<?php
include_once 'includes/footer.php';
