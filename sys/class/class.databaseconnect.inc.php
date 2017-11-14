<?php
abstract class DatabaseConnect {
	protected $db;

	protected function __construct($db=NULL)
	{
		if (is_object($db)) {
			$this->db = $db;
		}
		else {
			$dsn = "pgsql:host=". DB_HOST .";port=". DB_PORT .";dbname=". DB_NAME;
			try {
				$this->db = new PDO($dsn, DB_USER, DB_PASS);
			}
			catch (PDOException $e) {
				die ($e->getMessage());
			}
		}
	}
}
?>