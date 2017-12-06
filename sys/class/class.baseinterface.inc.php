<?php

abstract class BaseInterface extends DatabaseConnect 
{
	public function __construct($dbo=NULL)
	{
		parent::__construct($dbo);
	}

	protected function _createObject($nameclass_object)
	{
		$arr = $this->_loadData(NULL);
		$objects = array();
		foreach ($arr as $obj) {
			try {
				array_push($objects, new $nameclass_object($obj));
			}
			catch (Exception $e) {
				die ($e->getMessage());
			}
		}
		return $objects;
	}

	public function _loadByid($nameclass_object, $id)
	{
		if (empty($id))
			return NULL;

		$object = $this->_loadData($id);

		if (isset($object[0])) {
			return new $nameclass_object($object[0]);
		}
		else
			return NULL;
	}
}

?>