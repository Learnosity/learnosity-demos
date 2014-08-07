<!--
********************************************************************
*
* Setup the Assess API Settings modal
*
********************************************************************
-->
<?php
    // Shortcuts for convenience
    $con  = $request;
    $nav  = $request['navigation'];
    $time = $request['time'];
    $admin = $request['administration'];

    $service = 'Assess API';
    $serviceShortcut = 'assess';

    include_once 'views/modals/settings-content.php';
?>
