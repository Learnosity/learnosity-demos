<?php
include_once '../../config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section">
        <div class="pull-right toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://docs.learnosity.com/assessment/items" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <h1>Items API</h1>
        <div class="section-intro">
            <p>Learnosity's <b>Items API</b> provides a simple way to access content from the Learnosity
                item bank, and to optionally pull in activities (assessments) that can be embedded in your pages.
                It leverages the <a href="../questions/index.php">Questions API</a> and the
                <a href="../assess/index.php">Assess API</a> as appropriate.</p>
            <p>The Items API also supports both items and testlet
                <a href="https://docs.learnosity.com/assessment/items/knowledgebase/adaptiveassessment" target="_blank">
                    adaptive assessments</a>.
            </p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Use our Assessment Layer</h2>
                    </div>
                    <div class="panel-body">
                        <p>With the flick of a switch turn items into assessments.
                            Truly write once - use anywhere.</p>
                        <p>Uses the power of our Assess API for a full assessment experience.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_assess.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Render Questions Inline (no Assessment Layer)</h2>
                    </div>
                    <div class="panel-body">
                        <p>Display items from the Learnosity item bank in no time with the Items API.</p>
                        <p>Leverages the Questions API's power and makes it faster to integrate.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_inline.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Accessibility</h2>
                    </div>
                    <div class="panel-body">
                        <p>Showcases the Accessibility panel that allows students to configure accessibility options during an assessment.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_accessibility.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Worked Solutions (hints)</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows examples of using inline hints for questions.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_workedsolutions.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Formative Distractor Rationale</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows examples of instant feedback to students, as they attempt questions.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_distractors.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Activities</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows examples of loading assessments using activities authored in the Learnosity item bank.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_activities.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Item Branching Assessment</h2>
                    </div>
                    <div class="panel-body">
                        <p>A simple dynamic assessment that selects the next item or branch based on past performance,
                            according to a pre-defined configuration.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_itembranching.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Item Adaptive Assessment</h2>
                    </div>
                    <div class="panel-body">
                        <p>A dynamic assessment that adapts to the user's ability in real time, on a per item basis.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_itemadaptive.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Testlet Adaptive Assessment</h2>
                    </div>
                    <div class="panel-body">
                        <p>A dynamic assessment that adapts to the user's ability, choosing which testlet to go through next.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_testletadaptive.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Sections</h2>
                    </div>
                    <div class="panel-body">
                        <p>Sections are a way to split up a single activity into discrete buckets of items, with
                            the ability to have different activity configuration per section.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_sections.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Failed Submission</h2>
                    </div>
                    <div class="panel-body">
                        <p>Simulates submitting an activity where the network connection may not be available.
                            Students get 3 attempts to submit a test before being presented with options to manually
                            retrieve their assessment data.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_failedsubmission.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Locking Questions</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows how to customize the questions Check Answer button logic</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_locking_questions.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Restrict Responses Demo</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows the ability to restrict the assessment navigation and display a message to the student when is missing question responses.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_restrict_responses.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Texthelp Demo</h2>
                    </div>
                    <div class="panel-body">
                        <p>Integrating Learnosity with third-party systems.</p>
                        <p>Texthelp's SpeechStream is a cloud based JavaScript software solution that allows publishers to embed text-to-speech read aloud within their assessment items.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_texthelp.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Assess Question Indexing Demo</h2>
                    </div>
                    <div class="panel-body">
                        <p>Shows the effect of the assess question_indexing option, which indents and numbers all questions.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./itemsapi_question_indexing.php">Demo</a>
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
                            <a class="btn btn-primary btn-md" href="./itemsapi_annotations.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>

    </div>

<?php include_once 'includes/footer.php';
