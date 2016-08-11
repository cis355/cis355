<?php
/* ***************************************************************************************************************
 filename     : logoutelite.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file gets the username of the user logging in, and set it to null
				
PURPOSE 	  : This logs the current user out of the system	
INPUT		  : NONE
PRE     	  : There must be a suer logged into the system
OUTPUT		  : sussesfull loggout
POST		  : Redirected to the log in page and name set to null
*****************************************************************************************************************/
session_start();
$_SESSION['name'] = ""; 
header("Location: loginelite.php"); // redirect
session_destroy();
?>