<?php
/* *******************************************************************
* filename : logout.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : logs the user out (clears the session variables)
*
* Structure: PHP:
              starts session
              clears variables
              redirects to login.php
              destroys session

* precondition : N/A
* postcondition: session and variables are destroyed, and user returns
                  to login.php
*
* Code adapted from George Corser
* *******************************************************************/
  session_start();
  $_SESSION['username'] = "";
  $_SESSION['id'] = "";
  header("Location: login.php"); // redirect
  session_destroy();
?>