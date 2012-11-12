<?php

require_once "Survey.php";
require_once "Answer.php";

class SurveyController extends BaseController
{
	public function __construct(Application $application)
	{
		parent::__construct($application);
		$this->template = "survey";
		
		if (!$this->session->getValue("survey_id")) {
			$this->session->setValue("survey_id", 1);
			$this->session->setValue("answers", array());
		}
		
		$this->survey = Survey::find($this->session->getValue("survey_id"));
	}
	
	public function run(array $params)
	{
		if (!$this->session->isAuthenticated()) {
			die("You˚re not logged in!");
		}
		
		if (isset($params["survey_cancel"])) {
			$this->session->logout();
			$this->redirect("/");
		} else if (isset($params["survey_submit"])) {
			if (isset($params["answers"]) && count($params["answers"]) > 0) {
				if ($this->survey->getType() == "single") {
					$params["answers"] = array_slice($params["answers"], 0, 1);
				}	
							
				$this->session->setValue("answers", array_merge($this->session->getValue("answers"), $params["answers"]));
				$this->session->setValue("survey_id", $this->session->getValue("survey_id") + 1);
				
				if ($this->session->getValue("survey_id") > 2) { /* hardcode :S */
					$this->finish();
				}
				
				$this->redirect("/");
			} else {
				$this->notices[] = "missing_user_input";
			}
		}
		
		parent::render();
	}
	
	protected function finish()
	{
		$account = $this->session->getAccount();
		
		foreach ($this->session->getValue("answers") as $value)
		{
			$answer = new Answer($account->getId(), $value);
			$answer->save();
		}
		
		$account->setVoted(true);
		$account->save();
		
		$this->session->logout();
		$this->session->setValue("voting_done", true);
	}
}

?>
