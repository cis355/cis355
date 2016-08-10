<?php
session_start();
$_SESSION['name'] = ""; 
header("Location: loginelite.php"); // redirect
session_destroy();
?>