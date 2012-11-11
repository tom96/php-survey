<?php

require_once "Account.php";

class Session
{
	protected $account;
	
	public function __construct()
	{
		session_start();
		$this->account = Account::find($this->getValue("account_id"));		
	}
	
	public function destroy()
	{
		session_destroy();		
	}

	public function getValue($key)
	{
		return $_SESSION[$key];		
	}

	public function setValue($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	public function login($account)
	{
		$this->setValue("logged_in", true);
		$this->setValue("account_id", $account->getId());
		$this->setValue("account_password", $account->getPasswordHash());
		$this->setValue("survey_id", 1);
	}
	
	public function logout()
	{
		$this->setValue("logged_in", false);
	}
	
	public function isAuthenticated()
	{
		/* TODO: Check whether account_name and account_password are the same as in the database */
		return $this->getValue("logged_in") == true;		
	}
	
	public function getAccount()
	{
		return $this->account;
	}
};
?>
