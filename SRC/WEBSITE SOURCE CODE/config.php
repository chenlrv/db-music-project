<?php
 
	$server_name = "mysqlsrv.cs.tau.ac.il";
	$user_name = "DbMysql02";
	$password = "DbMysql02";
	$db_name = "DbMysql02"; 


	//create connection
	 $mysqli = new mysqli($server_name, $user_name, $password, $db_name);

	//check connection
	$mysqli->init();
	$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 600);
	$mysqli->real_connect($server_name,$user_name,$password,$db_name);
	if ($mysqli->connect_error) {
		die("Connection failed: ". $mysqli->connect_error);
	}

	//genereal run query function
	function run_query($sql_query){
		if (!$result = $GLOBALS['mysqli']->query($sql_query)){
			die('There was an error running check the query [' . $GLOBALS['mysqli']->error . ']');
		}
		return $result;
	}

?>