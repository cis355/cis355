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
                                                         

filename  : update_user.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/update_user.php
backup    : github.com/cis355/cis355
purpose   : This file updates the selected user's information

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
      HTML Header

      connect function
      SQL statement
        create form
      check appropriate inputs

                
======================================================================== -->

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
</head>
 
<body>

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

<div class="container">







<?php

function connect(){
// Purpose: connect to the server via MySQLi
// Input: N/A
// Pre: update_user called
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
// THIS WILL CHECK FOR UPDATE
if(in_array('update', $_GET) && !in_array('submit_up', $_GET)) 
{
	$id = $_REQUEST['id'];
	//Connect to Server
	$con = connect();
	$sql = "SELECT * FROM players where id = $id";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_row($result);


	echo '	<h3>Update Information: </h3>
					<form action="update_user.php?submit_up=submit_up" method="post" id="description">
						<input type="hidden" name="id" value="' . $_GET['id'] . '">
						<br><input type="submit" class="btn btn-success" value="Update ' . $row[1] . '"><br><br><br><br>
						<br>Location<br><input type="text" name="location" value="' . $row[3] . '">
						<br><br>Email<br><input type="text" name="email" value="' . $row[5] . '">
						<br><br>About<br><br>				
					</form>

					<textarea name="about" form="description" rows="10" cols="100">' . $row[4] . '</textarea>
					<br><br><a class="btn btn-danger" href="user_profile.php">Back</a><br><br>
					';
}



if(in_array('submit_up', $_GET))
{

	//ASSIGN VARS BASED ON POST
	$id = $_POST['id'];
	$location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$about = filter_var($_POST['about'], FILTER_SANITIZE_STRING);

	$con = connect();
	$sql = "UPDATE players set location = '$location', email = '$email', about = '$about' WHERE id = '$id'";
	if ($con->query($sql) === TRUE) {
	    echo "Updated successfully<br><br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $con->error;
	}
	echo '<a class="btn btn-danger" href="user_profile.php">Back</a>';
    mysqli_close($con);
}


?>





</div>
</body>
</html>