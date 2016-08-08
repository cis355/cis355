<?php
session_start();
$_SESSION['name'] = ''; 
$_SESSION['cust_id'] = ''; 
session_destroy();
header("Location: se_login.php"); // redirect
?>