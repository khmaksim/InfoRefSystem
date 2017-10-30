<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
	$object = new $_GET['object']($dbo);
	
	if (isset($_GET['department'])) {
		echo $object->displayByIdDepartment($_GET['department']);
	}
?>