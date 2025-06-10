<?php
include_once 'env_config.php';
include_once 'includes/mapping.php';
include_once 'includes/header.php';
?>

<div class="landing section index">
    <div class="jumbotron">
        <div class="landing-intro">
            <h1>Learnosity API and Partner Demos</h1>
            <div class="media">
                <div class="media-body">
                    <p>Discover how Learnosity can power your ideal assessment and learning platform through a range of interactive demos. Explore real content and see our capabilities in action.</p>

                    <p>
                        <strong>Ready to go further?</strong><br>
                        <a href="https://github.com/Learnosity/learnosity-demos/tree/master">Download the full site or browse the source code on GitHub</a> to see how easily Learnosity integrates into your technology stack. The site is written in PHP, but the format is easy to adapt to any language you prefer.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default main-page-panel">
                <div class="panel-heading">
                    <img class="product-logo-small" src="/static/images/product-author-logo.png" alt="Learnosity Author logo">
                    <h2>Learnosity <span class="lightweight">Author</span></h2>
                </div>
                <div class="panel-body">
                    <p>Easily integrate content creation, searching and filtering into your own content management system.<p>
                    <p>
                        <a class="blue-chevron" href="./authoring/index.php" aria-label="Learn more about Learnosity Author">Learn more</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default main-page-panel">
                <div class="panel-heading">
                    <img class="product-logo-small" src="/static/images/product-assessments-logo.png" alt="Learnosity Assessments logo">
                    <h2>Learnosity <span class="lightweight">Assessments</span></h2>
                </div>
                <div class="panel-body">
                    <p>Deliver your content and assessments where, when and how you want!<p>
                    <p>
                        <a class="blue-chevron" href="./assessment/index.php" style="margin:3px;" aria-label="Learn more about Learnosity Assessment">Learn more</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default main-page-panel">
                <div class="panel-heading">
                    <img class="product-logo-small" src="/static/images/product-analytics-logo.png" alt="Learnosity Analytics logo">
                    <h2>
                        Learnosity <span class="lightweight">Analytics</span></h2>
                </div>
                <div class="panel-body">
                    <p>Delve into your data in whatever way you need - whether it be at-a-glance reports, in-depth large scale reporting, or access to raw granular data.<p>
                    <p>
                        <a class="blue-chevron" href="./analytics/index.php" aria-label="Learn more about Learnosity Analytics">Learn more</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-default main-page-panel panel-short">
                <div class="panel-heading">
                    <h2 class="panel-title">Use Cases</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about combining multiple APIs to achieve rich, deep end use-cases for your platform.<p>
                    <p>
                        <a class="blue-chevron" href="./usecases/index.php" aria-label="Learn more about use-cases.">Learn more</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-default main-page-panel panel-short">
                <div class="panel-heading">
                    <h2 class="panel-title">Partners</h2>
                </div>
                <div class="panel-body">
                    <p>Learn more about integrating Learnosity with selected Partners, and unleashing a world of potential.</p>
                    <p>
                        <a class="blue-chevron" href="./partners/index.php">Learn more</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
    include_once 'includes/footer.php';
