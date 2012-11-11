<?php

require_once "Survey.php";
require_once "Answer.php";

class SurveyController extends BaseController
{
	public function __construct(Application $application)
	{
		parent::__construct($application);
		$this->template = "survey";
		
		$this->survey = Survey::find($this->session->getValue("survey_id"));
	}
	
	public function run(array $params)
	{
		if (!$this->session->isAuthenticated()) {
			die("You˚re not logged in!");
			/* TODO: Make this error message more beautiful */		
		}
		
		if ($params["survey_cancel"]) {
			$this->session->logout();
			$this->redirect("/");
		} else if ($params["survey_submit"]) {
			if (count($params["answer"]) > 0) {
				foreach ($params["answer"] as $key => $value)
				{
					$answer = new Answer($this->survey->getId(), $key);
					$answer->save();
				}
				
				$this->session->setValue("survey_id", $this->session->getValue("survey_id") + 1);
				
				if ($this->session->getValue("survey_id") > 2) { /* hardcode :S */
					$this->session->getAccount()->setVoted(true);
					$this->session->getAccount()->save();
					$this->session->logout();
					
					$this->session->setValue("voting_done", true);
				}
				
				$this->redirect("/");
			} else {
				$this->notices[] = "missing_user_input";
			}
		}
		
		parent::render();
	}
}

?>
