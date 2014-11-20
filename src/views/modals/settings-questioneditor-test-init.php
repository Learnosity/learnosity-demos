<!--
********************************************************************
*
* Add JSON to test the initialisation settings for the Question Editor API
*
********************************************************************
-->
<?php
    $service = 'Question Editor API';
    $serviceShortcut = 'questioneditor-test-init';
?>

<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $service ?> – JSON Initialisation Settings</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="frmSettings" method="post">
                    <input type="hidden" name="api_type" value="<?php echo $serviceShortcut ?>">
                    <input type="hidden" name="init" id="init" value="">

                    <div class="panel panel-info">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div id="editor"><?php echo htmlspecialchars($request);?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Initialise <?php echo $service ?> &raquo;</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $env['www'] ?>static/vendor/ace/ace-builds/src-min-noconflict/ace.js"></script>
<script>
    var editor = ace.edit('editor'),
        $wrapper = $('.editor-wrapper');
    editor.setTheme('ace/theme/kuroir');
    editor.getSession().setMode('ace/mode/json');
    editor.setShowPrintMargin(false);
    editor.setOptions({
        maxLines: 25
    });
    editor.navigateFileEnd();
    editor.focus();

    function reInit (init) {
        //$($wrapper).find('.learnosity-question-editor').remove();
        //$($wrapper).append('<div class="learnosity-question-editor"></div>');
        LearnosityQuestionEditor.init(init);
        $('#settings').modal('hide');
    }

    $(function() {
        $('.btn-primary').on('click', function () {
            $('#init').val(editor.getValue());
            //$('#frmSettings').submit();
            reInit(JSON.parse(editor.getValue()));
        });
    });
</script>
