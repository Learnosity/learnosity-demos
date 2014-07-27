<?php
    $pages = array(
        'Authoring' => array(
            'authoring/questioneditor/index.php' => 'Question Editor API',
            'authoring/author/index.php'         => 'Author API'
        ),
        'Assessment' => array(
            'assessment/questions/index.php' => 'Questions API',
            'assessment/items/index.php'     => 'Items API',
            'assessment/assess/index.php'    => 'Assess API'
        ),
        'Reporting' => array(
            'reporting/reports/index.php' => 'Reports API',
            'reporting/data/index.php'    => 'Data API',
            'reporting/sso/index.php'     => 'Single Sign On API'
        ),
        'Misc' => array(
            'misc/security_check.php' => 'Security Check'
        )
    );
?>

<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand logo" href="<?php echo $env['www'] ?>">Learnosity Demos</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                    foreach ($pages as $page => $name) {
                        $active = strcasecmp($env['section'], $page) ? '' : ' active_';
                        echo '
                        <li class="dropdown' . $active . '">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $page . ' <b class="caret"></b></a>
                            <ul class="dropdown-menu">';
                            foreach ($name as $subpage => $subname) {
                                echo '<li><a href="' . $env['www'] . $subpage . '">' . $subname . '</a></li>' . PHP_EOL;
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
                        <a href="https://github.com/Learnosity/learnosity-demos" class="text-muted">
                            <span class="glyphicon glyphicon-file"></span> View source
                        </a>
                    </li>
                    <!-- <li>
                        <a href="https://github.com/Learnosity/learnosity-php-examples/archive/master.zip" download="demos.master.zip" class="text-muted">
                            <span class="glyphicon glyphicon-cloud-download"></span> Download
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
