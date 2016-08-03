<?php
session_Start();
$_SESSION['name'] = "";

header("Location: login.php");
session_destroy();
?>