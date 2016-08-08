
<?php
/* *******************************************************************  
* filename     : session.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : 
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. start session
*		   2. check session
*		   3. redirect if session does not exist
* output       : none  
*  
* precondition : user is logged in
* postcondition: session is checked
* *******************************************************************
*/
   include('database.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select name from customers where name = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['name'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>