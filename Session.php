<?php

require_once "Account.php";

class Session
{
	protected $account;
	
	public function __construct()
	{
		session_start();
		
		if ($this->getValue("logged_in")) {
			$this->account = Account::find($this->getValue("account_id"));
		}
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
	}
	
	public function logout()
	{
		session_destroy();
		session_start();
	}
	
	public function getAccount()
	{
		return $this->account;
	}
	
	public function isAuthenticated()
	{
		return (bool)$this->account;
	}
};
?>
