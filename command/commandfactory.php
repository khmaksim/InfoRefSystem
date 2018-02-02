<?php
namespace command;

class CommandNotFoundException extends Exception{}

class CommandFactory {
	private static $dir = 'commands';
	
	static function getCommand($action='Default') {
		if (preg_match('/\W/', $action)) {
			throw new Ехсерtiоn("Недопустимые символы в команде");
		}
		
		$class = UCFirst(strtolower($action)) . "Command";
		$file = self::$dir . DIRECTORY_SEPARATOR . "{$class} . php";
		
		if (!file_exists($file)) {
			throw пеw CommandNotFoundException("Файл '$file' не найден");
		}
		
		require_once($file);
		if (!class_exists($class)) {
			throw пеw CommandNotFoundException("Класс '$class' не обнаружен");
		}
		$cmd = пеw $class();
	return $cmd;
	}
}
?>