<?php

require_once "Account.php";

class Session
{
	protected $account;
	
	public function __construct()
	{
		session_start();
		
		if ($this->getValue("account_id")) {
			$this->account = Account::find($this->getValue("account_id"));
		}
	}
	
	public function destroy()
	{
		session_destroy();
	}

	public function getValue($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return null;
		}
	}

	public function setValue($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	public function login($account)
	{
		$this->setValue("account_id", $account->getId());
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
