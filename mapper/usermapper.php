<?php
namespace mapper;

class UserMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT u.id, u.name, u.active, u.title, u.bdate, u.adate, u.img_ext, u.passwd, a.col, a.unban, r.id AS id_role, r.title AS role_title 
			FROM public.user u 
			LEFT OUTER JOIN antibrutforce a ON u.id = a.id_user AND a.deleted IS NULL 
			LEFT OUTER JOIN role r ON u.role_id = r.id 
			WHERE u.deleted IS NULL ORDER BY u.name");
		$this->selectStmt = self::$PDO->prepare("SELECT  u.id, u.name, u.active, u.title, u.bdate, u.adate, u.img_ext, u.passwd, a.col, a.unban, r.id AS id_role, r.title AS role_title  
			FROM public.user u 
			LEFT OUTER JOIN antibrutforce a ON u.id = a.id_user AND a.deleted IS NULL 
			LEFT OUTER JOIN role r ON u.role_id = r.id 
			WHERE u.deleted IS NULL AND u.id = ?");
		$this->updateStmt = self::$PDO->prepare("UPDATE public.user SET name=?, active=?, title=?, bdate=?, adate=?, img_ext=?, passwd=? WHERE id=?");
		$this->updateAntibrutforceStmt = self::$PDO->prepare("UPDATE antibrutforce SET col=?, unban=? WHERE id_user=? AND deleted IS NULL");
		$this->insertAntibrutforceStmt = self::$PDO->prepare("INSERT INTO antibrutforce (col, id_user) VALUES (?, ?)");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO public.user (name, active, title, bdate, adate, img_ext, passwd) VALUES(?, ?, ?, ?, ?, ?, ?)");
		$this->insertLoginStmt = self::$PDO->prepare("INSERT INTO public.user_login (user_id, success, ldate) VALUES(?, ?, date('Y-m-d H:i:s'))");
		$this->deleteAntibrutforceStmt = self::$PDO->prepare("UPDATE antibrutforce SET deleted=now() WHERE id_user=? AND deleted IS NULL");
		$this->deleteStmt = self::$PDO->prepare("UPDATE public.user SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new UserCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\User($array['id']);
		$obj->name = $array['name'];
		$obj->active = $array['active'];
  		$obj->title = $array['title'];
  		$obj->bdate = $array['bdate'];
  		$obj->adate = $array['adate'];
  		$obj->img_ext = $array['img_ext'];
  		$obj->passwd = $array['passwd'];
		$obj->num_login = $array['col'];
		$obj->ban_before_day = $array['unban'];
		$obj->role = $array['role_title'];
		$obj->id_role = $array['id_role'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\User)) {
			throw new \base\AppException("Error argument", 1);
		}
			
		$values = array($object->name, $object->active, $object->title, $object->bdate, $object->adate, $object->img_ext, $object->passwd);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function insertLogin(\domain\DomainObject $object) {
		if (!($object instanceof \domain\User)) {
			throw new \AppException("Error argument", 1);
		}
		$values = array($object->id, $object->success_login);
		$this->insertLoginStmt->execute($values);
	}

	function insertAntibrutforce(\domain\DomainObject $object) {
		if (!($object instanceof \domain\User)) {
			throw new \AppException("Error argument", 1);
		}
		$values = array($object->num_login, $object->id);
		$this->insertAntibrutforceStmt->execute($values);
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name, $object->active, $object->title, $object->bdate, $object->adate, $object->img_ext, $object->passwd, $object->id);
		$this->updateStmt->execute($values);
	}

	function updateAntibrutforce(\domain\DomainObject $object) {
		$values = array($object->num_login, $object->ban_before_day, $object->id);
		$this->updateAntibrutforceStmt->execute($values);
	}
	
	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function deleteAntibrutforce(\domain\DomainObject $object) {
    	$values = array($object->id);
		$this->deleteAntibrutforceStmt->execute($values);
    }

    function delete(\domain\DomainObject $object) {
    	$values = array($object->id);
		$this->deleteStmt->execute($values);
    }
}

?>