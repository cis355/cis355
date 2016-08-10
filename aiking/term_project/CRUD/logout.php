<?php
session_start();
$_SESSION['name'] = "";
header("Location: ../index.html"); //redirect
session_destroy();
?>