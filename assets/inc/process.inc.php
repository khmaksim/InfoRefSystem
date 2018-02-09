<?php
	$header = "Location: {$_SERVER['HTTP_REFERER']}";
	$header = str_replace('_edit', '', $header);
	$actions = array(
		'edit' => array(
			'object' => $_POST['object'],
			'method' => 'processForm',
			'header' => $header
		)
	);
	if ($_POST['token']==$_SESSION['token'] && isset($actions[$_POST['action']])) {
		$use_array = $actions[$_POST['action']];
		$obj = new $use_array['object']($dbo);
		
		if (TRUE === $msg=$obj->$use_array['method']()) {
			header($use_array['header']);
			exit;
		}
		else {
			die ( $msg );
		}
	}
	else {
		header($header);
		exit;
	}
?>