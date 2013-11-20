<script>
    var activity = <?php echo $output; ?>;
    LearnosityItems.init(activity);
</script>

<div class="modal fade" id="itemsInlineModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Learnosity Item Preview</h4>
            </div>
            <div class="modal-body">
                <?php
                    foreach ($_POST['item_references'] as $item) {
                        echo '<p><span class="learnosity-item" data-reference="' . $item . '"></span></p>';
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
