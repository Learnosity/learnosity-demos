<!--
********************************************************************
*
* Setup the Items API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $submit_failed_options  = $request['config']['configuration']['submit_failed_options'];

    $service = 'Items API';
    $serviceShortcut = 'items';
?>

<div class="modal fade" id="settings" tabindex="-1" aria-labelledby="settings-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="settings-title"><?php echo $service ?> – Failed Submit Settings</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">

                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label for="mailto" class="col-sm-6 col-form-label">Mailto</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_failed_options][mailto]" value="true"<?php if (isset($submit_failed_options['mailto']) && $submit_failed_options['mailto'] === true) {
                                            echo ' checked';
                                                                                                                            }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[submit_failed_options][mailto]" value="false"<?php if (isset($submit_failed_options['mailto']) && $submit_failed_options['mailto'] === false) {
                                            echo ' checked';
                                                                                                                             }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="download" class="col-sm-6 col-form-label">Download</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_failed_options][download]" value="true"<?php if (isset($submit_failed_options['download']) && $submit_failed_options['download'] === true) {
                                            echo ' checked';
                                                                                                                              }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[submit_failed_options][download]" value="false"<?php if (isset($submit_failed_options['download']) && $submit_failed_options['download'] === false) {
                                            echo ' checked';
                                                                                                                               }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="download" class="col-sm-6 col-form-label">Access a copy of assessment</label>
                                    <div class="col-sm-6">
                                        This is the default option and cannot be turned off
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
