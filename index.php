<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    require ($_SERVER['DOCUMENT_ROOT'] . "/controller/Controller.php");
    \controller\Controller::run();
?>

