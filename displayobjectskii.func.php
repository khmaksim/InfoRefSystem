<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
	$wrapper = new Wrapper($dbo);
	
	if (isset($_GET['id_department'])) {
		echo $wrapper->displayObjectsKii($_GET['id_department']);
	}
?>