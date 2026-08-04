<?php

?>

<script src="/static/vendor/pdf.js/pdf.js"></script>
<script>
var url_pdf = '../samples/rubric_sample_1.pdf';
PDFJS.workerSrc = '/static/vendor/pdf.js/pdf.worker.js';
PDFJS.getDocument(url_pdf).then(function getPdfHelloWorld(pdf) {
    pdf.getPage(1).then(function getPageHelloWorld(page) {
        var scale = 1.5;
        var viewport = page.getViewport(scale);

        //
        // Prepare canvas using PDF page dimensions
        //
        var canvas = document.getElementById('rubric-canvas');
        var context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        //
        // Render PDF page into canvas context
        //
        var renderContext = {
        canvasContext: context,
        viewport: viewport
        };
        page.render(renderContext);
    });
});
</script>

<div class="modal fade" id="rubricViewer" tabindex="-1" aria-labelledby="rubricViewer-title">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="rubricViewer-title">Teacher Rubric</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <canvas id="rubric-canvas"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
