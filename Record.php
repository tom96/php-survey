<?php

class Record
{
	protected $id;
	protected static $database;
	
	protected $fields;
	
	public static function getDatabase()
	{
		return self::$database;
	}
	
	public static function setDatabase($database)
	{
		self::$database = $database;		
	}

	public function getId()
	{
		return $this->id;
	}
}

?>
