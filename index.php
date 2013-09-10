<?php
    include "util/headertop.php";

    $errors = array();

    if(file_exists("config.php")){
        include_once "config.php";
    }else{
        $errors[] = "config.php does not exist.  Have you copied config.dist.php to config.php and set the keys";

    }
    include "util/headerbottom.php";

  //  include "util/nav.php";


        //Loop through required keys in signature block
        $configKeys = array('consumer_key', 'consumer_secret','name');


        foreach ($configKeys as $key) {
            //Check key exists
            if(! isset(${$key}) || !strlen(${$key})) $errors[] = "Config key missing: ".$key." Please fix this up in config.php";
        }

?>


<div class="jumbotron">
  <div class="container">
    <h1>Welcome</h1>
    <p>This page checks that your basic configuration is good.<p>

       <?php

        if(count($errors)){
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
                echo 'Unfortunately your config is not good yet.  If you fix the errors then you can proceed';
           }
        }else{
            echo '<div class="alert alert-success"><b>Config OK!</b> Looks like you are good to go.</div>';
            echo '<p><a class="btn btn-primary btn-lg" href="questionsapi.php">Continue</a></p>';
        }

       ?>

  </div>
</div>




<?php include "util/footer.php" ?>

