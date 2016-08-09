<?php

/* ------------------------------------------------------------------------
filename  : prog1_classes.php
author    : Alexander King
date      : 2016-07-24
email     : aiking@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/aiking/prog1_classes.php
backup    : github.com/cis355/cis355
purpose   : This file serves as Alexander King's program #1, 
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
			George Corser's tdg.php
program structure:
	Session start, class creation {
		declaration of variables, create function, display function, 
		read function, delete function, update function},
		last section is used for declaration of database and button controls.
------------------------------------------------------------------------- */

#Connection to the database
require ("crud/database.php");

#Session used with login, when implmented
session_start();

#Class used to edit and view content in databse.
class Customer {

	#Variables for items in database.
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	private static $password;
	
	#Variables used to determine when to take an action.
	private static $create;
	private static $read;
	private static $delete;

	
	public function createRecord () {
	
		#This acts as the form used to input data for a new record.
		echo '<h3>Add a Record</h3>';
		echo '<form class="form-horizontal" action="" method="post">';
		echo '<input name="name" type="text" placeholder="Name">';
		echo '<input name="email" type="text" placeholder="Email Address">';
		echo '<input name="mobile" type="text" placeholder="Mobile">';
		echo '<input name="password" type="text" placeholder="Password">';
		echo '<button type="submit" class="btn btn-success">Create Record</button>';
		echo '</form>';
		
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
	
		#Code that inserts new data into database.
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile,password) values(?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile,$password));
		Database::disconnect();
		header("Location: prog1_classes.php");
	
	}
	
	public function displayRecords () {
	
		#Displays all content from the database.
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		echo '<table class="table table-striped table-bordered">
				<thead>
				<tr>
				  <th>Name</th>
				  <th>Email Address</th>
				  <th>Mobile Number</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>';
		
		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td width=250>';
			echo '<a class="btn" href="prog1_classes.php?read=yes&id=' .$row['id'].'">Read</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-success" href="prog1_update.php?id='.$row['id'].'">Update</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-danger" href="prog1_classes.php?delete=yes&id=' .$row['id'].'">Delete</a>';
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		Database::disconnect();
	} #End of the displayRecords function.
	
	public function readRecord ($id) {
		#Displays data from a single record at the bottom of the page.
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		echo "<div class='container'>";
    	echo "<div class='span10 offset1'>";
    	echo "<div class='row'><h3>Read a Customer</h3></div>";
	    echo "<div class='form-horizontal' >";
		echo "<div class='control-group'><label class='control-label'>Name: </label>";
		echo $data['name'];
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Email Address: </label>";
		echo $data['email'];
		echo "</div>";
		echo "<div class='control-group'>";
		echo "<label class='control-label'>Mobile Number: </label>";
		echo $data['mobile'];
		echo "</div>";
		echo "<div class='form-actions'>";
		echo "<a class='btn' href='prog1_classes.php'>Clear</a></div>";
		echo "</div></div></div> <!-- /container -->";
						
		Database::disconnect();
		//}
	} #End of the readRecord Function.
	
	public function deleteRecord ($id) {
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: prog1_classes.php");
		
	} #End of deleteRecord function.
	
/*	public function updateRecord ($id) {
		#intention is to update a record.
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		echo '<h3>Update a Record</h3>';
		echo '<form class="form-horizontal" action="" method="post">';
		echo '<input name="name" type="text" value="' . $data['name'] . '">';
		echo '<input name="email" type="text" value="' . $data['email'] . '">';
		echo '<input name="mobile" type="text" value="' . $data['mobile'] . '">';
		echo '<button type="submit" class="btn btn-success">Update Record</button>';
		echo '</form>';
		
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
	
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE customers set name = ?, email = ?, mobile = ? WHERE id = ?";
		$k = $pdo->prepare($sql);
		$k->execute(array($name,$email,$mobile,$id));
		Database::disconnect();
		header("Location: prog1_classes.php");

	} #End of updateRecord function.
*/
	
	function displayCreateBtn () {
		echo "</br><a href='prog1_classes.php?create=yes' class='btn btn-success'>Create</a><br />";
	}
	
	function __construct () {
	
		$create = $_GET['create'];
		$read = $_GET['read'];
	
	}

} #End of the Customer Class.

$cust1 = new Customer;
$cust1->displayRecords();
$cust1->displayCreateBtn();

#The following code determines when a button is pressed.
if ($_GET['create'] == 'yes') $cust1->createRecord();
if ($_GET['read'] == 'yes') $cust1->readRecord($_GET['id']);
#if ($_GET['update'] == 'yes') $cust1->updateRecord($_GET['id']);
if ($_GET['delete'] == 'yes') $cust1->deleteRecord($_GET['id']);

echo "<br /><br /><br />";
echo "<br /><br /><br />";

?>