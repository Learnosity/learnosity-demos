<?php
include_once 'env_config.php';
include_once 'includes/mapping.php';
include_once 'includes/header.php';
?>

<div class="landing section index">
    <div class="jumbotron">
        <div class="landing-intro">
            <div class="media">
                <div class="media-body">
                    <h1>Uh oh!</h1>
                    <h2>404 Not Found</h2>
                    </p><p>
                        Unfortunately, we can't find the page you're looking for.
                        We'd suggest starting over from the <a href="/">home page.</a>
                        However, perhaps the following search results can help.
                    </p>
                    <iframe width="100%" height="1024" src="https://learnosity.com/?s=<?=
                    urlencode(
                        str_replace('/', ' ', $_SERVER['REQUEST_URI'])
                        /* . ' site:demos.learnosity.com' */
                    )
?>">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    </div>


</div>

<?php
    include_once 'includes/footer.php';
