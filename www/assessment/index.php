<?php

include_once '../env_config.php';
include_once 'includes/header.php';
include_once '../../src/utils/date-gating.php';
?>

<div class="jumbotron section index">
    <h1><img class="product-logo" src="/static/images/product-assessments-full.png" alt="Learnosity Assessment logo"></h1>
    <div class="section-intro">
        <p>Learnosity Assessments allow you to access content from your Learnosity-hosted item bank and deliver that content to your end-users. You can present assessments using a full assessment player or embed each question into a page exactly where you want it to be, all while capturing student responses and scoring in a scalable, robust manner.</p>
        <p>
        <ul>
            <li><a class="blue-chevron" href="#delivering">Delivering Assessments</a></li>
            <li><a class="blue-chevron" href="#customizing">Customizing behavior</a></li>
        </ul>
        </ul>
        </p>
    </div>

    <h2 id="delivering">Delivering Assessments</h2>
    <p>Deliver your learning content how you like it—via fixed form assessments, individual items embedded throughout your editorial, or powerful adaptive and branching test formats.</p>
    <br>


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Build Pre-Written Fixed Form Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>Build fixed-form activities in Learnosity, and deliver high-quality pre-authored assessments to your end-users.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./activities.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Embed Formative Assessment Questions into Editorial Content</h3>
                </div>
                <div class="panel-body">
                    <p>Place questions <i>in context</i> throughout your editorial without the design restrictions of an assessment player. This demo makes use of the <i>inline</i> rendering type.</p>
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
                    <h3 class="panel-title">Generate Just-in-Time Fixed Form Assessments</h3>
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
                    <h3 class="panel-title">Create Branching Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>Use the power of Learnosity's branching assessment format to build an adaptive activity that seamlessly adapts to your user.</p>
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
                    <h3 class="panel-title">Generate Item Adaptive (Rasch Model) Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>Use our item adaptive technology to deliver an adaptive test to your student based on item difficulty level and user ability.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./adaptive.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Build Testlet Adaptive Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>Create adaptive experiences that choose which fixed-form testlet to load at each decision point.</p>
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
                    <h3 class="panel-title">Fixed Form Assessments with Sections</h3>
                </div>
                <div class="panel-body">
                    <p>Divide single assessments into discrete buckets of items, restricting navigation and optionally using different activity configurations for each section.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./sections.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Using Dynamic Content And "Try Again" in Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>This demo showcases the Try Again functionality. Try Again allows students to ask for another set of data for the Question they are attempting.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./try-again.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Delivering STEM Assessments</h3>
                </div>
                <div class="panel-body">
                    <p>This demo showcases how you can assess advanced STEM topics using our new math scoring engine.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./stem-assessment.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <h3 id="customizing">Customizing Behaviour</h3>
    <p>Learnosity's Assessment delivery APIs are designed to be flexible and customizable, making it easy to trigger behavior, and react to user choices, inside your own platform.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Offer Accessibility Controls and Assistive Tools</h3>
                </div>
                <div class="panel-body">
                    <p>Beyond our ability to work with system-level screen-readers, braille displays, and keyboard helpers behind the scenes, Learnosity provides in-built accessibility options which can be configured, extended and set as defaults.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./accessibility.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Question Hints & Worked Solutions</h3>
                </div>
                <div class="panel-body">
                    <p>Extend our standard assessments to provide powerful hint and worked-solution functionality.<p>
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
                    <h3 class="panel-title">Display Distractor Rationale</h3>
                </div>
                <div class="panel-body">
                    <p>Use Learnosity metadata to power distractor rationale for inline student feedback.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./distractor-rationale.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Allow Students to Preview Assessment Content</h3>
                </div>
                <div class="panel-body">
                    <p>Provide a short period of reading time before a timed assessment clock starts ticking.<p>
                    <p class="text-right">
                        <a class="demo_link" href="./reading_time.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Lock Questions to Prevent Further Edits</h3>
                </div>
                <div class="panel-body">
                    <p>Learn how to disable questions based on user behavior, such as when limiting question attempts.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./locking-questions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Restrict Responses and Navigation</h3>
                </div>
                <div class="panel-body">
                    <p>Customize the Learnosity experience by ensuring students have attempted a definable minimum threshold of questions.<p>
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
                    <h3 class="panel-title">Index Assessment Questions</h3>
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
                    <h3 class="panel-title">Provide Advanced Audio Features</h3>
                </div>
                <div class="panel-body">
                    <p>Dive deeper into audio quality, and get the information you need to make sure your students' audio is clear and easy to use.<p>
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
                    <h3 class="panel-title">Use Your Existing MathJax Instance for Math Rendering</h3>
                </div>
                <div class="panel-body">
                    <p>In cases where you have customized your own MathJax rendering, learn how to disable Learnosity's rendering and use your configuration.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./formulamathjaxcdn.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customize the Assessment Player UI</h3>
                </div>
                <div class="panel-body">
                    <p>Use Learnosity's regions to personalize and extend the Assessment player layout.</p>
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
                    <h3 class="panel-title">Bind to Items API Events</h3>
                </div>
                <div class="panel-body">
                    <p>Use the 'on' public method to bind to authoring events, supporting custom
                        notifications and actions.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./events.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Enable Annotations for Student Use</h3>
                </div>
                <div class="panel-body">
                    <p>Annotations API offers students the ability to type notes, add multi-color highlights to text, place sticky notes onto the page, and use a pen tool to annotate the content.</p>
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
                    <h3 class="panel-title">Right-to-Left Language Support</h3>
                </div>
                <div class="panel-body">
                    <p>This demo demonstrates the Learnosity approach to handling right-to-left languages.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./rtl.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Handling Submission Failures and Preserving Responses</h3>
                </div>
                <div class="panel-body">
                    <p>Give your students options for reattempting submissions, or saving responses, when a network connection is suddenly unavailable.<p>
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
                    <h3 class="panel-title">Multi Language Support (i18n and l10n)</h3>
                </div>
                <div class="panel-body">
                    <p>This demo demonstrates how Learnosity provides language bundles for different languages.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./activities-i18n.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Reset Learner Responses</h3>
                </div>
                <div class="panel-body">
                    <p>Use the resetResponse public method to allow user to reset the response of a question.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./reset-response.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <?php if (show_date_gated_content('2026-02-11')): ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Distractor Reduction</h3>
                </div>
                <div class="panel-body">
                    <p>Reduce the number of distractors in multiple choice questions for certain learners as part of your Individual Learning Plan.</p>
                    <p class="text-right">
                        <a class="demo_link" href="./distractor-reduction.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'includes/footer.php';
