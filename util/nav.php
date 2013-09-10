
<script>
    //Show alert if not being used form localhost
    if(location.hostname != 'localhost'){
        document.write("<p>Note: This demo will only work from 'localhost' please contact support@learnosity.com to get an additional domain added.</p>");
    }
</script>


<?php
    $pages = array(
            "index.php"=>"Home",
            "questionsapi.php"=>"QuestionsAPI",
            "assessapi.php"=>"AssessAPI",
            "itemsapi_inline.php"=>"Items API Inline",
            "itemsapi.php"=>"Items API",
            "ssoapi.php"=>"Single Sign On",
            );
?>

<ul class="nav nav-pills">
    <?php
        $currentPage = basename($_SERVER['SCRIPT_NAME']);
        foreach ($pages as $page => $name) {
            if($currentPage == $page){
                $class = 'class="active"';
            }else{
                $class = '';
            }

            echo '<li '.$class.'><a href="'.$page.'">'.$name.'</a></li>';

        }
     ?>
</ul>
