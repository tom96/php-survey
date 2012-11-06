<?php

abstract class BaseController
{
	protected $template;
	protected $session;
	
	public function __construct($session)
	{
		$this->session = $session;		
	}
	
	public abstract function run(array $params);
	
	public function render()
	{
		include "layout.phtml";	
	}
};

?>
