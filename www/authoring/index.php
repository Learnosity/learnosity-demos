<?php

include_once '../env_config.php';
include_once 'includes/header.php';
?>

    <div class="jumbotron section index">
        <p><img class="product-logo" src="/static/images/product-author-full.png"></p>
        <div class="section-intro">
            <p>Learnosity Author allows you to easily integrate content creation, searching and filtering into your own content management system.</p>
            <p>
            <ul>
                <li><h4><a class="blue-chevron" href="#browsing">Browsing Items and Activities</a></h4></li>
                <li><h4><a class="blue-chevron" href="#creating">Creating Content, Questions & Features</a></h4></li>
                <li><h4><a class="blue-chevron" href="#integrate">Customizing and Integrating into your Authoring environment</a></h4></li>
            </ul>
            </ul>
            </p>
        </div>
    </div>
    <div class="section index">
        <h3 id="browsing">Browsing Items and Activities</h3>
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
                        <p>The item list mode allows authors to browse and search Learnosity-hosted item banks for
                            existing items.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-list.php">Demo</a>
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
                        <p>The activity list mode allows authors to search for Learnosity-hosted activities. From there
                            it can be configured to allow users to edit activities.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./activity-list.php">Demo</a>
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
                        <p>Use tags to control which items in your item bank are visible to different users.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-list-filtered.php">Demo</a>
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
                        <p>Use tags to control which activities in your item bank are visible to different users.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./activity-list-filtered.php">Demo</a>
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
                        <p>By disabling specific configuration flags, you can easily setup read-only access to your item
                            bank.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="item-list-read-only.php">Demo</a>
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
                            <a class="demo_link"  href="./item-list-enable-selection.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Browse Items Using Tag Hierarchies</h2>
                    </div>
                    <div class="panel-body">
                        <p>Easily discover items by using pre-defined tag hierarchies.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-list-browse-tag-hierarchy.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Control which Tags Appear in the Authoring Interface</h2>
                    </div>
                    <div class="panel-body">
                        <p>Hide specific tags from the item and activity tagging UI.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./hide-tags.php">Demo</a>
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
                            <a class="demo_link"  href="./routing.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Bind to Author API Events</h2>
                </div>
                    <div class="panel-body">
                        <p>Use the 'on' public method to bind to authoring events, supporting custom
                            notifications and actions.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./events.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section index">

        <h3 id="creating">Creating Content, Questions, and Features</h3>
        <p>Discover how to create powerful and complex assessment and learning content quickly and easily!</p>
        <br>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Create New Items</h2>
                    </div>
                    <div class="panel-body">
                        <p>Create and edit items that persist in your Learnosity-hosted item bank.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-create.php">Demo</a>
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
                        <p>Create and edit activites that persist in your Learnosity-hosted item bank.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./activity-create.php">Demo</a>
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
                        <p>Bring your authors straight to a question editing panel using JavaScript methods.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./question-edit.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Author Custom Features</h2>
                    </div>
                    <div class="panel-body">
                        <p>Develop your own custom features for inclusion in your Learnosity eco system.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./author-custom-features.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="section index">

        <h3 id="integrate">Customizing and Integrating into your Authoring environment</h3>
        <p>Learnosity's APIs are designed to be easily customized and extended, allowing you to build your content management system the way you want.</p> <!--replace with CSS-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Build Custom Question Templates</h2>
                    </div>
                    <div class="panel-body">
                        <p>Create your own question templates with default values, and simplify the editing interface by hiding unwanted fields.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./question_templates.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Simplify Authoring for Teachers and Instructors</h2>
                    </div>
                    <div class="panel-body">
                        <p>The simple authoring mode is an opinionated subset of the full authoring templates and
                            layouts available by default—ideal for use in an LMS for teacher or instructor use.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-edit-simple.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Customize the Question Editing Layout</h2>
                    </div>
                    <div class="panel-body">
                        <p>Custom editor panel layouts allow you to move, re-order and customize the question editor UI to your liking.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./custom-qe-layout.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Use your Own Digital Asset Management System</h2>
                    </div>
                    <div class="panel-body">
                        <p>Use your own asset management tool when integrating Learnosity into your CMS.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./dam-asset-request.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Use Custom Editor Buttons</h2>
                    </div>
                    <div class="panel-body">
                        <p>Custom buttons give you the ability to extend the standard Learnosity toolbar to add new functionality as you need it.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./custom-editor-buttons.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Customize the Simple Feature Modal Layout</h2>
                    </div>
                    <div class="panel-body">
                        <p>Custom simple feature modal layouts allow you to move, re-order and customize the simple features to your liking.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./simple-feature-layout.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Enabling Item Titles</h2>
                    </div>
                    <div class="panel-body">
                        <p>Item Titles allow authors to better organize and identify their content. Unlike references, titles can contain special characters and do not have to be unique.</p>
                        <p class="text-right">
                            <a class="demo_link"  href="./item-titles.php">Demo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php include_once 'includes/footer.php';
