<!--
********************************************************************
*
* Setup a modal window to preview the API initialisation JSON
*
********************************************************************
-->
<div class="modal preview-fade preview" id="initialisation-preview" tabindex="-1" aria-labelledby="initialisation-preview-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="initialisation-preview-title">API Initialization Preview</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre><code id="preview-body"></code></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php

use LearnositySdk\Utils\Json;

if (!isset($signedRequest)) {
    die('Make sure you call your PHP var $signedRequest for initialisation preview to work');
}
$previewObject = is_array($signedRequest) ? json_decode($signedRequest, true) : $signedRequest;
if (is_array($previewObject)) {
    if (isset($previewObject['request']['api_type'])) {
        unset($previewObject['request']['api_type']);
    } elseif (isset($previewObject['request']['config']['api_type'])) {
        unset($previewObject['request']['config']['api_type']);
    }
    if (array_key_exists('security', $previewObject)) {
        $previewBody = '{"security": ' . Json::encode($previewObject['security']) . ', "request": ' . Json::encode($previewObject['request']) . '}';
    } else {
        $previewBody = Json::encode($previewObject);
    }
} else {
    $previewBody = $previewObject;
}
?>

<script>
    var init = <?php echo $previewBody; ?>;
    delete init.api_type;
    document.getElementById('preview-body').innerHTML = prettyPrint.render(init);
</script>
