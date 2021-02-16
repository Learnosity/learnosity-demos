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

<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $service ?> – Failed Submit Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">

                    <div class="panel panel-info">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="mailto" class="col-sm-6 control-label">Mailto</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_failed_options][mailto]" value="true"<?php if (isset($submit_failed_options['mailto']) && $submit_failed_options['mailto'] === true) {
                                            echo ' checked';
                                                                                                                            }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[submit_failed_options][mailto]" value="false"<?php if (isset($submit_failed_options['mailto']) && $submit_failed_options['mailto'] === false) {
                                            echo ' checked';
                                                                                                                             }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="download" class="col-sm-6 control-label">Download</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="configuration[submit_failed_options][download]" value="true"<?php if (isset($submit_failed_options['download']) && $submit_failed_options['download'] === true) {
                                            echo ' checked';
                                                                                                                              }; ?>> Enable &nbsp;
                                        <input type="radio" name="configuration[submit_failed_options][download]" value="false"<?php if (isset($submit_failed_options['download']) && $submit_failed_options['download'] === false) {
                                            echo ' checked';
                                                                                                                               }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="download" class="col-sm-6 control-label">Access a copy of assessment</label>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise <?php echo $service ?> &raquo;</button>
            </div>
        </div>
    </div>
</div>
