<?php

require_once "Account.php";

class LoginController extends BaseController
{
	public function __construct($session)
	{
		parent::__construct($session);
		$this->template = "login";
	}
	
	public function run(array $params)
	{
		if ($this->session->isAuthenticated()) {
			die("You are already logged in!");
			/* TODO: Make this error message more beautiful */			
		}
		
		$this->account_name = $params["account_name"];
		$this->account_password = $params["account_password"];
		
		$this->login_failed = false;
		
		if (isset($params["account_name"]) && isset($params["account_password"])) {
			$account = Account::findByCredentials($params["account_name"], $params["account_password"]);
			
			if ($account) {
				$this->session->login($account);			
			} else {	
				$this->login_failed = true;
			}
		}
				
		parent::render();
	}
}

?>
