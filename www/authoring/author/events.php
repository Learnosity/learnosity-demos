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
                'template' => array(
                    'type' => 'feature_question'
                )
            )
        ),
        'dependencies' => array(
            'question_editor_api' => array(
                'init_options' => array(
                    'rich_text_editor' => array(
                        'type' => 'ckeditor'
                    ),
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'source_button'      => false,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => false
                    )
                )
            ),
            'questions_api' => [
                'init_options' => [
                    'beta_flags' => [
                        'reactive_views' => true
                    ]
                ]
            ]
        )
    ),
    'user' => array(
        'id' => 'demos-site',
        'firstname' => 'Test',
        'lastname' => 'Test',
        'email' => 'test@test.com'
    )
);

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authoring/author/publicmethods#on-events" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API</h1>
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
        <p>Below is a demo of event binding using the <a href="http://docs.learnosity.com/authoring/author/publicmethods#on-events">'on' public method</a> to display custom notifications on save events.</p>
    </div>
</div>

<!-- Container for the items api to load into -->
<div class="section">
    <h3>Event binding</h3>
    <hr>
    <label>
        <input type="checkbox" id="prevent_default">
        Prevent default &lsquo;save&rsquo; behaviour
    </label>
    <div id="notifications"></div>
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
    var initOptions = <?php echo $signedRequest; ?>;

    var authorApp = LearnosityAuthor.init(initOptions, {

        readyListener: function () {
            authorApp.on('save', function (event) {
                if (shouldPreventDefault()) {
                    event.preventDefault();
                    showNotification('Prevented saving item')
                } else {
                    showNotification('Saving item')
                }
            });
            authorApp.on('save:success', function (event) {
                showNotification('Saved item');
            });
            authorApp.on('save:error', function (event) {
                showNotification('Failed to save widget of type "' + event.data.json.type + '", because of "' + event.data.error.meta.message + '"');
            });
            authorApp.on('render:item', function () {
                var questionsApp = authorApp.questionsApp();
                var notification = 'Rendered item';

                if(questionsApp){
                    var features = getMappedWidgetData(questionsApp.getFeatures());
                    var questions = getMappedWidgetData(questionsApp.getQuestions());
                    var widgets = features.concat(questions);

                    if (widgets.length) {
                        notification += ' containing ' + widgets.join(', ');
                    }
                }

                showNotification(notification);
            });
        }

    });

    function getMappedWidgetData (widgetCollection) {
        var mapped = [];
        var prop;
        for (prop in widgetCollection) {
            if (widgetCollection.hasOwnProperty(prop)) {
                mapped.push('"' + widgetCollection[prop].type + '"');
            }
        }
        return mapped;
    }

    function showNotification (message) {
        var $message = $('<p/>').text(message);
        var $closeBtn = $('<button/>').attr('type', 'button')
                                      .attr('data-dismiss', 'alert')
                                      .attr('aria-hidden', 'true')
                                      .addClass('close')
                                      .text('×');
        var $notification = $('<div/>').addClass('alert alert-info alert-dismissable')
                                       .append($closeBtn)
                                       .append($message);
        $('#notifications').append($notification);
    }

    function shouldPreventDefault () {
        return $('#prevent_default').is(':checked');
    }
</script>

<?php
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
