<?php
	
	///////////////// These will eventually be stored in an ini file and parsed ///////////////////
	define("MYSQL_DEFAULT_HOST", "localhost");
	define("MYSQL_DEFAULT_USER", "root");
	define("MYSQL_DEFAULT_PASS", "");
	define("MYSQL_DEFAULT_DATABASE", "erdos");
	
	//Registration options
	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");

	
	//DB PBO options
	define("DEFAULT_MYSQL_ATTR_INIT_COMMAND","SET NAMES utf8");
	
	//DB PDO attributes
	define("DEFAULT_ATTR_ERRMODE", PDO::ERRMODE_EXCEPTION);
	define("DEFAULT_ATTR_EMULATE_PREPARES", false);
	
	///////////////////////////////////////////////////////////////////////////////////////////////

	try {
		$DBH = new PDO( 'mysql:dbname=' . MYSQL_DEFAULT_DATABASE .
							';host=' . MYSQL_DEFAULT_HOST,
							MYSQL_DEFAULT_USER,
							MYSQL_DEFAULT_PASS );						
		$DBH->setAttribute( PDO::ATTR_ERRMODE, DEFAULT_ATTR_ERRMODE);
		$DBH->setAttribute( PDO::ATTR_EMULATE_PREPARES, DEFAULT_ATTR_EMULATE_PREPARES );
	}
	catch(PDOException $e) 
	{
		file_put_contents( dirname(__FILE__) . '/../log/PDOErrors_' . MYSQL_DEFAULT_DATABASE . '.txt', $e->getMessage(),FILE_APPEND);
	}