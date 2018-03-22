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

	static function getMilitaryRankMapper() {
		$inst = self::instance();
		if (is_null($inst->get("MilitaryRankMapper"))) {
			$inst->set('MilitaryRankMapper', new \mapper\MilitaryRankMapper());
		}
		return $inst->get("MilitaryRankMapper");
	}

	static function getPositionMapper() {
		$inst = self::instance();
		if (is_null($inst->get("PositionMapper"))) {
			$inst->set('PositionMapper', new \mapper\PositionMapper());
		}
		return $inst->get("PositionMapper");
	}

	static function getMedalTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("MedalTypeMapper"))) {
			$inst->set('MedalTypeMapper', new \mapper\MedalTypeMapper());
		}
		return $inst->get("MedalTypeMapper");
	}

	static function getInterpassportTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("InterpassportTypeMapper"))) {
			$inst->set('InterpassportTypeMapper', new \mapper\InterpassportTypeMapper());
		}
		return $inst->get("InterpassportTypeMapper");
	}

	static function getAccessTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("AccessTypeMapper"))) {
			$inst->set('AccessTypeMapper', new \mapper\AccessTypeMapper());
		}
		return $inst->get("AccessTypeMapper");
	}

	static function getCityMapper() {
		$inst = self::instance();
		if (is_null($inst->get("CityMapper"))) {
			$inst->set('CityMapper', new \mapper\CityMapper());
		}
		return $inst->get("CityMapper");
	}

	static function getAddressTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("AddressTypeMapper"))) {
			$inst->set('AddressTypeMapper', new \mapper\AddressTypeMapper());
		}
		return $inst->get("AddressTypeMapper");
	}

	static function getEmailTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("EmailTypeMapper"))) {
			$inst->set('EmailTypeMapper', new \mapper\EmailTypeMapper());
		}
		return $inst->get("EmailTypeMapper");
	}

	static function getPhoneNumberMapper() {
		$inst = self::instance();
		if (is_null($inst->get("PhoneNumberMapper"))) {
			$inst->set('PhoneNumberMapper', new \mapper\PhoneNumberMapper());
		}
		return $inst->get("PhoneNumberMapper");
	}

	static function getPhoneNumberTypeMapper() {
		$inst = self::instance();
		if (is_null($inst->get("PhoneNumberTypeMapper"))) {
			$inst->set('PhoneNumberTypeMapper', new \mapper\PhoneNumberTypeMapper());
		}
		return $inst->get("PhoneNumberTypeMapper");
	}

	static function getScientificWorkMapper() {
		$inst = self::instance();
		if (is_null($inst->get("ScientificWorkMapper"))) {
			$inst->set('ScientificWorkMapper', new \mapper\ScientificWorkMapper());
		}
		return $inst->get("ScientificWorkMapper");
	}

	static function getProductMapper() {
		$inst = self::instance();
		if (is_null($inst->get("ProductMapper"))) {
			$inst->set('ProductMapper', new \mapper\ProductMapper());
		}
		return $inst->get("ProductMapper");
	}

	static function getEnterpriseMapper() {
		$inst = self::instance();
		if (is_null($inst->get("EnterpriseMapper"))) {
			$inst->set('EnterpriseMapper', new \mapper\EnterpriseMapper());
		}
		return $inst->get("EnterpriseMapper");
	}

	static function getUnitMapper() {
		$inst = self::instance();
		if (is_null($inst->get("UnitMapper"))) {
			$inst->set('UnitMapper', new \mapper\UnitMapper());
		}
		return $inst->get("UnitMapper");
	}

	static function getTechniqueMapper() {
		$inst = self::instance();
		if (is_null($inst->get("TechniqueMapper"))) {
			$inst->set('TechniqueMapper', new \mapper\TechniqueMapper());
		}
		return $inst->get("TechniqueMapper");
	}

	static function getPersonMapper() {
		$inst = self::instance();
		if (is_null($inst->get("PersonMapper"))) {
			$inst->set('PersonMapper', new \mapper\PersonMapper());
		}
		return $inst->get("PersonMapper");
	}

	static function getIncomingDocumentMapper() {
		$inst = self::instance();
		if (is_null($inst->get("IncomingDocumentMapper"))) {
			$inst->set('IncomingDocumentMapper', new \mapper\IncomingDocumentMapper());
		}
		return $inst->get("IncomingDocumentMapper");
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