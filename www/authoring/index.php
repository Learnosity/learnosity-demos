<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section">
        <div class="pull-right toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a
                            href="http://docs.learnosity.com/authoring/author" title="Documentation"><span
                                class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <h1><img class="product-logo" src="/static/images/product-author.png">Learnosity Author</h1>
        <div class="section-intro">
            <p>Learnosity Author allows you to easily integrate content creation, searching and filtering into
                your own content management system.</p>
            <p>
            <ul>
                <li><h4><a class="blue-chevron" href="#browsing">Browsing Items and Activities</a></h4></li>
                <li><h4><a class="blue-chevron" href="#creating">Creating Content, Questions & Features</a></h4></li>
                <li><h4><a class="blue-chevron" href="#integrate">Customizing and Integrating into your Authoring environment</a></h4></li>
            </ul>
            </ul>
            </p>
        </div>

        <h3 id="browsing"><a href="#browsing">Browsing Items and Activities</a></h3>
        <p>Use our Author API to provide a list of items or activities created in Learnosity, filter these lists for
            access control, or limit to read-only mode for review.</p> <!--replace with CSS-->
        <br>


        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Browse Items in Your Item Bank</h2>
                    </div>
                    <div class="panel-body">
                        <p>The item list mode allows authors to browse and search the Learnosity hosted item bank for
                            existing items.</p>
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
                        <p>The activity list mode allows authors to search the Learnosity hosted activities. From there
                            it can be configured to allows users to edit activities.</p>
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
                        <p>By disabling certain configuration flags, you can easily setup read only access to your item
                            bank.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="item-list-read-only.php">Demo</a>
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
                        <p>Easily build your own item picker UI with our multiple selection mode.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./item-list-enable-selection.php">Demo</a>
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
                        <p>Easily discover items by using pre-defined tag hierarchies.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./item-list-browse-tag-hierarchy.php">Demo</a>
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
                            <a class="btn btn-primary btn-md" href="./hide-tags.php">Demo</a>
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
                        <p>Programmatically search, navigate to existing content, and create new content in your item
                            bank.</p>
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
                        <p>A demonstration of event binding with the Author API 'on' public method to display custom
                            notifications.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./events.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <h3 id="creating"><a href="#creating">Creating Content, Questions, and Features</a></h3>
        <p>Discover how to create powerful and complex assessment and learning content quickly and easily!</p>
        <br>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Create New Items</h2>
                    </div>
                    <div class="panel-body">
                        <p>The item edit mode allows authors to create and edit Items. Questions and features can be
                            created or edited and are persisted to your Learnosity item bank.</p>
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
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.
                        <p>
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
                        <p>Want to bring your authors straight to the question editing screen? Use javascript methods to bring them stright there.</p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./question-edit.php">Demo</a>
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
                        <p>Develop your own custom features that can be added to the Learnosity eco system.
                        <p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./author-custom-features.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <h3 id="integrate"><a href="#integrate">Customizing and Integrating into your Authoring environment</a></h3>
        <p>Learnosity's APIs are designed to be easily customized and extended upon, allowing you to build your Content Management System the way you want.</p> <!--replace with CSS-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Using Custom Question Templates for Authoring</h2>
                    </div>
                    <div class="panel-body">
                        <p>Need to create your own templates, with hidden, defaulted or explicitly shown fields?
                        <p>
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
                        <p>The simple authoring mode is an opinionated subset of the full authoring templates and
                            layouts available by default, ideal for use in LMSes for teacher or instructor use.
                        <p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./item-edit-simple.php">Demo</a>
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
                        <p>Custom Question layouts allows you to move, re-order and customize the question editor layout screens to your liking.
                        <p>
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
                        <p>Integrating Learnosity into your CMS, and want to use your own asset management? No problem!
                        <p>
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
                        <h2 class="panel-title">Using Custom Editor Buttons</h2>
                    </div>
                    <div class="panel-body">
                        <p>Custom buttons give you the ability to extend the standard Learnosity toolbar, to add new functionality as you need it.
                        <p>
                        <p class="text-right">
                            <a class="btn btn-primary btn-md" href="./custom-editor-buttons.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php include_once 'includes/footer.php';
