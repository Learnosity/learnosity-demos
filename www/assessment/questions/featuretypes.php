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
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="./../items/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the questions api to load into -->
<script src="http://questions.learnosity.com"></script>
<script>
    LearnosityApp.init();
</script>

<!-- Main question content below here: -->
<h2 class="page-heading">Feature Types Demos</h2>

<section>
    <h3 id="audioplayer">Audio Player</h3>
    <h4>Example</h4>
    <span class="learnosity-feature" data-type="audioplayer" data-src="http://assets.learnosity.com/demos/docs/audiofeaturedemo.mp3" data-waveform="http://assets.learnosity.com/demos/docs/waveform.png"></span>
    <br />
    <hr />
</section>

<section>
    <h3 id="videoplayer">Video Player</h3>
    <h4>Example (with embedded youtube video)</h4>
    <span class="learnosity-feature" data-type="videoplayer" data-src="http://www.youtube.com/watch?feature=player_detailpage&v=flL7M36QszA"></span>
    <br />
    <hr />
</section>

<section>
    <h3 id="calculator">Calculator</h3>
    <h4>Example (Basic)</h4>
    <span class="learnosity-feature" data-type="calculator"></span></br></br>
    <h4>Example (Scientific)</h4>
    <span class="learnosity-feature" data-type="calculator" data-mode="scientific"></span></br></br>
    <hr />
</section>

<section>
    <h3 id="imagetool">Image Tool</h3>
    <h4 style="margin-bottom:35px">Example (Protractor)</h4>
    <span class="learnosity-feature" data-type="imagetool" data-image="protractor"></span>
    </br>
    <h4 style="margin-top: 200px">Example (Ruler 6 inches)</h4>
    <span class="learnosity-feature" data-type="imagetool" data-image="ruler-6-inches"></span>
    <p style="margin-bottom:80px"></p>
</section>

<?php
    include_once '../../../src/includes/footer.php';
