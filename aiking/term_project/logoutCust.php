<?php
session_start();
$_SESSION['name'] = "";
header("Location: home.html"); //redirect
session_destroy();
?>