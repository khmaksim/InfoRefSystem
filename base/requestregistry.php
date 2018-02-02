<?php
namespace base;

class RequestRegistry extends Registry {
	private static $instance = null;
	private static $user = null;
	private $values = array();
	private $request;
	private $appController = null;
	
	private function __construct() {}
	
	static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	protected function get($key) {
		if (isset($this->values[$key])) {
			return $this->values[$key];
		}
		return null;
	}
	protected function set($key, $val) {
		$this->values[$key] = $val;
	}

	static function getRequest() {
		$inst = self::instance();
		if (is_null($inst->request)) {
			$inst->request = new \controller\Request();
		}
		return $inst->request;
	}

	static function getUserMapper() {
		$inst = self::instance();
		if (is_null($inst->get("UserMapper"))) {
			$inst->set('UserMapper', new \mapper\UserMapper());
		}
		return $inst->get("UserMapper");
	}

	static function getObjectKiiMapper() {
		$inst = self::instance();
		if (is_null($inst->get("ObjectKiiMapper"))) {
			$inst->set('ObjectKiiMapper', new \mapper\ObjectKiiMapper());
		}
		return $inst->get("ObjectKiiMapper");
	}

	static function getInternetMapper() {
		$inst = self::instance();
		if (is_null($inst->get("InternetMapper"))) {
			$inst->set('InternetMapper', new \mapper\InternetMapper());
		}
		return $inst->get("InternetMapper");
	}

	static function getDocumentMapper() {
		$inst = self::instance();
		if (is_null($inst->get("DocumentMapper"))) {
			$inst->set('DocumentMapper', new \mapper\DocumentMapper());
		}
		return $inst->get("DocumentMapper");
	}

	static function getDepartmentMapper() {
		$inst = self::instance();
		if (is_null($inst->get("DepartmentMapper"))) {
			$inst->set('DepartmentMapper', new \mapper\DepartmentMapper());
		}
		return $inst->get("DepartmentMapper");
	}

	static function getAccessManager() {
		$inst = self::instance();
		if (is_null($inst->get('AccessManager'))) {
			$inst->setAccessManager(new \AccessManager());
		}
		return self::instance()->get('AccessManager');
	}
	
	static function setAccessManager($accessManager) {
		return self::instance()->set('AccessManager', $accessManager);
	}
	
	static function setControllerMap(\controller\ControllerMap $map) {
        self::instance()->set('cmap', $map);
    }

    static function getUser() {
    	if (is_null(self::$user)) {
			return null;
		}
		return self::$user;
	}
	
	static function setUser($user) {
		return self::$user = $user;
	}
}
?>