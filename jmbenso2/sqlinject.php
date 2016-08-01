<?php 
	require('crud_tdg/database.php');
	$name = $_POST['name'];
	$name2 = $_POST['name2'];

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set attributes of connection (error mode)
	
	// Allows sql injection:
	if (!empty($name)) { // If name1 is given, execute the unbound statement
		// hack string to execute:
		$sql = "INSERT INTO customers (name) values('$name
		')";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
	}
	
	// Disallows sql injection:
	else { // If name1 not given, use name2 and bind it to the ?
		// string to execute
		$sql = "INSERT INTO customers (name) values(?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name2));
		
	}
	
	Database::disconnect();
	
	show_source(__FILE__);
?>