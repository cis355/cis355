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
                                                         

filename  : join_game.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/join_game.php
backup    : github.com/cis355/cis355
purpose   : This file connects a user and a game in the "joined" table

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
      HTML form
      session start
      connect function
      join function
      	SQL and execute

                
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

<!-- ================================================================================ -->

			<?php 

			session_start();
			if(empty($_SESSION['username'])) header('Location: login.php'); //redirect

			function connect(){
			// Purpose: connect to the server via MySQLi
			// Input: N/A
			// Pre: join_campaign called function called
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



			function join_campaign(){
			// Purpose: create "joined" entry with user and game
			// Input: N/A
			// Pre: join_game.php called
			// Output: a "joined" entry
			// Post: "joined" entry created

				$id = $_SESSION['id'];
				$campId = $_GET['id'];
				
				$con = connect();
				$check=mysqli_query($con,"SELECT * FROM joined where userID=$id and campID=$campId");
			    $checkrows=mysqli_num_rows($check);

			    echo "	<div class='row'>";
						   	if($checkrows>0){
						    	echo "<h3>Campaign No. ". $campId ." already joined</h3>";
						   	} 
						   	else{ 
								$sql = "INSERT INTO joined (userID,campID) VALUES ($id,$campId)";
								if ($con->query($sql) === TRUE) {
								    echo  "<h3>Campaign No. ". $campId ." joined</h3>";
								} 
								else{
								    echo "Error: " . $sql . "<br>" . $con->error;
								}
							}

				echo "	</div>
						<div class='row'>
							<a class='btn btn-primary' href='semesterProj.php'>Back</a>&nbsp;&nbsp;
							<a class='btn btn-success' href='user_profile.php#joined'>View Joined</a>
						</div>";

			}

			join_campaign();

			?>

<!-- ================================================================================ -->


		</div>
	</body>
</html>
