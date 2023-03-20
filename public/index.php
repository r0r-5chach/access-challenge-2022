<?php
session_start();
require '../autoload.php';
$routes = new \site\Routes();
$entryPoint = new \framework\EntryPoint($routes);
$entryPoint->run();
?>
