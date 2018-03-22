<?php
namespace mapper;

class IncomingDocumentMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM incoming_document WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM incoming_document WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE incoming_document SET number_in=?, date_registration=?, number_primary=?, date_primary=?, senders_numbers=?, security_label=?, number_sheets=?, copies=?, copies_numbers=?, subject=?, order=?, instructions=?, note=?, control=?, out_where=?, out_details=?, out_datename=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO incoming_document (number_in, date_registration, number_primary, date_primary, senders_numbers, security_label, number_sheets, copies, copies_numbers, subject, \"order\", instructions, note, control, out_where, out_details, out_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE incoming_document SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new IncomingDocumentCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\IncomingDocument($array['id']);
		$obj->number_in = $array['number_in'];
	    $obj->date_registration = $array['date_registration'];
	    $obj->number_primary = $array['number_primary'];
	    $obj->date_primary = $array['date_primary'];
	    $obj->senders_numbers = $array['senders_numbers'];
	    $obj->security_label = $array['security_label'];
	    $obj->number_sheets = $array['number_sheets'];
	    $obj->copies = $array['copies'];
	    $obj->copies_numbers = $array['copies_numbers'];
	    $obj->subject = $array['subject'];
	    $obj->order = $array['order'];
	    $obj->instructions = $array['instructions'];
	    $obj->note = $array['note'];
	    $obj->control = $array['control'];
	    $obj->out_where = $array['out_where'];
	    $obj->out_details = $array['out_details'];
	    $obj->out_date = $array['out_date'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\IncomingDocument)) {
			throw new \base\AppException("Error argument", 1);
		}
			
		$values = array($object->number_in, $object->date_registration, $object->number_primary, $object->date_primary, $object->senders_numbers, $object->security_label, $object->number_sheets, $object->copies, $object->copies_numbers, $object->subject, $object->order, $object->instructions, $object->note, $object->control, $object->out_where, $object->out_details, $object->out_date);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name, $object->section, $object->file_name, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function delete(\domain\DomainObject $object) {
    	$values = array($object->id);
		$this->deleteStmt->execute($values);
    }
}

?>