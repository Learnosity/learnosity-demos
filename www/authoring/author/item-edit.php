<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$item_ref = Uuid::generate();

$security = array(
    'consumer_key' => $consumer_key,
    'domain'       => $domain
);

$request = array(
    'mode'      => 'item_edit',
    'reference' => $item_ref,
    'config'    => array(
        'item_edit' => array(
            'item' => array(
                'columns' => true,
                'save' => true,
                'status' => false,
                'reference' => array(
                    'edit' => false,
                    'show' => false
                ),
                'mode' => array(
                    'default' => 'edit',
                    'show' => true
                )
            ),
            'widget' => array(
                'delete' => true,
                'edit' => true
            )
        ),
        'widget_templates' => array(
            'back' => true,
            'save' => true,
            'widget_types' => array(
                'default' => 'questions',
                'show' => true,
            ),
        ),
        'dependencies' => array(
            'question_editor_api' => array(
                'version' => $version_questioneditorapi,
                'init_options' => array(
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'source_button'      => false,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => true,
                        'layout' => array(
                            'global_template' => 'edit'
                        )
                    )
                )
            )
        )
    ),
    'user' => array(
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    )
);

include_once 'utils/settings-override.php';

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API – Item Edit</h1>
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
        <p>Below is demo of the Author API editing a new item each time, questions and features can be created or edited and are persisted to your Learnosity hosted item bank.</p>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>,
        eventOptions = {
            readyListener: init
        },
        authorApp = LearnosityAuthor.init(initOptions, eventOptions);

    function init () {
        /*
         * On save(), validate the `Lexile` and `Flesch Kincaid`
         * values for the Shared Passage feature type.
         */
        authorApp.on('save', function (evt) {
            if (!validateReadabilityMeasures(evt.data)) {
                evt.preventDefault();
                // Rough validation on the Lexile/Flesch Kincaid values
                alert('Invalid value for Lexile and/or Flesch Kincaid');
            }
        });
    }

    /*
     * For shared passages, Lexile must be a whole number
     * and Flesch Kincaid must be a whole number or a float
     */
    function validateReadabilityMeasures (widget) {
        var isValid = true;

        if (widget.type === 'sharedpassage') {
            if (typeof widget.data.metadata !== 'undefined' && typeof widget.data.metadata.flesch_kincaid !== 'undefined') {
                isValid = (/^[0-9.]+$/.test(+widget.data.metadata.flesch_kincaid));
            }
            if (isValid && (typeof widget.data.metadata !== 'undefined' && typeof widget.data.metadata.lexile !== 'undefined')) {
                isValid = (/^\d+$/.test(+widget.data.metadata.lexile));
            }
        }

        return isValid;
    }
</script>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
