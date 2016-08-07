<?php
/* *******************************************************************
 filename     : Logout.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to log a user out of the website
Input         : n/a

Process:
1. null the session variables
2. redirect to the login page
3. destroy the session
Output: destroyed session
Precondition: user must be logged in
Postcondition: user is now logged out and must log back in to reaccess the system
*********************************************************************  */
session_start();
$_SESSION['name'] = ""; 
$_SESSION['TableType'] = "";
$_SESSION['YourProfile'] = "";
header("Location: Login.php"); // redirect
session_destroy();
?>