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
                                                         

filename  : leave_game.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/leave_game.php
backup    : github.com/cis355/cis355
purpose   : This file deletes the "joined" member that contains the user and 
			the campaign

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
      connect function
      leave function
      	SQL statement and query

                
======================================================================== -->

<?php 

	session_start();
	if(empty($_SESSION['username'])) header('Location: login.php'); //redirect

	function connect(){
	// Purpose: connect to the server via MySQLi
	// Input: N/A
	// Pre: leave function called
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



	function leave_campaign(){
	// Purpose: delete "joined" entry
	// Input: N/A
	// Pre: leave function called
	// Output: N/A
	// Post: "joined" entry delete

		$id = $_SESSION['id'];
		$campId = $_GET['id'];
		
		$con = connect();

	    echo "	<div class='row'>";
		$sql = "DELETE FROM joined WHERE userID=$id AND campID=$campId";
		if ($con->query($sql) === TRUE) {
		    echo  "<h3>Campaign No. ". $campId ." un-joined</h3>";
		    header("Location: user_profile.php#joined");
		} 
		else{
		    echo "Error: " . $sql . "<br>" . $con->error;
		}
		echo "	</div>
				<div class='row'>
					<a class='btn btn-primary' href='user_profile.php'>Back</a>
				</div>";
	}


	leave_campaign();

?>