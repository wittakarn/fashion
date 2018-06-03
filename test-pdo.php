<?php

	$HOST="localhost";
	$USER="pousk";
	$PWD="Aikawa429010";
	$DBNAME="sedb";

	$dbh = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME, $USER, $PWD);
	$dbh->exec("SET names utf8");
	$dbh->exec("SET character_set_results=utf8");
	$dbh->exec("SET character_set_client='utf8'");
	$dbh->exec("SET character_set_connection='utf8'");

	$query = "SELECT version()";
		
	try {
		$stmt = $dbh->prepare($query); 
		$stmt->execute();
		$result = $stmt->fetch();
		echo $result["version()"];
	}catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

?>