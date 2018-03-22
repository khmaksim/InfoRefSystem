<?php
namespace domain;

class IncomingDocument extends DomainObject {
	public $id;
    public $number_in;
    public $date_registration;
    public $number_primary;
    public $date_primary;
    public $senders_numbers;
    public $security_label;
    public $number_sheets;
    public $copies;
    public $copies_numbers;
    public $subject;
    public $order;
    public $instructions;
    public $note;
    public $control;
    public $out_where;
    public $out_details;
    public $out_date;

	function __construct($id=null, $number_in=null, $date_registration=null, $number_primary=null, $date_primary=null, $senders_numbers=null, $security_label=null, $number_sheets=null, $copies=null, $copies_numbers=null, $subject=null, $order=null, $instructions=null, $note=null, $control=null, $out_where=null, $out_details=null, $out_date=null) {
		$this->id = $id;
	    $this->number_in = $number_in;
	    $this->date_registration = $date_registration;
	    $this->number_primary = $number_primary;
	    $this->date_primary = $date_primary;
	    $this->senders_numbers = $senders_numbers;
	    $this->security_label = $security_label;
	    $this->number_sheets = $number_sheets;
	    $this->copies = $copies;
	    $this->copies_numbers = $copies_numbers;
	    $this->subject = $subject;
	    $this->order = $order;
	    $this->instructions = $instructions;
	    $this->note = $note;
	    $this->control = $control;
	    $this->out_where = $out_where;
	    $this->out_details = $out_details;
	    $this->out_date = $out_date;
	}
}
?>