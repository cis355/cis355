<!-- ========================================================================

   _____      _  __  __  ______            _       ______ __     __
  / ____|    | ||  \/  ||  ____|    /\    | |     |  ____|\ \   / /
 | |         | || \  / || |__      /  \   | |     | |__    \ \_/ / 
 | |     _   | || |\/| ||  __|    / /\ \  | |     |  __|    \   /  
 | |____| |__| || |  | || |____  / ____ \ | |____ | |____    | |   
  \_____|\____/ |_|  |_||______|/_/    \_\|______||______|   |_|   
   _____  _____   _____        ____   _____  _____                 
  / ____||_   _| / ____|      |___ \ | ____|| ____|                
 | |       | |  | (___  ______  __) || |__  | |__                  
 | |       | |   \___ \|______||__ < |___ \ |___ \                 
 | |____  _| |_  ____) |       ___) | ___) | ___) |                
  \_____||_____||_____/       |____/ |____/ |____/                 
                                                         

filename  : login.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/login.php
backup    : github.com/cis355/cis355
purpose   : This file verifies login info with the database and updates the
            $_SESSION array with a name and an id

copyright : GNU General Public License (http://www.gnu.org/licenses/)
      This program is free software: you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation, either version 3 of the License, or
      (at your option) any later version.
      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
      Some code adapted from STAR Tutorials
      
program structure : 
      session start
      HTML Header
      connect function
      SQL Statement
        Query
        define SESSION vars
      HTML FORM

======================================================================== 

* 3PIO
*
* input : N/A
* 
* processing : The program steps are as follows.
*   1. display form
*   2. check database
*   3. if valid, add to session/connect
*   4. redirect to campaigns
* 
* output : SESSION info
*
* precondition : url accessed with redirect
* 
* postcondition: user logged in and added to session
                
======================================================================== -->

<?php
	session_start();
?>

<html lang = "en">
   
<head>
  <title>DnDatabase</title>
  <link rel="icon" type="image/png" href="favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/sandstone/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
	
   <body>
   <div class = "container">
      <h3>Welcome to Dungeons n' Database</h3>
      <h4>Please enter username and password</h4> 
      <div class = "container form-signin">
         <?php



            function connect(){
            // Purpose: connect to the server via MySQLi
            // Input: N/A
            // Pre: login page called
            // Output: returns connection to server as $c
            // Post: connection established and returned

              $c = mysqli_connect("localhost","cjmealey","564667","cjmealey");
              // Check connection
              if (mysqli_connect_errno()){
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }
              else{
                return($c);
              }
            }




            $msg = '';
            // Check post array for appropriate variables
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
                $username = $_POST['username'];
                $userpass = $_POST['password'];

                $con=connect();
                $result = mysqli_query($con, "SELECT * FROM players WHERE username='$username' AND password='$userpass'");
                while($row = mysqli_fetch_array($result)) {
                    $success = true;

                    // Define future $_SESSION vars
                    $usernameToUse = $row['username'];
                    $idToUse = $row['id'];
                }
                if($success == true) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  
                  echo 'You have entered valid use name and password';

                  // Create session vars
                  $_SESSION['username'] = $usernameToUse;
                  $_SESSION['id'] = $idToUse;
                  header('Location: semesterProj.php');
               }else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "col-xs-6">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "username" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
               <br/>
            <button class = "btn btn-primary" type = "submit" 
               name = "login">Login</button>
         </form>
			
        <a href = "create_player.php" tite = "Logout" class = "btn btn-success">Create New User</a>
         
      </div> 
    </div>
   </body>
</html>