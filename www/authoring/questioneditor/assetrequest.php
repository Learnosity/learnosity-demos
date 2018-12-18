<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API V3</h1>
        <p>The Question Editor API can be extended to tie seamlessly in with your existing Digital Asset Management System.<p>
    </div>
</div>

<!--
********************************************************************
*
* Nav for different Question Editor API examples
*
********************************************************************
-->
<div class="section">
    <!-- Container for the question editor api to load into -->
    <script src="<?php echo $url_questioneditor; ?>"></script>
    <div class="learnosity-question-editor"></div>
</div>
<script>
    /********************************************************************
    *
    * Set the different initialisation settings based off the
    * example currently being requested
    *
    ********************************************************************/
    var assetRequestFunction = function(mediaRequested, returnType, callback) {
        if (mediaRequested === 'image') {
            var $modal = $('.modal.img-upload'),
            $images = $('.asset-img-gallery img'),
            imgClickHandler = function () {
                if (returnType === 'HTML') {
                    callback('<img src="' + $(this).data('img') + '"/>');
                } else {
                    callback($(this).data('img'));
                }
                $modal.modal('hide');
                $images.off('click', imgClickHandler);
            };
            $images.on('click', imgClickHandler);
            $modal.modal({
                backdrop: 'static'
            })
        }
    };

    var initOptions = {
        "ui": {
            "layout": "2-column"
        },
        "widgetType": "response",
        "widget_json": {
            "type": "imageclozeassociationV2",
            "image": {
                "src": "//upload.wikimedia.org/wikipedia/commons/5/5f/Sydney_1932.jpg",
                "width": 600,
                "height": 400
            },
            "possible_responses": ["North Sydney", "Harbour Bridge", "The Rocks"],
            "response_containers": [{
                "x": 43,
                "y": 46,
                "width": "22%",
                "height": "7%",
                "aria_label": "",
                "pointer": "left"
            }, {
                "x": 12.22,
                "y": 65.2,
                "width": "22%",
                "height": "7%",
                "aria_label": "",
                "pointer": "left"
            }, {
                "x": 45,
                "y": 21,
                "width": "22%",
                "height": "7%",
                "aria_label": "",
                "pointer": "left"
            }]
        },
        "assetRequest": assetRequestFunction
    };

    var questionEditorApp = LearnosityQuestionEditor.init(initOptions);

</script>

<?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
