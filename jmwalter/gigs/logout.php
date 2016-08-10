<?php 
/* *******************************************************************
* filename : logout.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this is the logout page for gigs 
*
* purpose: this allows a user to completely logout from the system and removes the saved session variablse 
*
* input : none
*
* processing : 
* 1. empties the session variables for gigsUserName and gigsUserId
* 
* output : none
*
* precondition : user must be logged in to log out .. go figure...
* *******************************************************************
*/
session_start();
$_SESSION['gigsUserName'] = '';
$_SESSION['gigsUserId'] = '';
header("Location: index.php");

?>