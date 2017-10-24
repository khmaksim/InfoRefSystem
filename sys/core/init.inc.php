<?php

// Запуск механизма сессий
session_start();

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/config/db-cred.inc.php';

foreach ($C as $name => $val) {
	define($name, $val);
}

$dsn = "pgsql:host=". DB_HOST .";port=". DB_PORT .";dbname=". DB_NAME;
$dbo = new PDO($dsn, DB_USER, DB_PASS);

function __autoload($class) {
	$filename = $_SERVER['DOCUMENT_ROOT'] . '/sys/class/class.' . $class . '.inc.php';
	if (file_exists($filename)) {
		include_once $filename;
	}
}

?>