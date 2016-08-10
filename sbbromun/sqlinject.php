<?php 
$name = $_POST['name']; 
$name2 = $_POST['name2'];
require ('crud/database.php'); 
$pdo = Database::connect(); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if (!empty($name)) {
	$sql = "INSERT INTO customers (name) VALUES ('$name')"; 
	$q = $pdo->prepare($sql); 
	$q->execute(array($name));
}
else
{$sql = "INSERT INTO customers (name) VALUES (?)"; 
$q = $pdo->prepare($sql); 
$q->execute(array($name2));
}

Database::disconnect(); 

/* hackstring 
INSERT INTO customers (name) VALUES ('$name 
Zippydee'); INSERT INTO customers (name) VALUES ('George 
') 
*/ 
?>