<!-- ------------------------------------------------------------------------
Filename  : Program01.php
author    : Gage Beckett
date      : 2016-07-21
email     : sgbecket@svsu.edu
course    : CIS-355
link      : http://csis.svsu.edu/~sgbecket/cis355/sgbecket/program01/program01.php
backup    : github.com/cis355/cis355
purpose   : to demonstrate knowledge of databases & PHP

copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
external code used in this file: 
				Used Corser's base for CRUD.
				Worked with CMealey
			
program structure : 
	<head> metadata
	<body> contains the classes and boxes for dragging and dropping
------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body style="padding:50px;">
<h1>Program 01 </h1><br/>
</body>



<?php
require ("database.php");
session_start();


class Customer {

    private static $id;
    private static $name;
    private static $email;
    private static $mobile;
    

    //function that displays the database in a table. 
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
        //loop that creates a row and populates each row with the database elements
        foreach ($pdo->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['name'] . '</td>';
            echo '<td>'. $row['email'] . '</td>';
            echo '<td>'. $row['mobile'] . '</td>';
            echo '<td width=250>';
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
	//function that displays the button that connects to the create.php file
    function displayCreateButton(){
        echo "<a href='create.php' class='btn btn-success' style='margin-bottom:20px;'>Create New</a>";

    }
		//function that displays the button that connects to the read.php 
    function displayReadButton($row){
        echo '<a class="btn btn-info" href="read.php?id='. $row['id'].'">Read</a>';
    }
	//function that displays the button that connects to the update.php file

    function displayUpdateButton($row){
        echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
    }
	//function that displays the button that connects to the delete.php file

    function displayDeleteButton($row){
        echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
    }
}
//new class object
$cust1 = new Customer;
$cust1->displayCreateButton();
$cust1->displayRecords();
if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['empl_id'] == 2) $cust1->login(2);
