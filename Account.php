<?php

class Account extends Record
{
	protected $email;
	protected $password_hash;
	protected $took_survey;
	
	public static function findbyCredentials($email, $password)
	{	
		$record = new self;
		
		$stmt = Record::getDatabase()->prepare("SELECT id, email, password, took_survey FROM accounts WHERE email = ? AND password = ?");
		
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
		
		$stmt->bind_result($record->id, $record->email, $record->password_hash, $record->took_survey);
		
		if (!$stmt->fetch()) {
			return false;
		}
		
		$stmt->close();
		
		return $record;
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getPasswordHash()
	{
		return $this->password_hash;
	}
	
	public function isSurveyTaken()
	{
		return $this->took_survey;
	}
}

?>
