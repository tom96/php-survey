<?php

$paths = array(
	"./core",
	"./models",
	"./views",
	"./controllers"	
);

set_include_path(get_include_path() . ":" . implode(":", $paths));

require_once "Application.php";

$database_config = array (
	"host"		=> "localhost",
	"user"		=> "root",
	"password"	=> "",
	"database" 	=> "survey_test"
);

$application = new Application($database_config);
$application->run();

?>
