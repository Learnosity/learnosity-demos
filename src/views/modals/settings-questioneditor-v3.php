<!--
********************************************************************
*
* Setup the Question Editor API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $base  = isset($request['base_question_type']) ? $request['base_question_type'] : [];
    $ui = $request['ui'];
    $layout = isset($request['ui']) ? $request['ui']['layout'] : [];
    $service = 'Question Editor API';
    $serviceShortcut = 'questioneditorV3';
?>

<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $service ?> – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">
                    <input type="hidden" name="widget_type" value="response">

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Basic Settings</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <!-- <div class="form-group">
                                    <label for="widget_type" class="col-sm-6 control-label">Editor Type</label>
                                    <div class="col-sm-6">
                                        <select id="widget_type" name="widget_type">
                                            <option value="response"<?php if (isset($request['widget_type']) && $request['widget_type'] === 'response') {
                                                echo ' selected';
                                                                    }; ?>>Questions</option>
                                            <option value="feature"<?php if (isset($request['widget_type']) && $request['widget_type'] === 'feature') {
                                                echo ' selected';
                                                                   }; ?>>Features</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div id="question_type_wrapper" class="form-group">
                                    <label for="widget_type" class="col-sm-6 control-label">Question Type </label>
                                    <div class="col-sm-6">
                                        <select id="question_type" name="question_type">
                                            <option value="mcq"<?php if (isset($request['question_type']) && $request['question_type'] === 'mcq') {
                                                echo ' selected';
                                                               }; ?>>MCQ Standard</option>
                                            <option value="mcq-block"<?php if (isset($request['question_type']) && $request['question_type'] === 'mcq-block') {
                                                echo ' selected';
                                                                     }; ?>>MCQ Block UI</option>
                                            <option value="choicematrix"<?php if (isset($request['question_type']) && $request['question_type'] === 'choicematrix') {
                                                echo ' selected';
                                                                        }; ?>>Choice Matrix</option>
                                            <option value="association"<?php if (isset($request['question_type']) && $request['question_type'] === 'association') {
                                                echo ' selected';
                                                                       }; ?>>Association</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="layout" class="col-sm-6 control-label">Layout</label>
                                    <div class="col-sm-6">
                                        <select id="layout" name="ui[layout]">
                                            <option value="edit"<?php if (isset($layout['global_template']) && $layout['global_template'] === 'edit') {
                                                echo ' selected';
                                                                }; ?>>Edit</option>
                                            <option value="edit_preview"<?php if (isset($layout['global_template']) && $layout['global_template'] === 'edit_preview') {
                                                echo ' selected';
                                                                        }; ?>>Edit with Preview</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise <?php echo $service ?> &raquo;</button>
            </div>
        </div>
    </div>
</div>

<script src="/static/vendor/html5sortable/jquery.sortable.min.js"></script>
<script>
    $(function () {
        $('#widget_type').change(function () {
            if ($(this).val() !== 'response') {
                $('#question_type_wrapper').hide();
            } else {
                $('#question_type_wrapper').show();
            }
        });

        $('#widget_type').trigger('change');
    });
</script>
