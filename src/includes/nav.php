<?php
    $pages = array(
        'Authoring' => array(
            'authoring/author/index.php'         => 'Author API',
            'authoring/questioneditor/v3/index.php' => 'Question Editor API',
            'authoring/questioneditor/index.php' => 'Question Editor API V2'
        ),
        'Assessment' => array(
            'assessment/items/index.php'     => 'Items API',
            'assessment/questions/index.php' => 'Questions API',
            'assessment/assess/index.php'    => 'Assess API'
        ),
        'Analytics' => array(
            'analytics/reports/index.php' => 'Reports API',
            'analytics/data/index.php'    => 'Data API'
        ),
        'Misc' => array(
            'misc/security_check.php' => 'Security Check'
        ),
        'Case Studies' => array(
            'casestudies/feedback' => 'Teacher Feedback',
            'casestudies/printing' => 'Printing Items',
            'casestudies/gallery'  => 'Gallery Style UI',
            'casestudies/xapi'     => 'xAPI Events',
            'casestudies/endtoend' => 'End to End Demo',
            'casestudies/customquestions' => 'Custom Questions',
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
