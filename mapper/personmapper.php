<?php
namespace mapper;

class PersonMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM person");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM person WHERE id = ?");
		$this->updateStmt = self::$PDO->prepare("UPDATE person SET firstname=?, lastname=?, patronymic=?, military=?, personalnumber=?, birthday=?, id_accesslevel=?, id_unit=?, id_department=?, editable=?, id_militaryrank=?, img_ext=?, address=?, id_city=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO person (firstname, lastname, patronymic, military, personalnumber, birthday, id_accesslevel, id_unit, id_department, editable, id_militaryrank, img_ext, address, id_city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	}

	function getCollection(array $raw) {
        return new PersonCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\Person($array['id']);
		$obj->firstname = $array['firstname'];	
		$obj->lastname = $array['lastnam'];
		$obj->patronymic = $array['patronymic'];
		$obj->military = $array['military'];
		$obj->personalnumber = $array['personalnumber'];
		$obj->birthday = $array['birthday'];
		$obj->id_accesslevel = $array['id_accesslevel'];
		$obj->id_unit = $array['id_unit'];
		$obj->id_department = $array['id_department'];
		$obj->editable = $array['editable'];
		$obj->id_militaryrank = $array['id_militaryrank'];
		$obj->img_ext = $array['img_ext'];
		$obj->address = $array['address'];
		$obj->id_city = $array['id_city'];
		$obj->note = $array['note'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Person)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->firstname, $object->lastname, $object->patronymic, $object->military, $object->personalnumber, $object->birthday, $object->id_accesslevel, $object->id_unit, $object->id_department, $object->editable, $object->id_militaryrank, $object->img_ext, $object->address, $object->id_city, $object->note);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->firstname, $object->lastname, $object->patronymic, $object->military, $object->personalnumber, $object->birthday, $object->id_accesslevel, $object->id_unit, $object->id_department, $object->editable, $object->id_militaryrank, $object->img_ext, $object->address, $object->id_city, $object->note, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

	public function display($id=NULL)
	{
		if (empty($id) || $id == NULL)
			$objectkii = new ObjectKii();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$objectkii = $this->_loadObjectKiiById($id);
		}
		
		return '
			<div class="form-group">
				<label for="exampleInputNameKVITO">Наименование КВИТО</label>
				<input type="text" name="name_kvito" class="form-control" id="exampleInputNameKVITO" placeholder="Наименование КВИТО" value="' . $objectkii->name_kvito . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="exampleInputRegNumber">Регистрационный номер</label>
				<input type="text" name="reg_number" class="form-control" id="exampleInputRegNumber" placeholder="Регистрационный номер" value="' . $objectkii->reg_number . '">
			</div>
			<div class="form-group">
				<label for="exampleInputAttestat">Аттестат</label>
				<input type="text" name="certificate" class="form-control" id="exampleInputAttestat" placeholder="Аттестат" value="' . $objectkii->certificate . '">
			</div>
			<div class="form-group">
				<label for="exampleInputOrder">Приказ</label>
				<input type="text" name="order" class="form-control" id="exampleInputOrder" placeholder="Приказ" value="' . $objectkii->order . '">
			</div>
		';
	}
}

?>