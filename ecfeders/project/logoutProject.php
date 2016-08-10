<?php
	session_start();
	$_SESSION['name'] = "";
	header("Location: loginProject.php"); // redirect
	session_destroy();
?>