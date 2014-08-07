<!--
********************************************************************
*
* Setup the Items API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $con  = $request['config'];
    $nav  = $request['config']['navigation'];
    $time = $request['config']['time'];
    $admin = $request['config']['administration'];

    $service = 'Items API';
    $serviceShortcut = 'items';

    include_once 'views/modals/settings-content.php';
?>

