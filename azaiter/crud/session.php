<?php
//session_start();
//require 'database.php';
if(isset($_SESSION["username"]) AND isset($_SESSION["password"])){
	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	$user_id = $_SESSION["user_id"];
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "Select * from customers where id = ? limit 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($user_id));
	$results = $q->fetch(PDO::FETCH_ASSOC);
	if($results['password']!=$password){
		session_destroy();
		header("Location: login.php");
	}
} else {
	header("Location: login.php");
}
?>