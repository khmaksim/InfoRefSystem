<?php
date_default_timezone_set('Europe/Moscow');
// Установка директорий поиска включения файлов
set_include_path(get_include_path() . PATH_SEPARATOR . "C:/Apache24/htdocs/isszgt/");
// Включение автозагрузки файлов
spl_autoload_register();

if (!isset($_SESSION['token'])) {
	$_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}

// function autoload($class) {
// 	$filename = $_SERVER['DOCUMENT_ROOT'] . '/sys/class/class.' . $class . '.inc.php';
// 	if (file_exists($filename)) {
// 		include_once $filename;
// 	}
// }
?>