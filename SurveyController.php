<?php

require_once "Survey.php";
require_once "Answer.php";

class SurveyController extends BaseController
{
	public function __construct($session)
	{
		parent::__construct($session);
		$this->template = "survey";
	}
	
	public function run(array $params)
	{
		if (!$this->session->isAuthenticated()) {
			die("You˚re not logged in!");
			/* TODO: Make this error message more beautiful */		
		}
		
		if ($params["answer"]) {
			if (count($params["answer"]) > 0) {
				foreach ($params["answer"] as $key => $value)
				{
					$answer = new Answer(1, $key);
					$answer->save();
				}
			} else {
				$this->notice = "missing_user_input";
			}
		}
		
		$this->survey = Survey::find(1);
		
		parent::render();
	}
}

?>
