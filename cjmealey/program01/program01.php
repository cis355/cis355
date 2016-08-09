<!-- ------------------------------------------------------------------------
filename  : resume.html
author    : Colin Mealey
date      : 2016-07-25
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis255/cjmealey/Program03-DragDrop.html
backup    : github.com/cis255/cis255
purpose   : This file serves as a demo for the interaction features in jQuery

copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
			Code constructed with guidance from G. Corser and some help from G. Beckett
			Base code used from STAR Tutorials
			
program structure : 
	HTML
		<head> 	
		Import Bootstrap for visuals
	    <body>	

	    PHP
	    database call
	    class Customer
	    	attributes
	    	displayRecords()
	    	generate table with HTML
	    		includes display buttons

	   declare a new Customer
                
------------------------------------------------------------------------- -->



<!-- This section provides the bootstrap CDN for the page -->
<!-- It could have been adden via PHP, but simple = better in this instance -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body style="padding:50px;">
<h1>Program 01 - CJM</h1><br/>
</body>



<?php
// This code references the database, so data goes to the right place
require ("database.php");
session_start();

// Customer object will be the center of all actions
class Customer {

	// Declare all elements for each customer
	// Primary Key = $id
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
	// Code uses HTML to construct the table of all customers
	public function displayRecords () {
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
		
		// iterate through each entry in the table, then create a row in the tanle for it
		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td width=250>';
			// Three functions create the C/R/D buttons for each.
			$this->displayReadButton($row);
			echo '&nbsp;';
			$this->displayUpdateButton($row);
			echo '&nbsp;';
			$this->displayDeleteButton($row);
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		Database::disconnect();
	}

	// Function displays and formats the create button on call
	function displayCreateButton(){
		echo "<div style='width:250px;margin-left:auto;margin-right:auto;content-align:center;'>";
		echo "Press button to add entry.&nbsp;&nbsp;";
		echo "<a href='create.php' class='btn btn-success' style='margin-bottom:20px;'>Create</a>";
		echo "</div>";

	}


// FUNCTIONS TO FORM ALL THE BUTTONS
	function displayReadButton($row){
		echo '<a class="btn btn-info" href="read.php?id='. $row['id'].'">Read</a>';
	}

	function displayUpdateButton($row){
		echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
	}

	function displayDeleteButton($row){
		echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
	}
// BUTTON FUNCTIONS END
}


// Actually declar a Customer, iterate correct buttons
$cust1 = new Customer;
$cust1->displayCreateButton();
$cust1->displayRecords();
if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['empl_id'] == 2) $cust1->login(2);

?>