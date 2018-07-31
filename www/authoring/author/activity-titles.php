<?php

include_once '../../config.php';
include_once 'includes/header.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];

$request = [
    'mode'      => 'activity_list',
    'config'    => [
        'activity_edit' => [
            'source' => true,
            'back' => true,
            'save' => [
                'show' => true,
                'persist' => true,
            ],
            'mode' => [
                'show' => true,
                'default' => 'edit',
            ],
            'reference' => [
                'show' => true,
                'edit' => true
            ],
            'item_search' => [
                'filter' => [
                    'restricted' => [
                        'tags' => [
                            'all' => [
                                [
                                    "type" => "subject",
                                    "name" => "english"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'title' => [
                'show' => true,
                'edit' => true
            ]
         ],
        'activity_list' => [
            'toolbar' => [
                'add' => true,
                'search' => true
            ],
            'status' => true,
            'limit' => 10,
            'title' => [
                'show' => true
            ]
        ],
        'dependencies' => [
            'questions_api' => [
                'init_options' => [
                    'beta_flags' => [
                        'reactive_views' => true
                    ]
                ]
            ],
            'question_editor_api' => array(
                'init_options' => array(
                    'rich_text_editor' => array(
                        'type' => 'ckeditor'
                    ),
                    'label_bundle' => array(
                        'stimulus' => 'Compose question'
                    ),
                    'ui' => array(
                        'public_methods'     => array(),
                        'question_tiles'     => false,
                        'documentation_link' => false,
                        'change_button'      => true,
                        'help_button'        => true,
                        'source_button'      => true,
                        'fixed_preview'      => true,
                        'advanced_group'     => false,
                        'search_field'       => true,
                        'layout'             => array(
                            'global_template' => 'edit_preview'
                        )
                    )
                )
            )
        ]
    ],
    'user' => [
        'id'        => 'demos-site',
        'firstname' => 'Demos',
        'lastname'  => 'User',
        'email'     => 'demos@learnosity.com'
    ]
];


include_once 'utils/settings-override.php';

$Init = new Init('author', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted" data-toggle="modal" data-target="#settings"><span class="glyphicon glyphicon-list-alt"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/authoring/author/initialization#config_activity_list_filter" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Author API – Activity List</h1>
    </div>
</div>

<div class="section pad-sml">
    <!-- Container for the author api to load into -->
    <div id="learnosity-author"></div>
</div>

<script src="<?php echo $url_authorapi; ?>"></script>
<script>
var eventOptions = {
        readyListener: init
};
var initOptions = <?php echo $signedRequest; ?>;
var authorApp = LearnosityAuthor.init(initOptions, eventOptions);

function init () {
    authorApp.on('all', function (event, eventData) {
        console && console.log(event + ' => ' + JSON.stringify(eventData.data));
    });
}
</script>

<?php
    include_once 'views/modals/settings-content-author.php';
    include_once 'views/modals/initialisation-preview.php';
    include_once 'includes/footer.php';
