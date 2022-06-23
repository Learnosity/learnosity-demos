<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

// Decide which items your want to print
$items = [
    [
        'id' => 'printing-mcq',
        'reference' => 'printing-mcq'
    ],
    [
        'id' => 'printing-mcq-multi',
        'reference' => 'printing-mcq-multi'
    ],
    [
        'id' => 'printing-token',
        'reference' => 'printing-token'
    ],
    [
        'id' => 'printing-fillintheblank',
        'reference' => 'printing-fillintheblank'
    ]
];
$sessionid = Uuid::generate();

// Load the assessment in `local_practice` (you won't want to submit actual responses)
// and using the `inline` rendering type
$request = array(
    'user_id'              => 'demo_student',
    'session_id'           => $sessionid,
    'state'                => 'review',
    'rendering_type'       => 'inline',
    'type'                 => 'local_practice',
    'items'                => $items,
    'config'               => array(
        'showCorrectAnswers'  => true,
        'fontsize'            => 'xlarge',
        'renderSubmitButton'  => false,
        'questions_api_init_options' => [
            'beta_flags' => [
                'reactive_views' => true
            ]
        ]
    )
);

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<body>

<div class="print-container">
    <div>
        <h2>MCQ</h2>
        <span class="learnosity-item" data-reference="printing-mcq"></span>
    </div>
    <div class="page-break">
        <h2>MCQ Multi</h2>
        <span class="learnosity-item" data-reference="printing-mcq-multi"></span>
    </div>
    <div class="page-break">
        <h2>Token Highlight</h2>
        <span class="learnosity-item" data-reference="printing-token"></span>
    </div>
    <div class="page-break">
        <h2>Fill in the blanks</h2>
        <span class="learnosity-item" data-reference="printing-fillintheblank"></span>
    </div>
</div>

<!-- Container for the items api to load into -->
<script src="<?php echo $url_items; ?>"></script>
<script>
    var itemsApp = LearnosityItems.init(<?php echo $signedRequest; ?>, {readyListener: init});

    /**
     * On load of the Items API, call the browser
     * print page function.
     *
     * @return void
     */
    function init () {
        window.print();
    }
</script>

<!-- Add some basic CSS to style the items -->
<style>
    h2 {
        border-bottom: 1px solid #dfdfdf;
        margin-bottom: 30px;
        padding-bottom: 5px;
        font-family: LearnosityMath, 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #222;
    }
    .print-container {
        padding-left: 5px;
        position: relative;
    }
    /* Just to give padding between each question for screens */
    .learnosity-item {
        padding-bottom: 50px;
    }
    @media print {
        .page-break {
            display: block;
            page-break-before: always;
        }
        .lrn.lrn-assess .lrn-region-group {
           display: block;
        }
        /* Uncomment if you want to hide the question type headings */
        /*.item-container h2 {
            display: none;
        }*/
    }
</style>

</body>
</html>
