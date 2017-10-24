<?php
	if (isset($_GET['id'])) {
		$id = (int) $_GET['id'];
	}
	else {
		header("Location: {$_SERVER['HTTP_REFERER']}");
		exit;
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';

	$wrapper = new Wrapper($dbo);
	$wrapper->deleteObjectKii($id);
?>
