<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>

<div class="jumbotron section">
    <div class="toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            <li data-toggle="tooltip" data-original-title="Toggle product overview box"><a href="#"><span class="glyphicon glyphicon-chevron-up jumbotron-toggle"></span></a></li>
        </ul>
    </div>
    <div class="overview">
        <h1>Question Editor API V2</h1>
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
            };
            $images.on('click', imgClickHandler);
            $modal.modal({
                backdrop: 'static'
            }).on('hide', function () {
                $images.off('click', imgClickHandler);
            });
        }
    };

    var initOptions = {
        base_question_type: {
            hidden: [
                 "img_src"
            ]
        },
        template_defaults: false,
        widget_json: {
            "type": "imageclozeassociation",
            "image": {
                "src": "//upload.wikimedia.org/wikipedia/commons/5/5f/Sydney_1932.jpg"
            },
            "possible_responses": ["North Sydney", "Harbour Bridge", "The Rocks"],
            "response_container": {"pointer": "left"},
            "response_positions": [{
                "x": 45,
                "y": 42.47
            }, {
                "x": 12.22,
                "y": 64.2
            }, {
                "x": 45,
                "y": 24.94
            }]
        }
        ,
        assetRequest: assetRequestFunction,
        ui: {
            layout: "2-column"
        },
        dependencies: {
            questions_api: {
                init_options: {
                    beta_flags: {
                        reactive_views: true
                    }
                }
            }
        }
    };


    LearnosityQuestionEditor.init(initOptions);

    </script>

    <?php
    include_once 'views/modals/asset-upload.php';
    include_once 'includes/footer.php';
