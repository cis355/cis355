<?php
  session_start();
  $_SESSION['username'] = "";
  header("Location: login.php");
  session_destroy();
?>