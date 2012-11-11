<?php

abstract class BaseController
{
	protected $template;
	protected $session;
	protected $notices;
	
	public function __construct(Application $application)
	{
		$this->application = $application;
		$this->session = $application->getSession();
		$this->notices = array();		
	}
	
	public abstract function run(array $params);
	
	public function render()
	{
		function escape($string)
		{
			return @htmlentities($string, ENT_COMPAT | ENT_HTML5);
		}
		
		include "layout.phtml";	
	}
	
	public function redirect($target)
	{
		$this->application->redirect($target);
	}
};

?>
