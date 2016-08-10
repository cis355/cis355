<?php

/* ------------------------------------------------------------------------
filename  : prog2_special.php
author    : Alexander King
date      : 2016-07-27
email     : aiking@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/aiking/prog2_special.php
backup    : github.com/cis355/cis355
purpose   : This file serves as Alexander King's program #2, 
			CIS-355: Server Side Web Development, 
			at Saginaw Valley State University (SVSU)
copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
external code used in this file: 
			George Corser's tdg.php, Alexander King's prog2_special.php, www.codingcage.com
program structure:
	Session start, class creation {
		declaration of variables, create function, display function, 
		read function, delete function, update function},
		last section is used for declaration of database and button controls.
------------------------------------------------------------------------- */

#Connection to the database
$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');

#Session used with login, when implmented
session_start();

#Class used to edit and view content in databse.
class Tourist {

	#Variables for items in database.
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	private static $originCountry;
	
	#Variables used to determine when to take an action.
	private static $create;
	private static $read;
	private static $delete;
	private static $update;

	
	public function createRecord () {

		#This acts as the form used to input data for a new record.
		echo '<h3>Add a Record</h3>';
		echo '<form class="form-horizontal" action="" method="post">';
		echo '<input name="name" type="text" placeholder="Name">';
		echo '<input name="email" type="text" placeholder="Email Address">';
		echo '<input name="mobile" type="text" placeholder="Mobile">';
		echo '<input name="originCountry" type="text" placeholder="Country of Origin">';
		echo '<button type="submit" class="btn btn-success">Create Record</button>';
		echo '</form>';
		
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$originCountry = $_POST['originCountry'];
		
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		$sql = "INSERT INTO tourists (name,email,mobile,originCountry) VALUES(?,?,?,?)";
		$statement = mysqli_prepare($con, $sql);
		mysqli_stmt_bindm($statement, 1, $name);
		mysqli_stmt_bindm($statement, 2, $email);
		mysqli_stmt_bindm($statement, 3, $mobile);
		mysqli_stmt_bindm($statement, 4, $originCountry);
		mysqli_stmt_execute($statement);
		

		mysqli_close($con);
		header("Location: prog2_special.php");
	
	} #End of the createRecord function.
	
	#Displays all the content from the database.
	public function displayRecords () {
		
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		$sql = 'SELECT * FROM tourists ORDER BY id DESC';
		echo '<table class="table table-striped table-bordered">
				<thead>
				<tr>
				  <th>Name</th>
				  <th>Email Address</th>
				  <th>Mobile Number</th>
				  <th>Country of Origin</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>';
		
		foreach (mysqli_query($con, $sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td>'. $row['originCountry'] . '</td>';
			echo '<td width=250>';
			echo '<a class="btn" href="prog2_special.php?read=yes&id=' .$row['id'].'">Read</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-success" href="prog2_special.php?update=yes&id='.$row['id'].'">Update</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-danger" href="prog2_special.php?delete=yes&id=' .$row['id'].'">Delete</a>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		
		mysql_close($con);

	} #End of the displayRecords function.
	
	public function readRecord ($id) {
		#Displays data from a single record at the bottom of the page.
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		$sql = "SELECT * FROM tourists WHERE id=" . $_GET['id'];
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_assoc($result);
		
		$name = $row['name'];
		$email = $row['email'];
		$mobile = $row['mobile'];
		$originCountry = $row['originCountry'];
		
		echo "<div class='container'>";
    	echo "<div class='span10 offset1'>";
    	echo "<div class='row'><h3>Read a Customer</h3></div>";
	    echo "<div class='form-horizontal' >";
		echo "<div class='control-group'><label class='control-label'>Name: </label>";
		echo $name;
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Email Address: </label>";
		echo $email;
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Mobile Number: </label>";
		echo $mobile;
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Country of Origin: </label>";
		echo $originCountry;
		echo "</div>";
		echo "<div class='form-actions'>";
		echo "<a class='btn' href='prog2_special.php'>Clear</a></div>";
		echo "</div></div></div> <!-- /container -->";
						
		mysql_close($con);
		//}
	} #End of the readRecord Function.
	
	public function deleteRecord ($id) {
		
		#Delete data
		#Code borrowed from www.codingcage.com
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		$sql = $con->query("DELETE FROM tourists WHERE id=".$_GET['id']);
		mysql_close($con);
		header("Location: prog2_special.php");
		
	} #End of deleteRecord function.
	
	public function updateRecord ($id) {
		#Updates a record.
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		$sql = "SELECT * FROM tourists WHERE id=" . $_GET['id'];
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_assoc($result);
		
		$name = $row['name'];
		$email = $row['email'];
		$mobile = $row['mobile'];
		$originCountry = $row['originCountry'];
		
		echo "<div class='container'>";
    	echo "<div class='span10 offset1'>";
    	echo "<div class='row'><h3>Read a Customer</h3></div>";
	    echo "<div class='form-horizontal' >";
		echo "<div class='control-group'><label class='control-label'>Name: </label>";
		echo '<input name="name2" type="text" placeholder="Name" value='.$name.'>';
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Email Address: </label>";
		echo '<input name="email2" type="text" placeholder="Email" value='.$email.'>';
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Mobile Number: </label>";
		echo '<input name="mobile2" type="text" placeholder="Mobile" value='.$mobile.'>';
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Country of Origin: </label>";
		echo '<input name="oc2" type="text" placeholder="Country of Origin" value='.$originCountry.'>';
		echo "</div>";
		echo "<div class='form-actions'>";
		echo '<button type="submit" class="btn btn-success">Update Record</button>';
		echo "</div></div></div> <!-- /container -->";
		
		
		// keep track post values
		$name2 = $con->real_escape_string($_POST['name2']);
		$email2 = $con->real_escape_string($_POST['email2']);
		$mobile2 = $con->real_escape_string($_POST['mobile2']);
		$oc2 = $con->real_escape_string($_POST['oc2']);
	
		$sql2 = "UPDATE tourists SET name ='$name2', email ='$email2', mobile ='$mobile2', originCountry ='$oc2' VALUES WHERE id="._GET['id'];
		mysqli_query($con, $sql2);

		mysqli_close($con);
		#header("Location: prog2_special.php");
		

	} #End of updateRecord function.

	
	function displayCreateBtn () {
		echo "</br><a href='prog2_special.php?create=yes' class='btn btn-success'>Create</a><br />";
	}
	
	function __construct () {
	
		$create = $_GET['create'];
		$read = $_GET['read'];
	
	}

} #End of the Customer Class.

$tour1 = new Tourist;
$tour1->displayRecords();
$tour1->displayCreateBtn();

#The following code determines when a button is pressed.
if ($_GET['create'] == 'yes') $tour1->createRecord();
if ($_GET['read'] == 'yes') $tour1->readRecord($_GET['id']);
if ($_GET['update'] == 'yes') $tour1->updateRecord($_GET['id']);
if ($_GET['delete'] == 'yes') $tour1->deleteRecord($_GET['id']);

echo "<br /><br /><br />";
echo "<br /><br /><br />";

echo '</br><a href="prog2.pdf" target="_blank">UML Diagram</a>';
show_source(__FILE__);

?>