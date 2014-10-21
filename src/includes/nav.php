<?php
    $pages = array(
        'Authoring' => array(
            'authoring/questioneditor/index.php' => 'Question Editor API',
            'authoring/author/index.php'         => 'Author API'
        ),
        'Assessment' => array(
            'assessment/items/index.php'     => 'Items API',
            'assessment/questions/index.php' => 'Questions API',
            'assessment/assess/index.php'    => 'Assess API'
        ),
        'Reporting' => array(
            'reporting/reports/index.php' => 'Reports API',
            'reporting/data/index.php'    => 'Data API',
            'reporting/sso/index.php'     => 'Single Sign On API (Deprecated)'
        ),
        'Misc' => array(
            'misc/security_check.php' => 'Security Check'
        ),
        'Case Studies' => array(
            // 'casestudies/items/gallery' => 'Gallery Style UI',
            'casestudies/items/xapi'    => 'xAPI Events'
        )
    );
?>

<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $env['www'] ?>"><span class="logo">Learnosity Demos</span></a>
        </div>
        <div class="navbar-collapse collapse" id="nav-main">
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
            <div class="nav-sec-wrapper">
                <ul class="nav navbar-nav nav-sec">
                    <li>
                        <a href="https://github.com/Learnosity/learnosity-demos" class="text-muted">
                            <span class="glyphicon glyphicon-file"></span> <span class="nav-source-text">View source</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
