<?php
#check if the session['name'] is empty, if so redirect to the login page
session_start();
if (empty($_SESSION['name'])) header("Location: Login.php"); // redirect
?>