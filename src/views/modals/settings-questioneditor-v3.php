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

<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="settings-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="settings-title"><?php echo $service ?> – Custom Settings</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">
                    <input type="hidden" name="widget_type" value="response">

                    <div class="card">
                        <div class="card-header"><h3>Basic Settings</h3></div>
                        <div class="card-body">
                            <div class="col-lg-6">
                                <!-- <div class="form-group row">
                                    <label for="widget_type" class="col-sm-6 col-form-label">Editor Type</label>
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
                                <div id="question_type_wrapper" class="form-group row">
                                    <label for="widget_type" class="col-sm-6 col-form-label">Question Type </label>
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
                                <div class="form-group row">
                                    <label for="layout" class="col-sm-6 col-form-label">Layout</label>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise <?php echo $service ?> &raquo;</button>
            </div>
        </div>
    </div>
</div>

<script src="/static/vendor/html5sortable/jquery.sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // The #widget_type select is commented out in the markup above, so this is
        // normally absent. jQuery's $('#widget_type').change(...) was a silent no-op
        // on an empty selection; guard for the same behaviour.
        const widgetType = document.getElementById('widget_type');
        const wrapper = document.getElementById('question_type_wrapper');

        if (!widgetType || !wrapper) {
            return;
        }

        const syncVisibility = () => {
            wrapper.style.display = widgetType.value === 'response' ? '' : 'none';
        };

        widgetType.addEventListener('change', syncVisibility);
        syncVisibility();
    });
</script>
