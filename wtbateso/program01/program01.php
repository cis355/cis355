<?php

	
	session_start(); 
	require ("crud/database.php"); 
	
	class Customer { 

		// Create static fields
		private static $id; 
		private static $name; 
		private static $email; 
		private static $mobile; 
		private static $deleteFreds; 
		 
		// insert a new row into table
		public function insertNew () { 
		 
			echo "<a href='create.php' class='btn btn-success'>Create New</a><br />";
			
			$name = "Fred"; 
			$email = "fred@fred.com"; 
			$mobile = "123.456.7890"; 
		 
			$pdo = Database::connect(); 
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "INSERT INTO customers2 (name,email,mobile) values(?, ?, ?)"; 
			$q = $pdo->prepare($sql); 
			$q->execute(array($name,$email,$mobile)); 
			Database::disconnect(); 
			// header("Location: product01.php"); 
		} 
		 
		// show records in table format
		public function displayRecords () { 
			echo '<br />';
			$pdo = Database::connect(); 
			$sql = 'SELECT * FROM customers2 ORDER BY id DESC'; 
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
				echo '<td width=200>'; 
				echo '       ';
				echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
				echo '       ';
				echo '<a class="btn" href="update.php?id='. $row['id'].'">Update</a>';		
				echo '       ';
				echo '<a class="btn" href="delete.php?id='. $row['id'].'">Delete</a>';				
				echo '&nbsp;'; 
				if ($_SESSION['empl_id'] == $row['employer_id']) { 
					echo '<a class="btn btn-success"  
					   href="update.php?id='.$row['id'].'">Update</a>'; 
					echo '&nbsp;'; 
					echo '<a class="btn btn-danger"  
					   href="delete.php?id='.$row['id'].'">Delete</a>'; 
				} 
				echo '</td>'; 
				echo '</tr>'; 
			} 
			echo '</tbody></table>'; 
			Database::disconnect(); 
		} 
		 
		function displayDeleteButton () { 
			echo "<a href='delete.php' class='btn btn-success'>Delete </a><br />"; 
		} 
		 
		function displayLoginButton () { 
			echo "<a href='login.php' class='btn btn-success'>Login</a><br />"; 
		} 
	} 

	$cust1 = new Customer; 
	$cust1->insertNew();  
	$cust1->displayLoginButton(); 
	$cust1->displayRecords(); 
	echo "<br /><br /><br />"; 
	

?>