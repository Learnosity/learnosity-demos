<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section index">
        <h1>Partners</h1>

        <div class="section-intro">
            <p>
            Learnosity’s partners are some of the world’s most innovative edtech companies. 
            <br/>Collaborating in developing, scaling, and delivering exceptional learning products.
            </p>
            <ul>
                <li><h4><a class="blue-chevron" href="#texthelp">TextHelp</a></h4></li>
                <li><h4><a class="blue-chevron" href="#desmos">Desmos</a></h4></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title" id="texthelp">Using Third-Party Assistive Tools: TextHelp</h2>
                    </div>
                    <div class="panel-body">
                        <p>This demonstrates integrating Learnosity with TextHelp. TextHelp's SpeechStream is a cloud-based 
                        JavaScript software solution that allows publishers to embed text-to-speech into their assessment items.</p>
                        <p class="text-right">
                            <a class="demo_link" href="./texthelp.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title" id="desmos">Helping every student love learning math: Desmos</h2>
                    </div>
                    <div class="panel-body">
                        <p>Desmos create best-in-class digital math tools. Through the Desmos and Learnosity partnership, 
                        Learnosity clients can leverage graphing, scientific, and four function calculators.</p>
                        <p class="text-right">
                            <a class="demo_link" href="./desmos.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php include_once 'includes/footer.php';
