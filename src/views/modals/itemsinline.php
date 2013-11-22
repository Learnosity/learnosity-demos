<script>
    var activity = <?php echo $output; ?>;
    <?php if (count($_POST['item_references'])) { ?>
        LearnosityItems.init(activity);
    <?php } ?>
</script>

<div class="modal fade" id="itemsInlineModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Preview content embedded with items</h4>
            </div>
            <div class="modal-body">
                <?php echo $content; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
