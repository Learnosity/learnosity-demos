<?php

$request = array(
    'limit' => 10
);

// Override the request packet if a user edited the request form
if (isset($_POST['input-request'])) {
    $request = json_decode($_POST['input-request'], true);
}

$action = 'get';

$RequestHelper = new RequestHelper(
    'data',
    $security,
    $consumer_secret,
    $request,
    $action
);

$signedRequest = $RequestHelper->generateRequest();
$endpoint = 'https://data.learnosity.com/v0.16/users';

// Fire a request to the Data API when the request form
// is submitted
if (isset($_POST['input-request'])) {
    $PostHelper = new PostHelper;
    $result = $PostHelper->execute($endpoint, $signedRequest);
} else {
    $result = '[\'Nothing submitted yet\']';
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-11">

            <ul class="nav nav-tabs" id="nav-dataapi">
                <li><a href="#tab-request-form" data-toggle="tab">Request Form</a></li>
                <li><a href="#tab-request-json" data-toggle="tab">Request JSON</a></li>
                <li><a href="#tab-response" data-toggle="tab">Response</a></li>
            </ul>
            <div class="tab-content">
                <!-- Render the interactive request form -->
                <div class="tab-pane" id="tab-request-form">
                    <form class="form-horizontal" role="form" method="post" id="frm-data-api">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Endpoint URL</label>
                            <div class="col-md-10">
                            <input type="text" class="form-control" id="api-endpoint" data-type="string" placeholder="<?php echo $endpoint; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">limit</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="api-limit" data-type="integer" placeholder="10" min="1" max="1000" value="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">username(s)</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="api-id" data-type="array" placeholder="brianmoser, dextermorgan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">school(s)</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="api-school_id" data-type="array" placeholder="demo_school">
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-md-2 control-label">next page</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="api-next">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-default">POST</button>
                            </div>
                        </div>
                        <input type="hidden" name="input-request" id="input-request" value="">
                    </form>
                </div>
                <!-- Render the raw request json -->
                <div class="tab-pane" id="tab-request-json">
                    <form class="form-horizontal" role="form" method="post" id="frm-data-api">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Endpoint URL</label>
                            <div class="col-md-10">
                                <p class="form-control"><code><?php echo $endpoint; ?></code></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Request JSON</label>
                            <div class="col-md-10">
                                <div id="editor"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-default">POST</button>
                            </div>
                        </div>
                        <input type="hidden" name="input-request" id="input-request" value="">
                    </form>
                </div>
                <!-- Output the response packet -->
                <div class="tab-pane" id="tab-response">
                    <div class="preview">
                        <pre><code id="response"></code></pre>
                    </div>
                    <script>
                        $('#response').html(library.json.prettyPrint(<?php echo $result; ?>));
                    </script>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo $env['www'] ?>static/vendor/ace/ace-builds/src-min-noconflict/ace.js"></script>
<script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var editor = ace.edit('editor');
        editor.setTheme('ace/theme/clouds');
        editor.getSession().setMode('ace/mode/json');
        editor.setValue(JSON.stringify(<?php echo json_encode($request); ?>, null, 2))
        editor.setShowPrintMargin(false);
        $('#frm-data-api').on('submit', function(e) {
            $('#input-request').val(editor.getValue());
        });
    });

    $(function() {
        <?php
            if (isset($_POST['input-request'])) {
                echo '$(\'#nav-dataapi a[href="#tab-response"]\').tab(\'show\');';
            } else {
                echo '$(\'#nav-dataapi a[href="#tab-request-form"]\').tab(\'show\');';
            }
        ?>
    });
</script>
