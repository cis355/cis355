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
                                                         

filename  : user_profile.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/user_profile.php
backup    : github.com/cis355/cis355
purpose   : This file displays the logged in user's info and campaigns

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
      HTML Header
      connect function
      displayProfile function
      displayJoined function
      displayMade function

      declare functions and class

                
======================================================================== -->

<?php

session_start();
if(empty($_SESSION['username'])) header('Location: login.php'); //redirect

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
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
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
        <li><a href="semesterProj.php">Campaigns <span class="sr-only">(current)</span></a></li>
        <li class="active"><a href="user_profile.php">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">







<?php
class UserProfile {

	public function connect(){
  // Purpose: connect to the server via MySQLi
  // Input: N/A
  // Pre: function called
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









	public function displayProfile(){
  // Purpose: print player information
  // Input: N/A
  // Pre: $_SESSION has correct info
  // Output: player info as a readable segment
  // Post: main section of profile built

    $id = $_SESSION['id'];
		$username = $_SESSION['username'];

		$con=$this->connect();
		$sql = "SELECT * FROM players where username = '$username' ";
		$result=mysqli_query($con,$sql);
		$row=mysqli_fetch_row($result);

		echo'	<div class="container-fluid well span6">
					<div class="row-fluid">
				        <div class="col-xs-7">
				            <h3>' . $row[1] . '</h3>
				            <h6>Email: ' . $row[5] . '</h6>
				            <h6>Location: ' . $row[3] . '</h6>
				        </div>
				        <div class="row-fluid">
                  <div class="col-xs-11">
				            <div class="dropdown">
				                <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
				                    Action 
				                    <span class="icon-cog icon-white"></span><span class="caret"></span>
				                </a>
				                <ul class="dropdown-menu">
				                    <li><a href="update_user.php?action=update&id=' . $id . '"><span class="icon-wrench"></span> Modify</a></li>
				                    <li><a href="delete_user.php?action=delete&id=' . $id . '"><span class="icon-trash"></span> Delete</a></li>
				                </ul>
				            </div>
                  </div>
				        </div>
				        <div class="col-xs-7">
				        	<h5><br/><br/>About ' . $row[1] . ':</h5>
				        	<p>' . $row[4] . '<br/><br/></p>
				        </div>
					</div>
				</div>';
	}



                                                
                                              



	public function selectJoined(){
  // Purpose: print all joined campaigns
  // Input: N/A
  // Pre: name passed in $_GET
  // Output: joined campaigns printed in table
  // Post: joined campaigns printed in table

		echo'	<div id="joined">
          <table class="table table-striped table-bordered">
          <caption><h3>Joined Campaigns:</h3></caption>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Game Master</th>
                      <th>Location</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>';

		$id = $_SESSION['id'];
		$currentName = $_SESSION['username']; 

		$con = $this->connect();
		$sql = "SELECT * FROM campaigns, joined, players 
				WHERE joined.userID = $id 
				AND players.username = '$currentName'
				AND joined.campID = campaigns.id 
				ORDER BY joined.id DESC";

		foreach ($con->query($sql) as $row) {
        echo "<tr>";
        echo "<td class='col-xs-2'><q>" . $row['name'] . "</q><br/>ID number: " . $row['campID'];
        echo "<td class='col-xs-1'><a href=other_profile.php?username=" . $row['creator'] . ">" . $row['creator'] . "</td>";
        echo "<td class='col-xs-1'>" . $row['camplocation'] . "</td>";
        echo "<td class='col-xs-2'><button type='button' class='btn btn-info'
          data-toggle='modal' data-target='#myModal".$row['campID']."'>View Full Description</button>";
        echo '   <div id="myModal'.$row['campID'].'" class="modal fade" role="dialog">';
        echo "      <div class='modal-dialog'>

                  <!-- Modal content-->
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                      <h4 class='modal-title'>The Story of <q>" . $row['name'] . "</q></h4>
                    </div>
                    <div class='modal-body'>
                      <p>" . $row['description'] . "</p>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    </div>
                  </div>

                </div>
              </div>
            </td>";
        echo "<td class='col-xs-3'><a class='btn btn-danger' href='leave_game.php?id=" . $row['campID'] . "'>Leave Game</a>&nbsp;&nbsp;";
        echo "</tr>";

		}
	}







  public function selectMade(){
  // Purpose: print all user-made campaigns
  // Input: N/A
  // Pre: user/campaigns/joined must exist and have contents
  // Output: created campaigns printed in table
  // Post: created campaigns printed in table

    echo' <table class="table table-striped table-bordered">
          <caption><h3>Your Campaigns:</h3></caption>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Game Master</th>
                      <th>Location</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>';

    $id = $_SESSION['id'];
    $currentName = $_SESSION['username']; 

    $con = $this->connect();
    $sql = "SELECT * FROM campaigns WHERE creator='$currentName'";

    foreach ($con->query($sql) as $row) {
        echo "<tr>";
        echo "<td class='col-xs-2'><q>" . $row['name'] . "</q><br/> ID number: " . $row['id'];
        echo "<td class='col-xs-1'><a href=other_profile.php?username=" . $row['creator'] . ">" . $row['creator'] . "</td>";
        echo "<td class='col-xs-1'>" . $row['camplocation'] . "</td>";
        echo "<td class='col-xs-2'><button type='button' class='btn btn-info'
          data-toggle='modal' data-target='#myModal".$row['campID']."'>View Full Description</button>";
        echo '   <div id="myModal'.$row['campID'].'" class="modal fade" role="dialog">';
        echo "      <div class='modal-dialog'>

                  <!-- Modal content-->
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                      <h4 class='modal-title'>The Story of <q>" . $row['name'] . "</q></h4>
                    </div>
                    <div class='modal-body'>
                      <p>" . $row['description'] . "</p>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    </div>
                  </div>

                </div>
              </div>
            </td>";
        echo "<td class='col-xs-3'>";
        echo "<a class='btn btn-danger' href='delete.php?id=".$row['id']."'>Delete</a>&nbsp;&nbsp;";
        echo "<a class='btn btn-success' href='update.php?id=" . $row['id'] . "'>Update Entry</a>";
        echo "</tr>";
        echo "</div";
    }
  }


}

$profile = new UserProfile;
$profile->displayProfile();
$profile->selectJoined();
$profile->selectMade();

?>






</body>
</html>

