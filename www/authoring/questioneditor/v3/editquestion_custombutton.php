<?php

include_once '../../../config.php';
include_once 'includes/header.php';

$request = array(
    'widget_type' => 'response',
    'ui' => array(
        'layout' => array(
            'global_template' => 'edit'
        )
    )
);


$questionImageClozeDropdown = array(
    'stimulus' => 'Name the states',
    'type' => 'imageclozedropdown',
    'image' => array('src' => '//dw6y82u65ww8h.cloudfront.net/demos/docs/blank_us_map.png')
);

// load mcq as default
$request['widget_json'] = $questionImageClozeDropdown;


include_once 'utils/settings-override.php';

$signedRequest = array_merge_recursive(array(), $request);

// remove variable for demo page internal use.
unset($signedRequest['question_type']);

$signedRequest = json_encode($signedRequest);

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Customise API Settings"><a href="#" class="text-muted"
                                                                                          data-toggle="modal"
                                                                                          data-target="#settings"><span
                            class="glyphicon glyphicon-list-alt"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"
                                                                                                     data-toggle="modal"
                                                                                                     data-target="#initialisation-preview"><span
                            class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a
                        href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span
                            class="glyphicon glyphicon-book"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span
                            class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h1>Question Editor API V3 – Edit Question</h1>

            <p>Setup the Question Editor to directly load a question, bypassing the question tiles screen. For more information refer to <a href="http://docs.learnosity.com/authoring/questioneditor/v3/initialisation#widget_json">the init options docs</a> and <a href="http://docs.learnosity.com/authoring/questioneditor/v3/publicmethods#setWidget">the setWidget</a> public method.<p>

            <p>
        </div>
    </div>

    <div class="section">

        <!-- Container for the question editor api to load into -->
        <script src="<?php echo $url_questioneditor_v3; ?>"></script>
        <div class="my-question-editor"></div>
    </div>
    <script>

        var initOptions = JSON.parse(<?php echo json_encode($signedRequest)?>);
            initOptions.rich_text_editor = {
                type: 'ckeditor',
                customButtons: [{
                    name: 'custombutton1',
                    label: 'youtube',
                    icon: 'http://itubepk.com/themes/ytspace/images/favicon.png',
                    func: function(attribute, callback) {
                        var $modal = $('.modal.img-upload'),
                            $embedButton = $('button#embed'),
                            $customContent;

                        buttonClickHandler = function () {
                                $customContent = $('#ck-custom-content').prop('outerHTML');
                                $modal.modal('hide');
                                return callback($customContent);
                        };

                        $embedButton.unbind('click');
                        $embedButton.on('click', buttonClickHandler);

                        $modal.modal({
                            backdrop: 'static'
                        });

                    },
                    attributes: ['stimulus']
                },{
                    name: 'custombutton2',
                    label: 'evernote',
                    icon: 'http://tidbits.com/images/favicons/evernote.png',
                    func:  function(attribute, callback) {
                        return callback('Evernote');
                    },
                    attributes: ['stimulus', 'metadata.distractor_rationale']
                }
                ]
            };

        var qeApp = LearnosityQuestionEditor.init(initOptions, '.my-question-editor');
    </script>

<?php
include_once 'views/modals/settings-questioneditor-v3.php';
include_once 'views/modals/initialisation-preview.php';
include_once 'views/modals/youtube-embed.php';
include_once 'includes/footer.php';
