<?php
session_start();
$_SESSION['name'] = ""; 
header("Location: se_login.php"); // redirect
session_destroy();
?>