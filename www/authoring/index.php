<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

<div class="jumbotron section">
    <div class="pull-right toolbar">
        <ul class="list-inline">
            <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="http://docs.learnosity.com/authorapi/" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
        </ul>
    </div>
    <h1>Author API</h1>
    <div class="section-intro">
        <p>Learnosity's Author API allows searching and integration of Learnosity powered content into your content management system.<p>
        <p>Content can be saved back to your Learnosity hosted item bank, or you can choose to save content locally.</p>
    </div>

    <h4><span class="badge btn-warning">Note</span> Placeholder landing page. Titles most of the way there; blurbs and links in progress</h4>
    <p>&nbsp;</p> <!--replace with CSS-->

    <h3>Browsing Items and Activities</h3>
    <p>&nbsp;</p> <!--replace with CSS-->


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Browse Items in Your Item Bank</h2>
                </div>
                <div class="panel-body">
                    <p>The item list mode allows authors to browse and search the Learnosity hosted item bank for existing items.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Browse Activities in Your Item Bank</h2>
                </div>
                <div class="panel-body">
                    <p>The activity list mode allows authors to search the Learnosity hosted activities. From there it can be configured to allows users to edit activities.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./activity-list.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Filter Items in Your Item Bank</h2>
                </div>
                <div class="panel-body">
                    <p>Use tags to control which items in your Item Bank are visible to different users.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list-filtered.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Filter Activities in Your Item Bank</h2>
                </div>
                <div class="panel-body">
                    <p>Use tags to control which activities in your item bank are visible.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./activity-list-filtered.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Preview your Item Bank in Read-Only Mode</h2>
                </div>
                <div class="panel-body">
                    <p>By disabling certain configuration flags, you can easily setup read only access to your item bank.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list-readonly.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Select Multiple Items from Item Browsing</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list-multiselect.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Browsing Items Using Tag Hierarchies</h2>
                </div>
                <div class="panel-body">
                    <p>Discover items through tag hierarchies.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list-hierarchies.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Controlling which Tags Appear in the Authoring Interface</h2>
                </div>
                <div class="panel-body">
                    <p>Hide specific tags from the item and activity tagging UI.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./tags-blacklist.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Navigate your Item Bank</h2>
                </div>
                <div class="panel-body">
                    <p>Programmatically search, navigate to existing content, and create new content in your item bank.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./routing.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Binding to Author API Events</h2>
                </div>
                <div class="panel-body">
                    <p>A demonstration of event binding with the Author API 'on' public method to display custom notifications.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./events.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <h3>Creating Content, Questions, and Features</h3>
    <p>&nbsp;</p> <!--replace with CSS-->

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Create New Items</h2>
                </div>
                <div class="panel-body">
                    <p>The item edit mode allows authors to create and edit Items. Questions and features can be created or edited and are persisted to your Learnosity item bank.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-create.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Create New Activities</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./activity-create.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Edit Questions Directly</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./question-edit.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Edit Features Directly</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./feature-edit.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using Dynamic Content</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./dynamic-content.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">TBD</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./tbd.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Authoring Custom Questions</h2>
                </div>
                <div class="panel-body">
                    <p>Develop your own custom questions that can be added to the Learnosity eco system.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./author-custom-questions.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Authoring Custom Features</h2>
                </div>
                <div class="panel-body">
                    <p>Develop your own custom features that can be added to the Learnosity eco system.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./author-custom-features.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <h3>Integrate and Customize Your Authoring Environment</h3>
    <p>&nbsp;</p> <!--replace with CSS-->

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using Custom Question Templates for Authoring</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./question_templates.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Simplified Authoring for Teachers and Instructors</h2>
                </div>
                <div class="panel-body">
                    <p>The simple authoring mode is an opinionated subset of the full authoring templates and layouts available by default.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./item-list-simple.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Customizing the Question Editing Layout</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./custom-qe-layout.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using your Own Digital Asset Management System</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./dam-asset-request.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using Author-Friendly Titles</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./author-friendly-titles.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Using Custom Editor Buttons</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./custom-editor-buttons.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Creating Your Own Global Editor</h2>
                </div>
                <div class="panel-body">
                    <p>Develop your own custom questions that can be added to the Learnosity eco system.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./global-qe-layout.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">TBD</h2>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./tbd.php">Demo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once 'includes/footer.php';
