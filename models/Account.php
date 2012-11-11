<?php

class Account extends Record
{
	protected $email;
	protected $password_hash;
	protected $has_voted;
	
	public static function find($id)
	{
		$record = new self;
		
		$stmt = Record::getDatabase()->prepare("SELECT id, email, password, has_voted FROM accounts WHERE id = ?");
		
		if (!$stmt) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;			
		}
			
		$stmt->bind_param("d", $id);
		
		if (!$stmt->execute()) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;
		}
		
		$stmt->bind_result($record->id, $record->email, $record->password_hash, $record->has_voted);
		
		if (!$stmt->fetch()) {
			return false;
		}
		
		$stmt->close();
		
		return $record;
	}
	
	public static function findbyCredentials($email, $password)
	{	
		$record = new self;
		
		$stmt = Record::getDatabase()->prepare("SELECT id, email, password, has_voted FROM accounts WHERE email = ? AND password = ?");
		
		if (!$stmt) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;			
		}
			
		$stmt->bind_param("ss", $email, md5($password));
		
		if (!$stmt->execute()) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;
		}
		
		$stmt->bind_result($record->id, $record->email, $record->password_hash, $record->has_voted);
		
		if (!$stmt->fetch()) {
			return false;
		}
		
		$stmt->close();
		
		return $record;
	}
	
	public function save()
	{
		/* Update only! */
		
		$stmt = Record::getDatabase()->prepare("UPDATE accounts SET has_voted = ? WHERE id = ?");
		
		if (!$stmt) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;			
		}
	
		$stmt->bind_param("dd", $this->has_voted, $this->id);
		
		if (!$stmt->execute()) {
		    if (Record::getDatabase()->error) {
				throw new Exception(Record::getDatabase()->error);
		    }
			return false;
		}
		
		$this->id = Record::getDatabase()->insert_id;
		
		return $this;
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getPasswordHash()
	{
		return $this->password_hash;
	}
	
	public function hasVoted()
	{
		return $this->has_voted;
	}
	
	public function setVoted($value)
	{
		$this->has_voted = $value;		
	}
}

?>
