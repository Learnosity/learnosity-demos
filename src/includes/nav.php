<?php
    $pages = array(
        'index.php'           => 'Home',
        'questionsapi.php'    => 'QuestionsAPI',
        'assessapi.php'       => 'AssessAPI',
        'itemsapi_inline.php' => 'Items API - Inline',
        'itemsapi_assess.php' => 'Items API - Assess',
        'ssoapi.php'          => 'Single Sign On',
    );
?>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Learnosity Demo</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php
                    $currentPage = basename($_SERVER['SCRIPT_NAME']);
                    foreach ($pages as $page => $name) {
                        $class = ($currentPage === $page) ? ' class="active"' : '';
                        echo '<li' . $class . '><a href="' . $page . '">' . $name . '</a></li>' . PHP_EOL;
                    }
                 ?>
            </ul>
        </div>
    </div>
</div>
