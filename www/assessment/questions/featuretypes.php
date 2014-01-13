<?php

include_once '../../../src/includes/header.php';

?>

<div class="jumbotron">
    <h1>Questions API - Feature Types</h1>
    <p>This Demo shows the different Feature Types which are available in the <b>Questions API</b>. These are generally used as stimulus for questions.<p>

    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/questionsapi/featuretypes.php" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="./formula.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the questions api to load into -->
<script src="//questions.learnosity.com"></script>
<script>
    LearnosityApp.init();
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Feature Types Demos</h2>

<section>
    <h3 id="audioplayer">Audio Player</h3>
    <h4>Example</h4>
    <span class="learnosity-feature" data-type="audioplayer" data-src="//dw6y82u65ww8h.cloudfront.net/demos/docs/audiofeaturedemo.mp3" data-waveform="//dw6y82u65ww8h.cloudfront.net/demos/docs/waveform.png"></span>
    <br />
    <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="audioplayer" data-src="audio-source.mp3" data-waveform="//dw6y82u65ww8h.cloudfront.net/demos/docs/waveform.png"&gt;&lt;/span&gt;</pre>
    <hr />
</section>

<section>
    <h3 id="videoplayer">Video Player</h3>
    <h4>Example (with embedded youtube video)</h4>
    <span class="learnosity-feature" data-type="videoplayer" data-src="//www.youtube.com/watch?feature=player_detailpage&v=flL7M36QszA"></span>
    <br />
    <pre class="feature htmlexample">&lt;span class="learnosity-feature" data-type="videoplayer" data-src="//www.youtube.com/watch?feature=player_detailpage&v=flL7M36QszA"&gt;&lt;/span&gt;</pre>
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
    <br/><h4>Example (Ruler 6 inches)</h4>
    <span class="learnosity-feature" data-type="imagetool" data-image="ruler-6-inches"></span>
    <pre style="margin-top: 70px" class="feature htmlexample">&lt;span class="learnosity-feature" data-type="imagetool" data-image="ruler-6-inches"&gt;&lt;/span&gt;</pre>
</section>

<script src="/static/js/codemirror.min.js"></script>
<script src="/static/js/underscore.min.js"></script>
<script src="/static/js/initCodeMirror.js"></script>

<?php
    include_once '../../../src/includes/footer.php';
