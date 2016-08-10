
<?php

/* ========================================================================

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
                                                         

filename  : create_player.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/create_player.php
backup    : github.com/cis355/cis355
purpose   : This file displays and implements the create user feature

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
      database.php
      check all errors
        if valid, create campaign
      HTML form
        username
        password
        pass_confirm
        location
        email
        about

======================================================================== 

* 3PIO
*
* input : N/A
* 
* processing : The program steps are as follows.
*   1. display form
*   2. check valid/invalid
*   3. input data from form to database
*   4. redirect to login
* 
* output : database info
*
* precondition : create user selected
* 
* postcondition: user added to database
                
======================================================================== */

     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $passwordError = null;
        $pass_confirmError = null;
        $locationError = null;
        $emailError = null;
        $aboutError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $password = $_POST['password'];
        $pass_confirm = $_POST['pass_confirm'];
        $location = $_POST['location'];
        $email = $_POST['email'];
        $about = $_POST['about'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($password)) {
            $passwordError = 'Please enter password';
            $valid = false;
        }

        if ($password != $pass_confirm){
            $pass_confirmError = 'Passwords must match!';
            $valid = false;
        }
         
        if (empty($location)) {
            $locationError = 'Please enter Location';
            $valid = false;
        }

        if (empty($about)) {
            $aboutError = 'Please enter about';
            $valid = false;
        }

        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO players (username,password,location,about,email) 
                    values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$password,$location,$about,$email));
            Database::disconnect();
            header("Location: login.php");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>DnDatabase</title>
<link rel="icon" type="image/png" href="favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/sandstone/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <style>
  .resizedTextbox {width: 400px; height: 30px; padding: 1px}
  </style>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a New Player</h3>
                    </div>
             
                    <form class="form-horizontal" action="create_player.php" method="post">

                    <!-- Enter username and errorcheck call -->
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Userame</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Username" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <!-- Enter password and errorcheck call -->
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <input name="password" type="password" placeholder="Enter Password" value="<?php echo !empty($password)?$password:'';?>">
                            <?php if (!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <!-- Enter password confirmation and errorcheck call -->
                      <div class="control-group <?php echo !empty($pass_confirmError)?'error':'';?>">
                        <label class="control-label">Confirm password</label>
                        <div class="controls">
                            <input name="pass_confirm" type="password" placeholder="Confirm Password" value="<?php echo !empty($pass_confirm)?$pass_confirm:'';?>">
                            <?php if (!empty($pass_confirmError)): ?>
                                <span class="help-inline"><?php echo $pass_confirmError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
                            <input name="location" type="text"  placeholder="City, State, Zip" value="<?php echo !empty($location)?$location:'';?>">
                            <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input name="email" type="text" class=resizedTextbox  placeholder="example@email.com" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <div class="control-group <?php echo !empty($aboutError)?'error':'';?>">
                        <label class="control-label">About</label>
                        <div class="controls">
                            <input name="about" type="text" class=resizedTextbox  placeholder="Enter User Description" value="<?php echo !empty($about)?$about:'';?>">
                            <?php if (!empty($aboutError)): ?>
                                <span class="help-inline"><?php echo $aboutError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <br/><br/>
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="semesterProj.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>