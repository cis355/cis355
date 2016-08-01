<?php

/* *******************************************************************

* filename : program01.php

* author : Kelsi Benson

* username : kcbenson

* course : cs355

* section : 11-MW

* semester : Summer 2016

*

* description : This program creates a 

* table of records by referencing the customers

* table in the linked database (database.php), 

* allows the user to create, read, update and

* delete records.

* The purpose of this program is to demonstrate

* an object-oriented CRUD program

*

* input : records from database

* processing : The program steps are as follows.

* 1. connect to the database

* 2. display the create new record button

* output : table of records with read, update

* and delete buttons next to each record

*

* precondition : database.php must be included 

* as it hold the database connection code

* *******************************************************************

*/

	require ("database.php");

	

	//create customer class

	class Customer {

		private static $id;

		private static $name;

		private static $email;

		private static $mobile;

	

	//connect to database and build table of records

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

		 

		 foreach ($pdo->query($sql) as $row) {

		  	echo '<tr>';

		   	echo '<td>'. $row['name'] . '</td>';

		   	echo '<td>'. $row['email'] . '</td>';

		   	echo '<td>'. $row['mobile'] . '</td>';

		   	echo '<td width="250">';

		   	echo '<a class="btn" href="read.php?id='.

			   $row['id'].'">Read</a>';

		   	echo '&nbsp;';

		   	echo '<a class="btn btn-success" 

			   href="update.php?id='.$row['id'].'">Update</a>';

		   	echo '&nbsp;';

		   	echo '<a class="btn btn-danger" 

			   href="delete.php?id='.$row['id'].'">Delete</a>';

		   	echo '</td>';

		   	echo '</tr>';

		 }

		 echo '</tbody></table>';

		 Database::disconnect();

	}

	

	//display the create button and link to create.php when clicked

	function create() {

		echo "<a href='create.php?create=yes' class='btn btn-success'>Create New Record</a>";

	}

	

	}

?>

<html lang="en">

<head>

	<!-- The head section does the following: 

		1. Sets the character set

		2. includes Bootstrap

		-->

    <meta charset="utf-8">

    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>

<body>

	<h2>Customer Records</h2>

</body>

</html>

<?php

	$cust1 = new Customer;

	$cust1->create();

	$cust1->displayRecords();

?>