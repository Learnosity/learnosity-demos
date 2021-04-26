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

$session_id = Uuid::generate();

//labels taken from shared label ressource (i18n demo)
$baseRepoUrl = 'https://raw.githubusercontent.com/Learnosity/learnosity-i18n/master/languages/';

$assessLabels = '[]';
$questionsLabels = '[]';

$url = $baseRepoUrl . 'ja-JP' . '/label_bundles/';
$assessLabels = file_get_contents($url . '/assess-api.json');
$questionsLabels = file_get_contents($url . "/questions-api.json");

$request = array(
    'user_id'        => 'demo_student',
    'rendering_type' => 'assess',
    'name'           => 'Learnosity Japanese Demo',
    'state'          => 'initial',
    'activity_id'    => 'japanese-demo',
    'activity_template_id' => 'jp-demo',
    'session_id'     => $session_id,
    'type'           => 'submit_practice',
    'assess_inline'  => true,
    'config' => array(
        'navigation' => array(
            'show_accessibility' => array(
                'show_colourscheme' => true,
                'show_fontsize' => true,
                'show_zoom' => true
            ),
            'scroll_to_top'            => false,
            'scroll_to_test'           => false,
            'show_configuration'       => false,
            'show_fullscreencontrol'   => true,
            'show_progress'            => true,
            'show_submit'              => true,
            'show_calculator'          => false,
            'show_itemcount'           => true,
            'skip_submit_confirmation' => true,
            'warning_on_change'        => false,
            'scrolling_indicator'      => false,
            'show_answermasking'       => true,
            'show_acknowledgements'    => true
        ),
        'ui_style'            => 'main',
        'configuration' => array(
            'lazyload'               => false,
            'onsubmit_redirect_url' => 'report.php?session_id=' . $session_id
        ),
        'time' => array(
            'show_time'  => true,
            'show_pause' => true,
            'max_time'   => 1500,
            'warning_time' => 10,
            'limit_type'   => 'soft'
        ),
        'title' => '日本語の披露',
        'subtitle' => '桐生一馬',
        'labelBundle' => json_decode($assessLabels, true),
        'questions_api_init_options' => [
            'labelBundle' => json_decode($questionsLabels, true),
            'beta_flags' => [
                'reactive_views' => true
            ]
        ],
    )
);


$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview" aria-label="Preview API Initialisation Object"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/articles/360000758697-Internationalizing-and-Localizing-the-Assessment-Experience" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Japanese Demo</h1>
        <p>This demostrates the Learnosity approach to internationalisation of labels and text rendered by the API UI.</p>
        <p>The demo starts with an assessment rendered through Items API (assess) and then the responses review using Reports API. Everything is localised to the Japanese language using label bundles.</p>
    </div>
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
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
