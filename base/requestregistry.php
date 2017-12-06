<?php

namespace isszgt\base

class RequestRegistry extends Registry {
	private $values = array();
	private static $instance = null;
	
	private function _construct() {}
	
	static function instance() {
		if(is_null(self::$instance)) {
		self::$instance = new self();
		return self::$instance;
	}

	protected function get($key) {
		if (isset($this->values[$key]) {
			return $this->values[$key];
		return null;
	}
	protected function set($key, $val) {
		$this->values[$key] = $val;
	}

	static function getRequest() {
		$inst = self::instance();
		if (is_null($inst->get("request"))) {
			$inst->set('request', new \controller\Request());
		}
		return $inst->get("request");
	}
}

?>