<!--
********************************************************************
*
* Setup the Items API Settings modal
*
********************************************************************
-->
<?php
    $adaptive = $request['adaptive'];
?>
<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Items API – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frmSettings" method="post">

                    <div class="panel panel-info">
                        <div class="panel-heading">Item Selection Algorithm</div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Initial Ability</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" class="form-control" name="adaptive[initial_ability]" value="<?php echo @$adaptive['initial_ability']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Item Difficulty Tolerance</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" min="0" class="form-control" name="adaptive[item_difficulty_tolerance]" value="<?php echo @$adaptive['item_difficulty_tolerance']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Item Difficulty Offset</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" class="form-control" name="adaptive[item_difficulty_offset]" value="<?php echo @$adaptive['item_difficulty_offset']; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">Expected A Posteriori (EAP) Estimation - <em>(used until a finite MLE estimate is available)</em></div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Mean</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" class="form-control" name="adaptive[eap][mean]" value="<?php echo @$adaptive['eap']['mean']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Standard Deviation</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" min="0" class="form-control" name="adaptive[eap][standard_deviation]" value="<?php echo @$adaptive['eap']['standard_deviation']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Number of points</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="1" min="1" class="form-control" name="adaptive[eap][num_points]" value="<?php echo @$adaptive['eap']['num_points']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Theta Min</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" class="form-control" name="adaptive[eap][theta_min]" value="<?php echo @$adaptive['eap']['theta_min']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Theta Max</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" class="form-control" name="adaptive[eap][theta_max]" value="<?php echo @$adaptive['eap']['theta_max']; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">Termination Criteria</div>
                        <div class="panel-body">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Min Items</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="1" min="1" class="form-control" name="adaptive[termination_criteria][min_items]" value="<?php echo @$adaptive['termination_criteria']['min_items']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">Max Items</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="1" min="1" class="form-control" name="adaptive[termination_criteria][max_items]" value="<?php echo @$adaptive['termination_criteria']['max_items']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="interval" class="col-sm-6 control-label">When Standard Error Falls Below</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.1" min="0" class="form-control" name="adaptive[termination_criteria][error_below]" value="<?php echo @$adaptive['termination_criteria']['error_below']; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise Items API &raquo;</button>
            </div>
        </div>
    </div>
</div>
