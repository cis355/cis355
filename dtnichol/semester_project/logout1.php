 <!--/* *******************************************************************
* filename : logout.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : user logsout of session				                 
*               
*
* input : none
* processing : The program steps are as follows.
* 		1. user logouts when button is clicked
* 		
* 		
* 		
* output : none
*
* precondition : user must be already logged in to logout
* postcondition: kicked back to login screeen
* 				 
* *******************************************************************
*/-->

<?php
//user logout
session_start();
$_SESSION['id'] = "";
header("Location: login1.php"); //redirect
session_destroy();
?>