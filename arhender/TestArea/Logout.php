<?php
session_start();
$_SESSION['name'] = ""; 
$_SESSION['TableType'] = "";
$_SESSION['YourProfile'] = "";
header("Location: Login.php"); // redirect
session_destroy();
?>