<?php

require_once "Account.php";

class LoginController extends BaseController
{
	public function __construct(Application $application)
	{
		parent::__construct($application);
		$this->template = "login";
	}
	
	public function run(array $params)
	{
		if ($this->session->isAuthenticated()) {
			die("You are already logged in!");
			/* TODO: Make this error message more beautiful */			
		}
		
		if ($this->session->getValue("voting_done") == true) {
			$this->session->setValue("voting_done", false);
			$this->notices[] = "voting_done";
		}
		
		$this->account_name = $params["account_name"];
		$this->account_password = $params["account_password"];
		
		if (isset($params["account_name"]) && isset($params["account_password"])) {
			$account = Account::findByCredentials($params["account_name"], $params["account_password"]);
			
			if ($account) {
				if ($account->hasVoted()) {
					$this->notices[] = "already_voted";
				} else {
					$this->session->login($account);
					$this->redirect("/");
				}			
			} else {
				$this->notices[] = "invalid_credentials";
			}
		}
				
		parent::render();
	}
}

?>
