<?php

class Answer extends Record
{
	protected $account_id;
	protected $option_id;
	
	public function __construct($account_id, $option_id)
	{
		$this->account_id = $account_id;
		$this->option_id = $option_id;		
	}
	
	public function save()
	{
		$stmt = Record::getDatabase()->prepare("INSERT INTO answers (account_id, option_id) VALUES (:account_id, :option_id)");
		
		$stmt->bindParam(":account_id", $this->account_id, PDO::PARAM_INT);
		$stmt->bindParam(":option_id", $this->option_id, PDO::PARAM_INT);
		
		$stmt->execute();
		
		$this->id = Record::getDatabase()->lastInsertId();
		
		return $this;
	}
}

?>
