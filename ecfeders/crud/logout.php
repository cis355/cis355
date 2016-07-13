<?php
	session_start();
	if(empty($_SESSION['name'])) header("Location: login.php"); // redirect 
?>

<?php
	session_start();
	$_SESSION['name'] = "";
	header("Location: login.php"); // redirect
	session_destroy();
?>