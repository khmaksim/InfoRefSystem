<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
	$objectKii = new ObjectKii($dbo);
	
	if (isset($_GET['id_department'])) {
		echo $objectKii->displayByIdDepartment($_GET['id_department']);
	}
?>