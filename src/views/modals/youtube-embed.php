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
                    <iframe id="ck-custom-content" width="520" height="293" src="https://www.youtube.com/embed/8ejKWAP5vCU" frameborder="0"></iframe>
                </div>
                <button id="embed">Confirm</button>
            </div>
        </div>
    </div>
</div>
