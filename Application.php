<?php

require_once "Application.php";
require_once "Record.php";
require_once "Session.php";

require_once "BaseController.php";
require_once "LoginController.php";
require_once "SurveyController.php";

class Application
{
	protected $session;
	protected $database;
	protected $controller;
	protected $db_config;
	
	public function __construct($db_config)
	{
		$this->db_config = $db_config;
	}
	
	public function __destruct()
	{
		$this->database->close();
	}
	
	public function run()
	{
		$this->database = new mysqli($this->db_config["host"], $this->db_config["user"],
							$this->db_config["password"], $this->db_config["database"]);

		Record::setDatabase($this->database);

	    if ($this->database->connect_errno) {
			throw new Exception($this->database->connect_error);
	    }

		$this->session = new Session();

		if ($this->session->isAuthenticated()) {
			$this->controller = new SurveyController($this);
		} else {
			$this->controller = new LoginController($this);
		}

		$this->controller->run(array_merge($_POST, $_GET));
	}
	
	public function redirect($target)
	{
		header("Location: http://" . $_SERVER["HTTP_HOST"] . $target);
		exit(0);
	}
	
	public function getSession()
	{
		return $this->session;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getDatabase()
	{
		return $this->database;
	}
};

?>
