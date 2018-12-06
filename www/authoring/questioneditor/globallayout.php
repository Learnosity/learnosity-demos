<?php

include_once '../../config.php';
include_once 'includes/header.php';

?>
    <link type="text/css" rel="stylesheet" href="css/prettify.css">
    <script src="lib/prettify.js"></script>
    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questioneditorapi/v3" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>

            </ul>
        </div>
        <div class="overview">
            <h1>Question Editor API V3 - Beta</h1>
            <p>Our editor. Your item bank platform. You can customise and pick the right component you want to use easily with our editor's global layout support.<p>
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
        <script src="<?php echo $url_questioneditor_v3; ?>"></script>
        <div class="global-layout-setup row">
            <div>
                <h3>Setup</h3>
                <p>Drag and drop the component views that you want to render from the left column to the template on the right column the click APPLY.</p>
            </div>
            <br/>
            <div class="col-md-6">
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Question/Feature tile list</p>
                        <span class="component-view-data">data-lrn-qe-layout-tile-list</span>
                    </div>
                </div>
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Editing widget title</p>
                        <span class="component-view-data">data-lrn-qe-layout-widget-title</span>
                    </div>
                </div>
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Validate question button</p>
                        <span class="component-view-data">data-lrn-qe-layout-validate-question</span>
                    </div>
                </div>
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Validatable question live score element</p>
                        <span class="component-view-data">data-lrn-qe-layout-live-score</span>
                    </div>
                </div>
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Edit question/feature panel</p>
                        <span class="component-view-data">data-lrn-qe-layout-edit-panel</span>
                    </div>
                </div>
                <div class="component-views">
                    <div class="component-view" draggable="true">
                        <p class="component-view-title">Preview panel</p>
                        <span class="component-view-data">data-lrn-qe-layout-preview-panel</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="place-holder-wrapper">
                    <div class="place-holder">
                        <h5 class="place-holder-title">Block 1</h5>
                    </div>
                    <div class="place-holder">
                        <h5 class="place-holder-title">Block 2</h5>
                    </div>
                    <div class="place-holder">
                        <h5 class="place-holder-title">Block 3</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-info btn-review-global-layout">Review HTML Markup</button>
                <button class="btn btn-primary btn-apply-global-layout">Apply</button>
            </div>
        </div>

        <div class="global-layout-app"></div>
    </div>

    <div class="modal fade qe-global-layout-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Global layout HTML</h4>
                </div>
                <div class="modal-body">
                    <pre class="prettyprint"></pre>
                </div>
            </div>
        </div>
    </div>
<script>
    var initOptions = {
            widgetType: 'response',
            ui: {
                layout: {
                    global_template: 'custom'
                }
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
        },
        qeApp;
    $(function () {
        var $setupView = $('.global-layout-setup'),
            $globalLayoutApp = $('.global-layout-app'),
            $componentViews = $('.component-views'),
            $placeHolders = $('.place-holder'),
            $draggableItems = $componentViews.find('[draggable="true"]'),
            $applyLayoutBtn = $('.btn-apply-global-layout'),
            $reviewLayoutBtn = $('.btn-review-global-layout'),
            $placeHolderWrapper = $('.place-holder-wrapper'),
            $reviewModal = $('.qe-global-layout-modal'),
            $curDraggingItem;

        $draggableItems.on('dragstart', onDrag);

        $placeHolders
            .on('dragover', allowDrop)
            .on('drop', onDrop);
        $componentViews
            .on('dragover', allowDrop)
            .on('drop', onDrop);

        $applyLayoutBtn.on('click', onApplyGlobalLayout);
        $reviewLayoutBtn.on('click', showReviewLayoutModal);

        function onApplyGlobalLayout(evt) {
            var $globalLayoutTpl = $placeHolderWrapper.find('.component-view');
            if ($globalLayoutTpl.length) {
                $globalLayoutTpl = getGeneratedGlobalLayoutTemplate();
                $globalLayoutApp.html($globalLayoutTpl);
                loadQuestionEditor();
            } else {
                alert('Please drag at least 1 global layout template to the layout on the right');
            }
        }

        function showReviewLayoutModal(evt) {
            var content = getGeneratedGlobalLayoutTemplate().html();
            content = content.trim();
            $reviewModal
                .find('.prettyprint')
                .removeClass('.prettyprinted')
                .empty()
                .text(content);
            prettyPrint();
            $reviewModal.modal('show');
        }

        function getGeneratedGlobalLayoutTemplate() {
            var $clone = $placeHolderWrapper.clone();
            $clone.find('.place-holder').each(function () {
                var $this = $(this),
                    $component = $this.find('.component-view'),
                    tpl = '';
                $component.each(function () {
                    var $cp = $(this),
                        name = $cp.find('.component-view-title').text(),
                        attr = $cp.find('.component-view-data').text();
                    tpl += '<div class="component-view-block">\n' +
                        '<h4>' + name + '</h4>\n' +
                        '<div class="component-view-block-content">\n' +
                        '<span ' + attr + '></span>\n' +
                        '</div>\n' +
                        '</div>';
                });
                $component.remove();
                $this.append(tpl);
            });

            return $clone;
        }

        function loadQuestionEditor() {
            qeApp = LearnosityQuestionEditor.init(initOptions);
            $setupView.addClass('hide');
        }

        function onDrag(evt) {
            $curDraggingItem = $(this);
        }

        function onDrop(evt) {
            $(this).append($curDraggingItem);
        }

        function allowDrop(evt) {
            evt.preventDefault();
        }
    });
</script>
<?php
include_once 'views/modals/asset-upload.php';
include_once 'includes/footer.php';
