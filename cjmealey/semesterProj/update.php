<?php

/*-- ========================================================================

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
                                                         

filename  : update.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/update.php
backup    : github.com/cis355/cis355
purpose   : This file update selected campaign

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
      session
      check for post vars
      if correct, update entry
        SQL statement
      if not, repopulate and run error messages
      HTML Header
      HTML Form

                
======================================================================== */


    session_start();
    if(empty($_SESSION['username'])) header('Location: login.php'); //redirect
     
    require 'database.php';

    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: semesterProj.php");
    }

    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $creatorError = null;
        $locationError = null;
        $descriptionError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $creator = $_POST['creator'];
        $location = $_POST['location'];
        $description = $_POST['description'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($creator)) {
            $creatorError = 'Please enter GM Name';
            $valid = false;
        }
         
        if (empty($location)) {
            $locationError = 'Please enter Location';
            $valid = false;
        }

        if (empty($description)) {
            $descriptionError = 'Please enter Description';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
              $pdo = Database::connect();
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "UPDATE campaigns  set name = ?, creator = ?, camplocation = ?, description = ? WHERE id = ?";
              $q = $pdo->prepare($sql);
              $q->execute(array($name,$creator,$location,$description,$id));
              Database::disconnect();
              header("Location: semesterProj.php");
        }
      }
    else{
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM campaigns where id = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($id));
      $data = $q->fetch(PDO::FETCH_ASSOC);
      $name = $data['name'];
      $creator = $data['creator'];
      $location = $data['camplocation'];
      $description = $data['description'];
      Database::disconnect();
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
 
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="semesterProj.php">Dungeons n' Database</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="semesterProj.php">Campaigns <span class="sr-only">(current)</span></a></li>
        <li><a href="user_profile.php">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<body>
    <div class="container">
    
               <div class="span10 offset1">
                    <div class="row">
                        <h3>Update <?php echo $name;?></h3>
                    </div>

                    <?php
                      if ($valid) {
                        echo "<br><h4>" . $name . ' has been updated!</h4 style="color:red;">';
                      }
                    ?>

                    <form class="form-horizontal" id="textarea" action="update.php?id=<?php echo $id?>" method="post">

                      <div class="form-actions">
                          <br/><br/>
                          <button type="submit" class="btn btn-primary">Update</button>
                          <a class="btn btn-success" href="semesterProj.php">Back</a>
                      </div>

                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo $name;?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>


                      <div type="hidden" class="control-group <?php echo !empty($creatorError)?'error':'';?>">
                        <label class="control-label">Game Master</label>
                        <div class="controls">
                        <?php 
                            echo' <input name="creator" type="text" value="' . $_SESSION['username'] . '">';
                            if (!empty($creatorError)): ?>
                                <span class="help-inline"><?php echo $creatorError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
                            <input name="location" type="text"  placeholder="City, State, Zip" value="<?php echo $location;?>">
                            <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                    </form>



                    <label class="control-label">Description</label>
                    <div class="controls">
                        <?php 
                        echo'<textarea name="description" form="textarea" rows="10" cols="100" value="' . $description . '">' . $description . '</textarea>';
                        if (!empty($descriptionError)): ?>
                            <span class="help-inline"><?php echo $descriptionError;?></span>
                        <?php endif;?>
                    </div>
                </div>

    </div> <!-- /container -->
  </body>
</html>