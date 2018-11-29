<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <h1><img class="product-logo" src="/static/images/product-assessments.png">Learnosity Assessments</h1>
    <div class="section-intro">
        <p>Learnosity Assessments allow you to access content from Learnosity's Item bank, and deliver content to your end-users either as a full assessment player or embedded into a page as you need, all while capturing student responses and scoring in a scalable, robust manner.</p>
        <p>
        <ul>
            <li><h4><a class="blue-chevron" href="#delivering">Delivering Assessments</a></h4></li>
            <li><h4><a class="blue-chevron" href="#customizing">Customizing behavior</a></h4></li>
        </ul>
        </ul>
        </p>
    </div>

    <h3 id="delivering"><a href="#delivering">Delivering Assessments</a></h3>
    <p>Deliver your learning content how you like it - whether that's through fixed form assessments, individual items embedded throughout your learning content, or using powerful adaptive and branching test formats.</p>
    <br>


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Pre-Written Fixed Form Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>Build fixed-form activities in Learnosity, and deliver high quality pre-authored assessments to your end-users.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./activities.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Mixing Content and Formative Assessment & Learning</h2>
                </div>
                <div class="panel-body">
                    <p>Display items from the Learnosity Item Bank in no time, embedded how you want them.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./inline.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Just-in-Time Fixed Form Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>Build your activities on the fly, and deliver content from your item bank without having to pre-author a fixed-form activity.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./assess.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Branching Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>Use the power of Learnosity's branching assessment format to build an activity that seamlesssly adapts to your user.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./branching.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Item Adaptive (Rasch Model) Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>Using our item adaptive technology, deliver an adaptive test to your student using the power of Learnosity's advanced adaptive engine.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./adaptive.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Mixed Adaptive Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>A dynamic assessment that adapts to the user's ability, choosing which fixed-form testlet to go through next.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./testlet-adaptive.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Fixed Form Assessments with Sections</h2>
                </div>
                <div class="panel-body">
                    <p>Sections are a way to split up a single activity into discrete buckets of items, with the ability to have different activity configuration per section.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./sections.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>




    <h3 id="customizing"><a href="#customizing">Customizing behaviour</a></h3>
    <p>Learnosity's Assessment delivery APIs are designed to be flexible, customizable, and easy to trigger behavior and react to user behavior inside your own platform.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Accessibility controls & Assistive tools</h2>
                </div>
                <div class="panel-body">
                    <p>As well as Learnosity's "behind-the-scenes" functionality to work with screen-readers, braille displays, and keyboard navigation, Learnosity also provides in-built accessibility options which can be configured, extended and set by default.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./accessibility.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Adding Hints & Worked Solutions</h2>
                </div>
                <div class="panel-body">
                    <p>Extend on top of our standard assessments to provide powerful hint and worked solution functionality.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./worked-solutions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Distractor Rationale & Feedback</h2>
                </div>
                <div class="panel-body">
                    <p>Use Learnosity metadata to power distractor rationale for teachers and instructors, or inline student feedback.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./distractors.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Submission retries & response recovery</h2>
                </div>
                <div class="panel-body">
                    <p>Learnosity provides resilience to network issues and disconnections - This demo simulates submitting an activity where the network connection may not be available.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./failed-submission.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Locking Questions</h2>
                </div>
                <div class="panel-body">
                    <p>Learn how to disable questions depending on user behavior (in this case, too many attempts).</p>
                    <p class="text-right">
                        <a class="demo_link" href="./locking-questions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Restricting Responses and Navigation</h2>
                </div>
                <div class="panel-body">
                    <p>Customize the Learnosity experience, by ensuring students have answered the correct number of responses.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./restrict-responses.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Question Indexing in Assessments</h2>
                </div>
                <div class="panel-body">
                    <p>Turn on automatic question numbering for students.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./question-indexing.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Advanced Audio Analysis</h2>
                </div>
                <div class="panel-body">
                    <p>Dive deeper into audio quality, and get the information you need to make sure your students audio is as clear as day!<p>
                    <p class="text-right">
                        <a class="demo_link" href="./audio-advanced.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Running Your Own Math Rendering</h2>
                </div>
                <div class="panel-body">
                    <p>In cases where you have customized your own MathJax rendering, learn how to disable Learnosity's rendering and use your own.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./formulamathjaxcdn.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Assessment Layouts & Regions</h2>
                </div>
                <div class="panel-body">
                    <p>Regions provide a powerful, flexible way to personalize and extend the Assessment player layout.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./regions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Binding to Items API Events</h2>
                </div>
                <div class="panel-body">
                    <p>A demonstration of event binding with the Items API 'on' public method to display custom notifications.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./events.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Annotations Demo</h2>
                </div>
                <div class="panel-body">
                    <p>Annotations API offers students the ability to make notes, add multi color highlights to text, place sticky notes onto the page, and use a pen tool to annotate the content.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./annotations.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Texthelp Demo</h2>
                </div>
                <div class="panel-body">
                    <p>This demo demonstrates integrating Learnosity with Texthelp. Texthelp's SpeechStream is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their assessment items.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./texthelp.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php';
