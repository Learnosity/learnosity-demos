<?php
    include 'src/includes/headertop.php';

    $errors = array();

    if (file_exists('config.php')){
        include_once 'config.php';
    } else {
        $errors[] = '<em>config.php</em> does not exist. Have you copied config.dist.php to config.php and set the keys?';
    }

    include 'src/includes/headerbottom.php';

    //Loop through required keys in signature block
    $configKeys = array('consumer_key', 'consumer_secret');

    foreach ($configKeys as $key) {
        //Check key exists
        if (!isset(${$key}) || !strlen(${$key})) $errors[] = 'Config key missing: <em>' . $key . '</em> Please fix this up in config.php';
    }
?>

<div class="jumbotron">
    <h1>Welcome</h1>
    <p>This page checks that your basic configuration is ok.<p>

   <?php
    if (count($errors)) {
        echo '<h2>Config error</h2>' .
            '<p>Unfortunately your config is invalid. Please fix the errors below then you can proceed.</p>';
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">'.$error.'</div>';
       }
    } else {
        echo '<div class="alert alert-success"><b>Config OK</b> - Looks like you are good to go!</div>';
        echo '<p class="text-right"><a class="btn btn-primary btn-lg" href="questionsapi.php">Continue</a></p>';
    }
   ?>

</div>

<?php include 'src/includes/footer.php' ?>
