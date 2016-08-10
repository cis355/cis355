<?php

session_start();
if (empty($_SESSION['name'])) header("Location: CRUD/login.php"); //redirect
else
	header("Location: CRUD/login.php")

?>