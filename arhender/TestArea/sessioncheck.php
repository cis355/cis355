<?php
session_start();
if (empty($_SESSION['name'])) header("Location: Login.php"); // redirect
?>