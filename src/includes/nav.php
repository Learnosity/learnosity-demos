<?php
    $pages = array(
        'Assessment' => array(
            'questionsapi.php' => 'Questions API',
            'itemsapi_assess.php' => 'Items API – Assess',
            'itemsapi_inline.php' => 'Items API – Inline',
            'assessapi.php'    => 'Assess API'
        ),
        'Authoring' => array(
            'authorapi.php'         => 'Author API',
            'questioneditorapi.php' => 'Question Editor API'
        ),
        'Reporting' => array(
            'reportsapi.php' => 'Reports API',
            'ssoapi.php'     => 'Single Sign On API'
        ),
        'Misc' => array(
            'security_check.php' => 'Security Check'
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
                    $currentPage = basename($_SERVER['SCRIPT_NAME']);
                    foreach ($pages as $page => $name) {
                        $class = ($currentPage === $page) ? ' class="active"' : '';
                        if (is_string($name)) {
                            echo '<li' . $class . '><a href="' . $page . '">' . $name . '</a></li>' . PHP_EOL;
                        } else {
                            echo '
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $page . ' <b class="caret"></b></a>
                                <ul class="dropdown-menu">';
                                foreach ($name as $subpage => $subname) {
                                    echo '<li><a href="' . $subpage . '">' . $subname . '</a></li>' . PHP_EOL;
                                }
                            echo '
                                </ul>
                            </li>' . PHP_EOL;
                        }
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
