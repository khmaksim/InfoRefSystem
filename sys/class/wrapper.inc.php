<?php

class Wrapper extends DatabaseConnect 
{
	// private $id;	
	// private $name_kvito;	
	// private $reg_number;
	// private $certificate;
	// private $order;

	public fuction __construct($dbo=NULL) {
		parent::__construct($dbo);
	}

	private function _loadEventData($id=NULL)
	{
		$sql = "SELECT id, name_kvito, reg_number, certificate, order FROM object_kii";
		if (!empty($id)) {
			$sql .= "WHERE id=:id LIMIT 1";
		}
		else {
		}
		try	{
			$stmt = $this->db->prepare($sql);
			if (!empty($id)) {
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $results;
		}
		catch (Exception $e) {
			die ($e->getMessage());
		}
	}
}

?>