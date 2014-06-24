<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain,
    'user_id'      => "_pearson_"
);

$uniqueResponseIdSuffix = Uuid::generate();

// Activity JSON:  http://docs.learnosity.com/questionsapi/activity.php
$request = '{
    "type": "submit_practice",
    "state": "review",
    "questions": [
        {
            "response_id": "_pearson_40-1328188500365",
            "type": "audio"
        }
    ]
}';

$Init = new Init('questions', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<!-- Container for the questions api to load into -->
<script src="//questions.learnosity.com"></script>
<script>
    var lrnActivity = LearnosityApp.init(<?php echo $signedRequest; ?>);
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Demos</h2>

<div class="row">
    <div class="col-md-6">
        <span class="learnosity-response question-_pearson_40-1328188500365"></span>
    </div>
</div>
<hr>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
