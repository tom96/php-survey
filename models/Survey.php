<?php

class Survey extends Record
{
	protected $question;
	protected $options;
	
	public static function find($id)
	{
		$stmt = Record::getDatabase()->prepare("SELECT id, question FROM surveys WHERE id = :id");
		
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		$stmt->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		$stmt->execute();

		return $stmt->fetch()->loadOptions();
	}
	
	protected function loadOptions()
	{
		$this->options = array();
		
		$stmt = Record::getDatabase()->prepare("SELECT id, text FROM options WHERE survey_id = :survey_id");
		
		$stmt->bindParam(":survey_id", $this->id, PDO::PARAM_INT);
		$stmt->execute();
		
		while ($option = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->options[$option["id"]] = $option["text"];
		}
		
		return $this;
	}
	
	public function getQuestion()
	{
		return $this->question;
	}
	
	public function getOptions()
	{
		return $this->options;
	}
}

?>
