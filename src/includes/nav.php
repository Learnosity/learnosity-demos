<?php
    $pages = array(
        'Assessment' => array(
            '/assessment/questions' => 'Questions API',
            '/assessment/items' => 'Items API',
            '/assessment/assess'    => 'Assess API'
        ),
        'Authoring' => array(
            '/authoring/author'         => 'Author API',
            '/authoring/questioneditor' => 'Question Editor API'
        ),
        'Reporting' => array(
            '/reporting/reports' => 'Reports API',
            '/reporting/sso'     => 'Single Sign On API'
        ),
        'Misc' => array(
            '/misc/security_check.php' => 'Security Check'
        )
    );
?>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand logo" href="/">Learnosity Demos</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                    $currentPage = explode("/", $_SERVER['REQUEST_URI'])[1];
                    foreach ($pages as $page => $name) {
                        $active = strcasecmp($currentPage, $page) ? '' : ' active';
                        echo '
                        <li class="dropdown' . $active . '">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $page . ' <b class="caret"></b></a>
                            <ul class="dropdown-menu">';
                            foreach ($name as $subpage => $subname) {
                                echo '<li><a href="' . $subpage . '">' . $subname . '</a></li>' . PHP_EOL;
                            }
                        echo '
                            </ul>
                        </li>' . PHP_EOL;
                    }
                ?>
            </ul>
            <div class="pull-right">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="https://github.com/Learnosity/learnosity-php-examples" class="text-muted">
                            <span class="glyphicon glyphicon-file"></span> View source
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/Learnosity/learnosity-php-examples/archive/master.zip" class="text-muted">
                            <span class="glyphicon glyphicon-cloud-download"></span> Download
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
