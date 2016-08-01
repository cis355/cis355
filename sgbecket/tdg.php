<?php
require ("crud/database.php");
	class Customer {
	
		private static $deleteFreds; //sets delete freds
		
		private static $id; //varchar
		private static $name; //varchar
		private static $email; //varchar
		private static $mobile; //varchar
		
		public function insertFred() {
		
		$name = "Fred";
		$email = "fred@red.bed";
		$mobile = "123.123.1234";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
		//header("Location: tdg.php");
		}
		
		public function displayRecords (){
					   #connect to database and assign object to variable
					   $pdo = Database::connect();
					   #assign select statement to a variable.
					  echo '<a class="btn" href="create.php">Create New Record</a>';
					  echo '<table class="table table-striped table-bordered">';
		              echo '<thead>';
		              echo '  <tr>';
		              echo '    <th>Name</th>';
		              echo '    <th>Email Address</th>';
		              echo '    <th>Mobile Number</th>';
		              echo '    <th>Action</th>';
		              echo '  </tr>';
		              echo '</thead>';
		              echo '<tbody>';
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
					   #populates table with information received from the database customers table
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
							   	echo '&nbsp;';
								//if ($_SESSION['empl_id'] == $row['employer_id']){
								
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
								//}
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					   echo'</tbody>';
					   echo'</table>';
		}
		
		function deleteAllFreds () {
			$name = "Fred";
			$pdo=Database::connect();
			$sql = "DELETE FROM customers WHERE name = ? ";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			Database::disconnect();
		}
		function displayDeleteFredButton(){
			echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>Delete Fred Button!!!</a><br/>";
		}
		function displayLoginButton(){
			echo "<a href='tdg.php?empl_id=0' class='btn btn-success'>Login As One!!!</a><br/>";
		}
		function login($empl_id){
			$_SESSION['empl_id'] = $empl_id;
		}

		
	}
	$cust1 = new Customer;
	$cust1 -> insertFred();
	$cust1 -> displayDeleteFredButton();
	$cust1 -> displayLoginButton();
	if ($_GET['deleteFreds'] == 'yes'){
		$cust1->deleteAllFreds();
	}
	if($_GET['empl_id'] == 0){
		$cust1 -> login(1);
	}
	$cust1 -> displayRecords();
print_r ($_SESSION);
	
?>