<!--
********************************************************************
*
* Setup a modal window for the asset handler demo
*
********************************************************************
-->
<style>
    .img-upload .modal-dialog {
        width: 600px;
        padding-top: 200px
    }
</style>

<div class="modal fade img-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to embed this video?</h4>
            </div>
            <div class="modal-body">
                <div class="ck-wrapper">
                    <iframe id="ck-custom-content" width="520" height="293" src="https://www.youtube.com/embed/M3rvLJi2Qu8" frameborder="0"></iframe>
                </div>
                <button id="embed" type="button" class="btn btn-primary">Confirm</button>
                <button id="cancelembed" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
