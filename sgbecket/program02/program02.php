<!-- -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
filename  : program02.php
author    : Gage Beckett
date      : 2016-07-31
email     : sgbecket@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/sgbecket/program02/program02.php
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
			Code constructed with guidance from G. Corser  with the star tutorial
			
program structure : 
	HTML
		<head> 	
		Import Bootstrap for visuals
	    <body>	

	    PHP
	    database call
	    class Venue
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

	    declare a new Venue
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+- -->
<?php
/*******************************************
one and only class for this program
drives and connects and displays and generates the HTML.
********************************************/
class Venues{
	private static $id;
    private static $name;
    private static $type;
    private static $location;

function __construct(){
	
	echo'<!DOCTYPE html>
	<html lang="en">
	<head>
	  <title>Program 02</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<h2>Program 02</h2>';
}
function read(){
	$id = $_REQUEST['id'];//get id value from url
	$con=$this->connect();//call connect function to connect with database
	$sql = "SELECT * FROM venue where id = $id"; //variable to hold sql statement
	$q=mysqli_query($con, $sql); //query the database
	$data = mysqli_fetch_row($q);//get the data from the rom with the $ID

	//echo out the modal with the read information
	echo '
	  <script>
		function loadModal(){
			$("#myModal").modal("show");
		}
	</script>
	</head>
	<body onload="loadModal();">
	<div class="container">

	  <!-- Modal -->
	  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <a type="button" class="close" href="program02.php">&times;</a>
			  <h4 class="modal-title">Venue: ';echo $data[0]; echo'</h4>
			</div>
			<div class="modal-body">
			  <div class="control-group">
				<label class="control-label">Name</label>
				';echo $data[1]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Venue Type</label>
				';echo $data[2]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Venue Location</label>
				';echo $data[3]; echo'
			  </div>
			<div class="modal-footer">
			  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
			</div>
		  </div>     
		</div>
	  </div>
	</div>
	</body>
	</html>';
	
} 
//remove item from the table
function remove(){
	
	$id = $_REQUEST['delete'];                  //get id value from url
	$con=$this->connect();                      //call connect function to connect with database
	$sql = "DELETE FROM venue  WHERE id = $id"; //variable to hold sql statement
	if(!empty($_POST)){                         //if the user posted
		$con->query($sql);                      //query the database
		$this->redirect();
	
	}
	//display modal asking user to confirm delete
		echo '    		
		<script>
			function loadModal(){
				$("#myModal").modal("show");
			}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="program02.php">&times;</a>
				  <h4 class="modal-title">Venue: ';echo $id; echo'</h4>
				</div>
				<div class="modal-body">
				  <form class="form-horizontal" action="program02.php?delete=';echo $id;echo'" method="post">
					<input type="hidden" name="id" value="'; echo $id; echo'"/>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-default" href="program02.php">No</a>
					  </div>
					</form>
				<div class="modal-footer">
				  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
				</div>
			  </div>     
			</div>
		  </div>
		</div>
		</body>
		</html>';
	}
	function redirect(){
		    sleep(1);
			echo '<script>window.location.href="program02.php";</script>';
	}
	//create new item in the table
	function create(){
						
		if (!empty($_POST) && $_GET['create']){
		// keep track validation errors

		$nameError = null;
		$typeError = null;
		$locationError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$type = $_POST['type'];
		$location = $_POST['location'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter type of venue';
			$valid = false;
		}
		if (empty($location)) {
			$locationError = 'Please enter Venue Location';
			$valid = false;
		}
		if($valid){
			$sql = "INSERT INTO venue (name, type, location) VALUES ('$name', '$type', '$location')";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {
			$this->redirect();

				
				
				} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
		}
	}
	//if the get says to create display the model with the create info.
	if (!empty($_GET['create'])){
		echo '
		  <script>
			function loadModal(){
				$("#myModal").modal("show");
			}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="program02.php">&times;</a>
				  <h4 class="modal-title">New Venue </h4>
				</div>
				<div class="modal-body">
				
				<!--*******The form that the user fills out, with error checking*****-->
				
			<form class="form-horizontal" action="program02.php?create=new" method="post">
			  <div class="control-group ';  echo !empty($nameError)?'error':'';echo'">
				<label class="control-label">Name</label>
				<div class="controls">
					<input name="name" type="text"   value="';  echo !empty($name)?$name:'';echo'">
					';  if (!empty($nameError)): echo'
						<span class="help-inline">';  echo $nameError;echo'</span>
					';  endif; echo'
				</div>
			  </div>
			  <div class="control-group ';  echo !empty($typeError)?'error':'';echo'">
				<label class="control-label">Venue Type</label>
				<div class="controls">
					<input name="type" type="text" placeholder="Venue Type" value="';  echo !empty($type)?$type:'';echo'">
					';  if (!empty($typeError)): echo'
						<span class="help-inline">';  echo $typeError;echo'</span>
					';  endif;echo'
				</div>
			  </div>
			  <div class="control-group ';  echo !empty($locationError)?'error':'';echo'">
				<label class="control-label">Venue Location</label>
				<div class="controls">
					<input name="location" type="text"  placeholder="Venue Location" value="';  echo !empty($location)?$location:'';echo'">
					';  if (!empty($locationError)): echo'
						<span class="help-inline">';  echo $locationError;echo'</span>
					';  endif;echo'
				</div>
			  </div>
			  <div class="form-actions">
				  <button type="submit" class="btn btn-success">Create</button>
				  <a class="btn" href="program02.php">Back</a>
				</div>
				<!--*****End the form, basically the contents of the modal with the surrounding structure being the modal****-->
			</form>
					<div class="modal-footer">
					  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>';
	}
}
/*******************************************
update the selected user information. Could not make it populate the feilds with the exister user information
however it does tell the id of the venue that is being updated. 
*/
function update(){
	if(!empty($_POST)){
		$id = null;
		if ( !empty($_GET['update'])) {
			$id = $_REQUEST['update'];
		}
		// keep track validation errors
		$nameError = null;
		$typeError = null;
		$locationError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$type = $_POST['type'];
		$location = $_POST['location'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter Venue Type';
			$valid = false;
		} 
		
		if (empty($location)) {
			$locationError = 'Please enter Venue Location';
			$valid = false;
		}
		if($valid){
			$sql = "UPDATE venue  set name = '$name', type = '$type', location ='$location' WHERE id = '$id'";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {
				$this->redirect();
				} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
		}
	}


	$id = $_REQUEST['update'];
		
	echo '
	  <script>
		function loadModal(){
			$("#myModal").modal("show");
		}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="program02.php">&times;</a>
				  <h4 class="modal-title">Update Venue: ';echo $id;echo' </h4>
				</div>
				<div class="modal-body">
				
				<!--*******The form that the user fills out, with error checking*****-->
				
			<form class="form-horizontal" action="program02.php?update=';echo $id; echo'" method="post">
		  <div class="control-group ';  echo !empty($nameError)?'error':'';echo'">
			<label class="control-label">Name</label>
			<div class="controls">
				<input name="name" type="text"   value="';  echo !empty($name)?$name:'';echo'">
				';  if (!empty($nameError)): echo'
					<span class="help-inline">';  echo $nameError;echo'</span>
				';  endif; echo'
			</div>
		  </div>
		  <div class="control-group ';  echo !empty($typeError)?'error':'';echo'">
			<label class="control-label">Venue Type</label>
			<div class="controls">
				<input name="type" type="text" placeholder="Venue Type" value="';  echo !empty($type)?$type:'';echo'">
				';  if (!empty($typeError)): echo'
					<span class="help-inline">';  echo $typeError;echo'</span>
				';  endif;echo'
			</div>
		  </div>
		  <div class="control-group ';  echo !empty($locationError)?'error':'';echo'">
			<label class="control-label">Venue Location</label>
			<div class="controls">
				<input name="location" type="text"  placeholder="Venue Location" value="';  echo !empty($location)?$location:'';echo'">
				';  if (!empty($locationError)): echo'
					<span class="help-inline">';  echo $locationError;echo'</span>
				';  endif;echo'
			</div>
		  </div>
		  <div class="form-actions">
			  <button type="submit" class="btn btn-success">Update</button>
			  <a class="btn" href="program02.php">Back</a>
			</div>
		</form>
				<div class="modal-footer">
				  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
				</div>
			  </div>     
			</div>
		  </div>
		</div>
		</body>
		</html>';
}

/******************************************
connect to the database using mysqli, this function is called throughout the program to establish a valid connection_aborted with the database. 
*****************************************/

private function connect(){
	$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else{return $c;}
}

public function displayRecords(){
	$con = $this->connect();
	$sql = 'SELECT * FROM venue ORDER BY id DESC';
		echo '<a class="btn btn-success" href="program02.php?create=new">Create</a>';
        echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Venue Type</th>
                  <th>Venue Location</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>';
	foreach ($con->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['name'] . '</td>';
            echo '<td>'. $row['type'] . '</td>';
            echo '<td>'. $row['location'] . '</td>';
            echo '<td width=250>';
			$this->displayReadButton($row);
            echo '&nbsp;';
			$this->displayUpdateButton($row);
            echo '&nbsp;';
			$this->displayDeleteButton($row);
			echo'</td>';
			echo'</tr>';
	}
	echo '</tbody></table>';
	mysqli_close($con);
}
    function displayReadButton($row){
        echo '<a class="btn btn-info" href="program02.php?id='. $row['id'].'">Read</a>';
    }
    function displayUpdateButton($row){
        echo '<a class="btn btn-success" href="program02.php?update='. $row['id'].'">Update</a>';
    }
	    function displayDeleteButton($row){
        echo '<a class="btn btn-success" href="program02.php?delete='. $row['id'].'">Delete</a>';
    }
}
	//create the new venue and call the funtions if the get requests are correct. 
	$venue1 = new Venues;
	$venue1->displayRecords();
	if (!empty ($_GET['update'])){
		$venue1->update();
	}
	if(!empty ($_GET['create'])){
		$venue1->create();
	}
	if ( !empty($_GET['id'])) {
		$venue1->read();
	}
	if (!empty($_GET['delete'])) {

		$venue1->remove();
	}
	echo '<br><img src="http://csis.svsu.edu/~sgbecket/cis355/sgbecket/program02/UML" /><br>';
	show_source(__FILE__);
?>