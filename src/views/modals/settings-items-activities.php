<!--
********************************************************************
*
* Setup the Items API Settings modal for activities
*
********************************************************************
-->
<?php
    $activities = array(
        array('demo-activity-1', 'Demo Activity #1'),
        array('demo-activity-2', 'Demo Activity #2'),
        array('demo-activity-3', 'Demo Activity #3')
    );
?>
<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Items API – Custom Settings</h4>
            </div>
            <div class="modal-body">
                <p>In these examples, all the activity configuration that defines the look and
                feel of the assessment, along with the items to be used are all loaded from the
                Learnosity item bank.</p>
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="items">

                    <div class="panel panel-info">
                        <div class="panel-heading">Activity Settings</div>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="activity_template_id" class="col-sm-6 control-label">Activity Reference</label>
                                    <div class="col-sm-6">
                                        <select id="activity_template_id" name="activity_template_id">
                                            <?php foreach ($activities as $activity) { ?>
                                                <option value=<?php echo '"' . $activity[0] . '"'; if (isset($request['activity_template_id']) && $request['activity_template_id'] === $activity[0]) { echo ' selected'; } ?>><?php echo $activity[1]; ?></option>
                                            <?php } ?>
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
                <button type="button" class="btn btn-primary" onclick="document.getElementById('frmSettings').submit();">Initialise Items API &raquo;</button>
            </div>
        </div>
    </div>
</div>
