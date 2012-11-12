<?php

$paths = array(
	"./core",
	"./models",
	"./views",
	"./controllers"	
);

set_include_path(get_include_path() . ":" . implode(":", $paths));

require_once "Application.php";

$config = array (
	"db_dsn"		=> "mysql:dbname=survey_test;host=localhost",
	"db_user"		=> "root",
	"db_pass"		=> "",
	"db_pconnect"	=> true,
	"db_charset"	=> "utf8"
);

$application = new Application($config);
$application->run();

?>
