<!--
********************************************************************
*
* Setup a modal window to preview the API initialisation JSON
*
********************************************************************
-->
<div class="modal fade" id="initialisation-preview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">API Initialisation Preview</h4>
            </div>
            <div class="modal-body">
                <pre><code id="preview-body"></code></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    if (!isset($signedRequest)) {
        die('Make sure you call your PHP var $signedRequest for initialisation preview to work');
    }
    $previewObject = is_array($signedRequest) ? json_decode($signedRequest, true) : $signedRequest;
    if (is_array($previewObject)) {
        if (array_key_exists('security', $previewObject)) {
            $previewBody = '{"security": ' . json_encode($previewObject['security']) . ', "request": ' . json_encode($previewObject['request']) . '}';
        } else {
            $previewBody = json_encode($previewObject);
        }
    } else {
        $previewBody = $previewObject;
    }
?>

<script>
    $('#preview-body').html(library.json.prettyPrint(<?php echo $previewBody; ?>));
</script>
