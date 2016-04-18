<?php
include_once '../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <h1>Security Check</h1>
    <div class="section-intro">
        <p>This is a simple security test that attempts to make a request to the Questions API,
        passing the security parameters you provide in the form below.</p>
        <p>If the request is successful, a status code 200 will be returned in the box at the
        bottom of the page, otherwise a status code 403 will be returned.</p>
        <p>Information on security is available on the documentation site for
        the <a href="http://docs.learnosity.com/questionsapi/security.php">Questions API</a>.</p>
    </div>

    <form id="securityForm">
        <fieldset>
            <div class="row">
                <div class="col-lg-6">
                    <h2>Security Parameters</h2>
                    <label for="consumer_key">consumer_key:</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="text" id="consumer_key" name="consumer_key" value="" class="signaturePart form-control">
                            </div>
                        </div>
                        <div class="help-block">
                            Unique id provided by Learnosity that allows the server to identify the
                            client and retrieve its <em>consumer_secret</em>.
                        </div>
                    </div>

                    <label for="domain">domain:</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="text" id="domain" name="domain" value="" class=" signaturePart form-control">
                            </div>
                        </div>
                        <div class="help-block">
                            Must be the same as <em>location.hostname</em>, as the Learnosity Questions API is sending
                            that value to the server for authentication.
                        </div>
                    </div>

                    <label for="timestamp">timestamp:</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="text" id="timestamp" name="timestamp" value="" class="span4 signaturePart form-control">
                            </div>
                        </div>
                        <div class="help-block">
                            Current time in GMT/UTC.The server will check if the timestamp is within the allowed
                            time frame: 3h in this test.
                        </div>
                    </div>

                    <label for="user_id">user_id:</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="text" id="user_id" name="user_id" value="" class="span4 signaturePart form-control">
                            </div>
                        </div>
                        <div class="help-block">The id of the student/user whose assets are to be requested.</div>
                    </div>

                    <label for="consumer_secret">consumer_secret:</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-8">
                                <input type="text" id="consumer_secret" name="consumer_secret" value="" class="signaturePart form-control">
                            </div>
                        </div>
                        <div class="help-block">
                            Secret key supplied by Learnosity, which <strong>must not be exposed</strong>
                            either by sending it to the browser or across the network.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <h3>Sample Activity JSON object</h3>
                        <pre id="actJson" class="cm-s-elegant"></pre>
                    </div>
                    <label for="domain"><strong>domain override:</strong></label>
                    <div class="form-group">
                        <input type="text" id="domain_override" name="domain" value="" class="signaturePart form-control">
                    </div>
                    <span class="help-block">
                        Override the <em>window.location</em> comparison. This domain must be registered
                        with Learnosity against the <em>consumer_key</em> being used.
                    </span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <label for="signature">concatenated string:</label>
                    <div class="input">
                        <pre id="concatenation"></pre>
                        <span class="help-block">
                            Concatenation of the above parameters in order, separated by underscores.
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <label for="signature">signature:</label>
                    <div class="form-group">
                        <input type="text" id="signature" name="signature" value="" class="col-lg-12 form-control">
                        <span class="help-block">
                            64 character long string, resulting from applying the SHA256 hashing algorithm
                            to the concatenated string.
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="col-lg-12">
                <button class="btn btn-primary" id="testbtn">Test</button>
                <button class="btn btn-default" id="resetbtn">Reset to Defaults</button>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <h3>Server Response</h3>
                    <pre id="serverresponse"></pre>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script src="<?php echo $env['www'] ?>static/vendor/require/require.js"></script>
<script>
    var LearnosityAmd = {
            requirejs: requirejs,
            require: require,
            define: define
        },
        timestamp = '<?php echo gmdate('Ymd-Hi'); ?>';

    injectCodeMirrorCss();

    function injectCodeMirrorCss() {
        var $head = $('head');
        var $codeMirrorCss = $head.find('link[href=\'../../static/vendor/codemirror/codemirror.css\']');

        if ($codeMirrorCss.length) {
            return;
        }

        var $headlinklast = $head.find('link[rel=\'stylesheet\']:last');
        var linkElement = '<link rel=\'stylesheet\' href=\'../../static/vendor/codemirror/codemirror.css\' type=\'text/css\' media=\'screen\'>';
        if ($headlinklast.length){
           $headlinklast.after(linkElement);
        }
        else {
           $head.append(linkElement);
        }
    }
</script>

<script src="<?php echo $env['www'] ?>static/js/sha256.js"></script>
<script src="<?php echo $env['www'] ?>static/js/securityCheck.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/underscore.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/codemirror/codemirror.min.js"></script>
<script src="<?php echo $env['www'] ?>static/vendor/beautify.js"></script>

<?php include_once 'includes/footer.php';
