<?php

	$class = $_GET["class"];

	$db_hostname = "student.csc.liv.ac.uk";
	$db_database = "sghwill7";
	$db_username = "sghwill7";
	$db_password = "iwtbfdeacon";
	$db_charset = "utf8mb4";

	$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
	$opt = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
	);

	$pdo = new PDO($dsn,$db_username,$db_password,$opt);

	try
	{
		$stmt = $pdo->query("SELECT dayTime FROM Session WHERE
							cid = '{$class}' AND
							capacity >= 1");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo "<option value = '".$row['dayTime']."'>".$row['dayTime']."</option>";
		}
	   $pdo = NULL;
	}

	catch (PDOException $e)
	{
		exit("PDO Error: ".$e->getMessage()."<br>");
	}
	?>
