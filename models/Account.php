<?php

class Account extends Record
{
	protected $email;
	protected $password;
	protected $has_voted;
	
	public static function find($id)
	{
		$stmt = Record::getDatabase()->prepare("SELECT id, email, password, has_voted FROM accounts WHERE id = :id");
		
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	public static function findbyCredentials($email, $password)
	{
		$stmt = Record::getDatabase()->prepare("SELECT id, email, password, has_voted FROM accounts WHERE email = :email AND password = :password");
		
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":password", md5($password), PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	public function save()
	{
		$stmt = Record::getDatabase()->prepare("UPDATE accounts SET has_voted = :has_voted WHERE id = :id");
		
		$stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
		$stmt->bindParam(":has_voted", $this->has_voted, PDO::PARAM_BOOL);
		
		$stmt->execute();
		
		return $this;
	}
	
	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
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
