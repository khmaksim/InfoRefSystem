<?php
	// session_start();
	
	// include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/config/db-cred.inc.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
	
	// foreach ($C as $name => $val)	{
	// 	define($name, $val);
	// }

	$actions = array(
		'edit' => array(
			'object' => 'Wrapper',
			'method' => 'processForm',
			'header' => 'Location: /objectskii.php'
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
		header("Location: /objectskii.php");
		exit;
	}

	// function __autoload($class_name)
	// {
	// 	$filename = $_SERVER['DOCUMENT_ROOT'] . '/sys/class/class.'	. strtolower($class_name) . '.inc.php';
	// 	if (file_exists($filename)) {
	// 		include_once $filename;
	// 	}
	// }
?>