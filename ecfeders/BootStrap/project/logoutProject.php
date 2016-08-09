<?php
/* *******************************************************************  
* filename     : logoutProject.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php file logouts the user
 *  
 * processing   : The program steps are as follows.   
 *          1. set session varibale to nothing 
 
 * output       : logout user
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: actions based on button clicks
 * *******************************************************************   */ 
 ?>
<?php
    //Set session to nothing and redirect
	session_start();
	$_SESSION['name'] = "";
	header("Location: loginProject.php"); // redirect
	session_destroy();
?>