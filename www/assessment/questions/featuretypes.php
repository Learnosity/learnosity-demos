<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/questionsapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Questions API – Feature Types</h1>
    <p>This Demo shows the different Feature Types which are available in the <b>Questions API</b>. These are generally used as stimulus for questions.<p>
</div>

<!-- Container for the questions api to load into -->
<script src="//questions.learnosity.com"></script>
<script>
    LearnosityApp.init();
</script>

<div class="section">
    <!-- Main question content below here: -->
    <h2 class="page-heading">Feature Types Demos</h2>

    <section>
        <h3 id="audioplayer">Audio Player</h3>
        <h4>Example (Block Player)</h4>
        <span class="learnosity-feature" data-type="audioplayer" data-src="//dw6y82u65ww8h.cloudfront.net/organisations/1/codie_award.mp3" data-waveform="//dw6y82u65ww8h.cloudfront.net/organisations/1/codie_award.png"></span>
        <br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="audioplayer" data-src="audio-source.mp3" data-waveform="//dw6y82u65ww8h.cloudfront.net/demos/docs/waveform.png"&gt;&lt;/span&gt;</pre>
        <hr />
    </section>

    <section>
        <h4>Example (Bar Player)</h4>
        <span class="learnosity-feature" data-type="audioplayer" data-player="bar" data-src="//dw6y82u65ww8h.cloudfront.net/organisations/1/codie_award.mp3"></span>
        <br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="audioplayer" data-player="bar" data-src="audio-source.mp3"&gt;&lt;/span&gt;</pre>
        <hr />
    </section>

    <section>
        <h4>Example (Minimal Player)</h4>
        <span class="learnosity-feature" data-type="audioplayer" data-player="minimal" data-src="//dw6y82u65ww8h.cloudfront.net/organisations/1/codie_award.mp3"></span>
        <br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="audioplayer" data-player="minimal" data-src="audio-source.mp3"&gt;&lt;/span&gt;</pre>
        <hr />
    </section>

    <section>
        <h3 id="videoplayer">Video Player</h3>
        <h4>Example (with embedded youtube video)</h4>
        <span class="learnosity-feature" data-type="videoplayer" data-src="https://www.youtube.com/watch?v=OqsLA2U3d54&list=UU5m6XDcZUU2GCX4uQQSxBVg"></span>
        <br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="videoplayer" data-src="https://www.youtube.com/watch?v=OqsLA2U3d54&list=UU5m6XDcZUU2GCX4uQQSxBVg"&gt;&lt;/span&gt;</pre>
        <hr />
    </section>

    <section>
        <h3 id="calculator">Calculator</h3>
        <h4>Example (Basic)</h4>
        <span class="learnosity-feature" data-type="calculator"></span>
        <br /><br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="calculator"&gt;&lt;/span&gt;</pre><br />
        <h4>Example (Scientific)</h4>
        <span class="learnosity-feature" data-type="calculator" data-mode="scientific"></span>
        <br /><br />
        <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="calculator" data-mode="scientific"&gt;&lt;/span&gt;</pre>
        <hr />
    </section>

    <section>
        <h3 id="imagetool">Image Tool</h3>
        <h4>Example (Protractor)</h4>
        <span class="learnosity-feature" data-type="imagetool" data-image="protractor"></span>
        <pre style="margin-top:220px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="imagetool" data-image="protractor"&gt;&lt;/span&gt;</pre>
        <br>
        <h4>Example (Ruler 6 inches)</h4>
        <span class="learnosity-feature" data-type="imagetool" data-image="ruler-6-inches"></span>
        <pre style="margin-top: 70px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="imagetool" data-image="ruler-6-inches"&gt;&lt;/span&gt;</pre>
        <br>
        <h4>Example (Ruler 15 cm with button to launch)</h4>
        <span class="learnosity-feature" data-type="imagetool" data-image="ruler-15-cm" data-button="true"></span>
        <pre style="margin-top: 20px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="imagetool" data-image="ruler-15-cm" data-button="true"&gt;&lt;/span&gt;</pre>
    </section>

    <section>
        <h3 id="formulainput">Formula Input</h3>
        <h4>Example (Basic)</h4>
        <span class="learnosity-feature" data-type="formulainput"></span>
        <pre style="margin-top: 20px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="formulainput"&gt;&lt;/span&gt;</pre>
        <br>
        <h4>Example (Initial value)</h4>
        <span class="learnosity-feature" data-type="formulainput" data-value="\frac{x}{y}"></span>
        <pre style="margin-top: 20px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="formulainput" data-value="\frac{x}{y}"&gt;&lt;/span&gt;</pre>
        <br>
        <h4>Example (Updating input value)</h4>
        <span class="learnosity-feature" data-type="formulainput" data-input=".math-receiver"></span>
        <input class="math-receiver">
        <pre style="margin-top: 20px" class="feature htmlexample">
&lt;span class="learnosity-feature" data-type="formulainput" data-input=".math-receiver"&gt;&lt;/span&gt;
&lt;input class="math-receiver"&gt;&lt;/input&gt;</pre>
    </section>

</div>

<script src="<?php echo $env['www'] ?>static/js/codemirror.min.js"></script>
<script src="<?php echo $env['www'] ?>static/js/underscore.min.js"></script>
<script src="<?php echo $env['www'] ?>static/js/initCodeMirror.js"></script>

<?php
    include_once 'includes/footer.php';
