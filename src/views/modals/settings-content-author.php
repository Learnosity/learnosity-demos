<!--
********************************************************************
*
* Setup the Author API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $con  = $request['config'];
    $list  = $request['config']['item_list'];
    $edit = $request['config']['item_edit'];
    $mode = $request['mode'];

    $service = 'Author API';
    $serviceShortcut = 'author';
?>

<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $service ?> – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">

                    <?php if ($mode === 'item_list') { ?>
                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Item List</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show item status</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[item][status]" value="true"<?php if (isset($list['item']['status']) && $list['item']['status'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[item][status]" value="false"<?php if (isset($list['item']['status']) && $list['item']['status'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>New Item</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[toolbar][add]" value="true"<?php if (isset($list['toolbar']['add']) && $list['toolbar']['add'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[toolbar][add]" value="false"<?php if (isset($list['toolbar']['add']) && $list['toolbar']['add'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Filter items to current user</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_list[filter][restricted][current_user]" value="true"<?php if (isset($list['filter']['restricted']['current_user']) && $list['filter']['restricted']['current_user'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_list[filter][restricted][current_user]" value="false"<?php if (isset($list['filter']['restricted']['current_user']) && $list['filter']['restricted']['current_user'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Item Edit</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <?php if ($mode === 'item_list') { ?>
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Show <em>Back</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][back]" value="true"<?php if (isset($edit['item']['back']) && $edit['item']['back'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][back]" value="false"<?php if (isset($edit['item']['back']) && $edit['item']['back'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>Columns</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][columns]" value="true"<?php if (isset($edit['item']['columns']) && $edit['item']['columns'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][columns]" value="false"<?php if (isset($edit['item']['columns']) && $edit['item']['columns'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show <em>Save</em> button</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][save]" value="true"<?php if (isset($edit['item']['save']) && $edit['item']['save'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][save]" value="false"<?php if (isset($edit['item']['save']) && $edit['item']['save'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show item reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][reference][show]" value="true"<?php if (isset($edit['item']['reference']['show']) && $edit['item']['reference']['show'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][reference][show]" value="false"<?php if (isset($edit['item']['reference']['show']) && $edit['item']['reference']['show'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Edit item reference</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][reference][edit]" value="true"<?php if (isset($edit['item']['reference']['edit']) && $edit['item']['reference']['edit'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][reference][edit]" value="false"<?php if (isset($edit['item']['reference']['edit']) && $edit['item']['reference']['edit'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Show item status</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[item][status]" value="true"<?php if (isset($edit['item']['status']) && $edit['item']['status'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[item][status]" value="false"<?php if (isset($edit['item']['status']) && $edit['item']['status'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><h3>Widgets</h3></div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="show_intro" class="col-sm-6 control-label">Enable widget edit</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[widget][edit]" value="true"<?php if (isset($edit['widget']['edit']) && $edit['widget']['edit'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[widget][edit]" value="false"<?php if (isset($edit['widget']['edit']) && $edit['widget']['edit'] === false) { echo ' checked'; }; ?>> Disable
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="show_outro" class="col-sm-6 control-label">Enable widget delete</label>
                                    <div class="col-sm-6">
                                        <input type="radio" name="item_edit[widget][delete]" value="true"<?php if (isset($edit['widget']['delete']) && $edit['widget']['delete'] === true) { echo ' checked'; }; ?>> Enable &nbsp;
                                        <input type="radio" name="item_edit[widget][delete]" value="false"<?php if (isset($edit['widget']['delete']) && $edit['widget']['delete'] === false) { echo ' checked'; }; ?>> Disable
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
