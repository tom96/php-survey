<?php

class Survey extends Record
{
	protected $question;
	protected $options;
	
	public static function find($id)
	{
		$stmt = Record::getDatabase()->prepare("SELECT id, question FROM surveys WHERE id = ?");
		
		if ($stmt) {
			$record = new self;
			
			$stmt->bind_param("d", $id);
			$stmt->execute();
			$stmt->bind_result($record->id, $record->question);
			$stmt->fetch();
			$stmt->close();
			
			if ($record->loadOptions()) {
				return $record;
			}
		}
		
		return false;
	}
	
	protected function loadOptions()
	{
		$this->options = array();
		$option_id;
		$option_text;
		
		$stmt = Record::getDatabase()->prepare("SELECT id, text FROM options WHERE survey_id = ?");
		
		if ($stmt) {
			$stmt->bind_param("d", $this->id);
			$stmt->execute();
			$stmt->bind_result($option_id, $option_text);
			
			while ($stmt->fetch()) {
				$this->options[$option_id] = $option_text;
			}
			
			$stmt->close();
			
			return true;
		}
		
		return false;
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
