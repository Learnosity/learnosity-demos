<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../../lrn_config.php';

?>

<div class="jumbotron section">
    <h1>Case Study – Printing Items</h1>
    <div class="section-intro">
        <p>Sometimes you have a need to print Learnosity items. This could be to to assist in content sign off,
        or you might have students that don't have access to digital devices, so you want to print items
        to be taken offline.</p>
        <p>To render items for printing, a simple way is to use the <a href="http://docs.learnosity.com/assessment/items/quickstart_inline">Items API Inline</a>. Content administrators can then use native browser behaviour to print as a PDF for more flexibility.</p>
        <p>Added to this basic demonstration, are some very basic CSS rules to add page breaks after each question when printing, and to increase the font size to translate items better in print form.</p>
        <p>We also render questions in a <em>preview</em> state (read only) to avoid polluting the final printout.</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Printing Demo</h2>
                </div>
                <div class="panel-body">
                    <p>Uses Items API (inline) to render items for print. In this simple
                    demo we use the following question types:</p>
                    <ul>
                        <li>MCQ
                        <li>MCQ Multi</li>
                        <li>Token highlight</li>
                        <li>Fill in the blanks</li>
                    </ul>
                    <p class="text-right">
                        <a class="demo_link"  href="./print.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Printing Key Answer Demo</h2>
                </div>
                <div class="panel-body">
                    <p>Uses Items API (inline) to render items for print. In this simple
                        demo we use the following question types:</p>
                    <ul>
                        <li>MCQ
                        <li>MCQ Multi</li>
                        <li>Token highlight</li>
                        <li>Fill in the blanks</li>
                    </ul>
                    <p class="text-right">
                        <a class="demo_link"  href="./print-answer-key.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once 'includes/footer.php';
