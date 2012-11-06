<?php
	require_once "Record.php";
	require_once "Session.php";
	
	require_once "BaseController.php";
	require_once "LoginController.php";
	require_once "SurveyController.php";
	
	$database_config = array (
		"host"		=> "localhost",
		"user"		=> "root",
		"password"	=> "",
		"database" 	=> "survey_test"
	);
	
	$database = new mysqli($database_config["host"], $database_config["user"],
							$database_config["password"], $database_config["database"]);

	Record::setDatabase($database);

    if ($database->connect_errno) {
		throw new Exception($database->connect_error);
    }

	$session = new Session();
	
	if ($session->isAuthenticated()) {
		$controller = new SurveyController($session);
	} else {
		$controller = new LoginController($session);
	}
	
	$controller->run(array_merge($_POST, $_GET));
	
	$database->close();
?>
