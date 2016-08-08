<?php 

require "database.php"; 

if (!empty($_POST))
{
$name = $_POST['name']; 
$pdo = Database::connect(); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
$sql = "INSERT INTO customers (name) VALUES ('$name')"; 
$q = $pdo->prepare($sql); 
$q->execute(array($name)); 
Database::disconnect(); 
}

?>


