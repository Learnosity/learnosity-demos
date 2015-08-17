
<div class="row">
    <div class="col-md-12">
        <p>
            <select id="to-json-fileSelect" class="file-select-row">
                <?php
                foreach ($qtiSampleFileList as $key => $value) {
                    echo '<option value="' . $value . '">' . $key . '</option>';
                }
                ?>
            </select>
            <input style="width: 500px" id="baseAssetsUrl" placeholder="Base asset url, ie. '//s3...com/organisation/1'" type="text"/>
            <button id="to-json-loadFile" type="button" class="btn btn-primary">Load</button>
            <button id="to-json-submit" type="button" class="btn btn-primary">Parse</button>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><span class="label label-default">QTI XML</span></p>
        <div id="to-json-xml-editor" class="qti-xml" name="qtiXML"></div>
    </div>
    <div class="col-md-6">
        <p>
            <span class="label label-default">Render Result</span>
            <span class="validate-response">
                <input type="button" id="validateResponse" value="Validate Question">
            </span>
        </p>

        <div id="errorMsg" class="error-message"></div>
        <div id="render-wrapper"></div>
    </div>
</div>

<div class="row output-json-row">
    <div class="col-md-12">
        <p><span class="label label-default">Exceptions and All Things Ignored</span></p>
        <pre class="clipboard"><code id="errorsJson" class="html"></code></pre>
    </div>
</div>

<div class="row output-json-row" style="display: none">
    <div class="col-md-12">
        <p><span class="label label-default">Questions API Initialisation Options Data</span></p>
        <pre class="clipboard"><code id="outputJson" class="html"></code></pre>
    </div>
</div>

<div class="row output-json-row">
    <div class="col-md-12">
        <p><span class="label label-default">Item Json Data</span></p>
        <pre class="clipboard"><code id="itemOutputJson" class="html"></code></pre>
    </div>
</div>

<div class="row output-json-row">
    <div class="col-md-12">
        <p><span class="label label-default">Questions Json Data</span></p>
        <pre class="clipboard"><code id="questionsOutputJson" class="html"></code></pre>
    </div>
</div>

<script>
    var toJsonXmlEditor = ace.edit("to-json-xml-editor");
    toJsonXmlEditor.getSession().setMode("ace/mode/xml");
    toJsonXmlEditor.getSession().setUseWrapMode(true);
    toJsonXmlEditor.setShowPrintMargin(false);
</script>
<script>
    var questionsApp;
    $(function () {
        $('#to-json-submit').click(function () {
            var baseAssetsUrl = $('#baseAssetsUrl').val();
            $('#errorMsg').html('');
            $('#render-wrapper').html('');
            $.ajax({
                type: "POST",
                url: '?baseAssetsUrl=' + baseAssetsUrl + '&operation=fromqti',
                cache: false,
                data: toJsonXmlEditor.getValue(),
                success: function (data) {
                    try {
                        var result = JSON.parse(data);
                        $('#render-wrapper').html(result.layout);
                        questionsApp = LearnosityApp.init(result.activity);
                        $('#errorsJson').text(JSON.stringify(result.exceptions, null, 4));
                        $('#outputJson').text(JSON.stringify(result.activity, null, 4));
                        $('#itemOutputJson').text(JSON.stringify(result.item, null, 4));
                        $('#questionsOutputJson').text(JSON.stringify(result.questions, null, 4));
                        hljs.initHighlightingOnLoad();
                    } catch (err) {
                        $('#errorMsg').html(data);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $('#to-json-loadFile').click(function () {
            $.ajax({
                type: "POST",
                cache: false,
                data: 'filePath=' + $('#to-json-fileSelect').val(),
                success: function (data) {
                    toJsonXmlEditor.setValue(data);
                }
            });
        });

        $('#validateResponse').click(function () {
            questionsApp.validateQuestions();
        });

    });
</script>

