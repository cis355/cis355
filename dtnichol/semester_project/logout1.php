<?php
//user logout
session_start();
$_SESSION['id'] = "";
header("Location: login1.php"); //redirect
session_destroy();
?>