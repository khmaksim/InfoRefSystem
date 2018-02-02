<?php

namespace base;

class SessionRegistry extends Registry {
	private static $instance = null;

	private function __construct() {
		// Запуск механизма сессий
		session_start();
	}
	
	static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	protected function get($key) {
		if (isset($_SESSION[__CLASS__][$key])) {
			return $_SESSION[__CLASS__][$key];
		}
		return null;
	}

	protected function set($key, $val) {
		$_SESSION[__CLASS__][$key] = $val;
	}

	static function setIdUser($id_user) {
		self::instance()->set('id_user', $id_user);
	}

	static function getIdUser() {
		return self::instance()->get('id_user');
	}
}

?>