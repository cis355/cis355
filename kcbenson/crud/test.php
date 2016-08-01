<?php

	session_start();
	$_SESSION['name'] = "";
	header("Location: test.php"); //redirect
	session_destroy();

header("Location: index.php");
?>