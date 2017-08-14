<!--
********************************************************************
*
* Setup the Items API Settings modal
*
********************************************************************
-->
<?php
// Shortcuts for convenience
$con   = $request['config'];
$nav   = (isset($request['config']['navigation'])) ? $request['config']['navigation'] : null;
$time  = (isset($request['config']['time'])) ? $request['config']['time'] : null;
$admin = $request['config']['administration'];

$service = 'Items API';
$serviceShortcut = 'items';

include_once 'views/modals/settings-content.php';
