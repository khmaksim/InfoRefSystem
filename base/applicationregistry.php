<?php
namespace base;

class ApplicationRegistry extends Registry {
	private static $instance = null;
	private $freezedir = "data";
	private $values = array();
	private $mtimes = array();
	private $request;

	private function __construct() {}
	
	static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	protected function get($key) {
		$path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
		if (file_exists($path)) {
			clearstatcache();
			$mtime = filemtime($path);
			if (!isset($this->mtimes[$key])) {
				$this->mtimes[$key] = 0;
			}
			if ($mtime > $this->mtimes[$key]) {
				$data = file_get_contents($path);
				$this ->mtimes[$key] = $mtime;
				return ($this->values[$key] = unserialize($data));
			}
		}
		if (isset($this->values[$key])) {
			return $this->values[$key];
		}
		return null;
	}
	protected function set($key, $val) {
		$this ->values[$key] = $val;
		$path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
		file_put_contents($path, serialize($val));
		$this->mtimes[$key] = time();
	}
	
	static function getDSN() {
		return self::instance()->get('dsn');
	}
	
	static function setDSN($dsn) {
		return self::instance()->set('dsn', $dsn);
	}

	static function getUsername() {
		return self::instance()->get('username');
	}
	
	static function setUsername($username) {
		return self::instance()->set('username', $username);
	}

	static function getPasswd() {
		return self::instance()->get('passwd');
	}
	
	static function setPasswd($passwd) {
		return self::instance()->set('passwd', $passwd);
	}

	static function setControllerMap(\controller\ControllerMap $map) {
        self::instance()->set('cmap', $map);
    }

    static function getControllerMap() {
        return self::instance()->get('cmap');
    }

    static function appController() {
        $obj = self::instance();
        if (!isset($obj->appController) ) {
            $cmap = $obj->getControllerMap();
            $obj->appController = new \controller\AppController($cmap);
        }
        return $obj->appController;
    }

	static function getRequest() {
		$inst = self::instance();
		if (is_null($inst->request)) {
			$inst->request = new \controller\Request();
		}
		return $inst->request;
	}
}

?>