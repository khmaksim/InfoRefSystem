<?php
namespace command;
require_once('base/Exceptions.php');

abstract class Command {
	 private static $STATUS_STRINGS = array (
        'CMD_DEFAULT'=>0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3
    );
	private $status = 0;

	final function __construct() {}

	function execute(\controller\Request $request) {
		$this->status = $this->doExecute($request);
		$request->setCommand($this);
	}

	function getStatus() {
		return $this->status;
	}

	static function statuses($str='CMD_DEFAULT') {
		if (isset(self::$STATUS_STRINGS[$str]))
			return self::$STATUS_STRINGS[$str];
		throw new \base\AppException("Unknown status code: $str");
		
	}
	abstract function doExecute(\controller\Request $request);
}
?>