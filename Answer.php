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
		$stmt = Record::getDatabase()->prepare("INSERT INTO answers (account_id, option_id) VALUES (?, ?)");
		
		if (!$stmt) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;			
		}
	
		$stmt->bind_param("dd", $this->account_id, $this->option_id);
		
		if (!$stmt->execute()) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;
		}
		
		$this->id = Record::getDatabase()->insert_id;
		
		return $this;
	}
}

?>
