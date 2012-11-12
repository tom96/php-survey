<?php

require_once "Record.php";
require_once "Session.php";

require_once "BaseController.php";
require_once "LoginController.php";
require_once "SurveyController.php";

class Application
{	
	protected $config;
	protected $database;
	protected $session;
	protected $controller;
	
	public function __construct($config)
	{
		$this->config = $config;
	}
	
	public function run()
	{
        $driver_options = array();

        if ($this->config['db_pconnect']) {
            $driver_options[PDO::ATTR_PERSISTENT] = true;
        }

        if ($this->config['db_charset'] == 'utf8') {
            $driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
        }

		$this->database = new PDO($this->config['db_dsn'], $this->config['db_user'], $this->config['db_pass'], $driver_options);
		$this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		Record::setDatabase($this->database);
		
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
