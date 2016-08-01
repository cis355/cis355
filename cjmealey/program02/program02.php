<!-- -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-

filename  : program02.php
author    : Colin Mealey
date      : 2016-07-31
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/program02/program02.php
backup    : github.com/cis355/cis355
purpose   : This file creates a functioning CRUD site from a class

copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
			Code constructed with guidance from G. Corser and some help from N. Mealey
			
program structure : 
	HTML
		<head> 	
		Import Bootstrap for visuals
	    <body>	

	    PHP
	    database call
	    class Athlete
	    	attributes
	    	connect function
	    	construct function
	    		standard heading
	    		check action var
	    			execute CRUD functions
	    		if empty, display page
	    	create()
	    	read()
	    	update()
	    	delete()
	    	displayRecords()

	    declare a new Customer
                
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+- -->

<?php
// Customer object will be the center of all actions

class Athlete {
	// Declare all elements for each customer
	private static $id;
	private static $name;
	private static $sport;
	private static $team;

	// THIS FUNCTION ACTS AS A CONNECT THAT WORKS WITHIN THE CLASS METHODS
	public function connect(){
		$c = mysqli_connect("localhost","cjmealey","564667","cjmealey");
		// Check connection
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			return($c);
		}
	}

	function __construct()
	{
		// ECHO GENERIC HEADER FOR EVERY PAGE
		echo "  <!DOCTYPE html>
				<html lang='en'>
				<style>body{padding:20px;}</style>
				<head>
				    <meta charset='utf-8'>
				    <meta name='viewport' content='width=device-width, initial-scale=1'>
				    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
				    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
				    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
					<h1>Program 02 - CJM</h1>
					<a href='program02_UML.png'>UML Diagram</a><br/><br/><br/>
				</head>
				<body>
				<div class='container'>";

		// CHECKS ACTION PARAM FOR EXISTENCE, THEN CONTENTS
		if(!empty($_GET['action'])){

			// THIS WILL CHECK FOR CREATE
			if(in_array('create', $_GET)) 
			{
				// THIS WILL CHECK FOR THE SUBMIT BUTTON
				if(in_array('submit', $_GET))
				{
					$name = $_POST['name'];
					$sport = $_POST['sport'];
					$team = $_POST['team'];

					$con = $this->connect();
					$sql = "INSERT INTO athletes (name,sport,team) VALUES('$name','$sport','$team')";
					if ($con->query($sql) === TRUE) {
					    echo $name . " created successfully<br><br>";
					} else {
					    echo "Error: " . $sql . "<br>" . $con->error;
					}
					echo '<a class="btn btn-danger" href="program02.php">Home</a>';
		            mysqli_close($con);
				}
				else
				{
					$this->create();
				}
			}

			//THIS CHECKS FOR READ
			if(in_array('read', $_GET))
			{	
				$id = $_REQUEST['id'];
				//Connect to Server
				$con = $this->connect();
				$sql = "SELECT * FROM athletes where id = $id ";
				$result=mysqli_query($con,$sql);
				$row=mysqli_fetch_row($result);
				$this->read($row);
				
			}

			// THIS WILL CHECK FOR UPDATE
			if(in_array('update', $_GET) && !in_array('submit_up', $_GET)) 
			{
				$id = $_REQUEST['id'];
				//Connect to Server
				$con = $this->connect();
				$sql = "SELECT * FROM athletes where id = $id";
				$result=mysqli_query($con,$sql);
				$row=mysqli_fetch_row($result);
				$this->update($row);
			}

			if(in_array('submit_up', $_GET))
			{
				//ASSIGN VARS BASED ON POST
				$id = $_POST['id'];
				$name = $_POST['name'];
				$sport = $_POST['sport'];
				$team = $_POST['team'];

				$con = $this->connect();
				$sql = "UPDATE athletes set name = '$name', sport = '$sport', team = '$team' WHERE id = '$id'";
				if ($con->query($sql) === TRUE) {
				    echo $name . " updated successfully<br><br>";
				} else {
				    echo "Error: " . $sql . "<br>" . $con->error;
				}
				echo '<a class="btn btn-danger" href="program02.php">Home</a>';
	            mysqli_close($con);
			}

			// THIS WILL CHECK FOR DELETE
			if(in_array('delete', $_GET)) 
			{
				$id = $_GET['id'];
				$this->delete($id);
				//Connect to Server and delete
				$con = $this->connect();
				$sql = "DELETE FROM athletes where id = $id";
				mysqli_query($con,$sql);
				mysqli_close($con);
			} 
		}
		else
		{
			// DISPLAY PAGE AS NORMAL IF NO ACTION
			$this->displayRecords();
		}
	}

	public function create($data)
	{
		// GENERATE HTML HERE
		echo '	<h3>Enter Information: </h3>
				<form action="program02.php?action=create&submit=submit" method="post">
					<br><input type="text" name="name" placeholder="Name">
					<br><input type="text" name="sport" placeholder="Sport">
					<br><input type="text" name="team" placeholder="Team">
					<br>
					<br><input type="submit" class="btn btn-success" value="Submit">&nbsp;<a class="btn btn-danger" href="program02.php">Back</a>
				</form>';
	}

	public function read($data)
	{
		// GENERATE HTML HERE
		echo '	<div class="span10 offset1">
                <div class="row">
                    <h3>Player : ' . $data[1] . '</h3>
                </div>
                 
                <div class="form-horizontal" >
                  <div class="control-group">
                    <h4> SPORT: '. $data[2] .   
                 '</div>
                  <div class="control-group">
                    <h4> TEAM: '. $data[3] .   
                 '</div>
                    <div class="form-actions">
                      <a class="btn btn-success" href="program02.php">Back</a>
                   </div>
                </div>
                </div>           
			    </div> <!-- /container -->
			  </body>
			</html>';
	}

	public function update($data)
	{
		// GENERATE HTML HERE
		echo '	<h3>Enter Information: </h3>
				<form action="program02.php?action=update&submit_up=submit_up" method="post">
					<input type="hidden" name="id" value="' . $_GET['id'] . '">
					<br><input type="text" name="name" value="' . $data[1] . '">
					<br><input type="text" name="sport" value="' . $data[2] . '">
					<br><input type="text" name="team" value="' . $data[3] . '">
					<br>
					<br><input type="submit" class="btn btn-success" value="Submit">&nbsp;<a class="btn btn-danger" href="program02.php">Back</a>
				</form>';
	}

	public function delete($data)
	{
		// GENERATE HTML HERE
		echo ' 	<h3> Entry with ID: ' . $data . ' has been deleted </h3><br>
				<a class="btn btn-danger" href="program02.php">Back</a>';
	}

	// Code uses HTML to construct the table of all athletes
	public function displayRecords () {
		$con = $this->connect();
		$sql = "SELECT * FROM athletes ORDER BY id DESC";
		echo '<a href="program02.php" class="btn btn-success">Refresh</a>&nbsp;';
		echo '<a href="program02.php?action=create" class="btn btn-success">Create</a><br/><br/><br/>';
	    echo '<table class="table table-striped table-bordered">
	            <thead>
	            <tr>
	              <th>Name</th>
	              <th>Sport</th>
	              <th>Team</th>
	              <th>Action</th>
	            </tr>
	          </thead>
	          <tbody>';
		foreach ($con->query($sql) as $row) {
	        echo '<tr>';
	        echo '<td>'. $row['name'] . '</td>';
	        echo '<td>'. $row['sport'] . '</td>';
	        echo '<td>'. $row['team'] . '</td>';
	        echo '<td width=250>';
	        echo '<a class="btn btn-info" href="program02.php?action=read&id='. $row['id'].'">Read</a>';
	        echo '&nbsp;&nbsp;';
	        echo '<a class="btn btn-success" href="program02.php?action=update&id='. $row['id'].'">Update</a>';
	        echo '&nbsp;&nbsp;';
	        echo '<a class="btn btn-danger" href="program02.php?action=delete&id='. $row['id'].'">Delete</a>';
			echo'</td>';
			echo'</tr>';
		}
	echo '</tbody></table>';
	mysqli_close($con);
	}
}
// Actually declare a Customer, iterate correct buttons
$ath1 = new Athlete;

show_source(__FILE__);
?>