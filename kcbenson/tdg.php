<?php
	require ("crud/database.php");
	session_start();
	
	class Customer {
		private static $id;
		private static $name;
		private static $email;
		private static $mobile;
		private static $deleteFreds;
		
		public function insertFred() {
			$name = "Fred";
			$email = "fred@fred.com";
			$mobile = "555.867.5309";
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile));
			Database::disconnect();
			//header("Location: tdg.php");
		}
	
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
			if ($_SESSION['empID'] == $row['employerID']) {
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
	function deleteAllFreds() {
		$name = "Fred";
		$pdo = Database::connect();
		$sql = "DELETE FROM customers WHERE name = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		Database::disconnect();
	}
	function __construct () {
		$deleteFreds = $_GET['deleteFreds'];
	}
	function displayDeleteFredButton() {
		echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>Delete All Freds</a><br />";
	}
	function displayLoginButton() {
		echo "<a href='tdg.php?empID=1' class='btn btn-success'>Set Employer ID to One</a>";
	}
	function displayCreateScreen() {
		//echo HTML head
		echo'<!DOCTYPE html>
		<html lang="en">
		<head>
			<!-- The head section does the following: 
				1. Sets the character set
				2. includes Bootstrap
				-->
			<meta charset="utf-8">
			<link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>';
		//echo body
		echo'<body>
			<div class="container">
      			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">';
		<?php if (!empty($nameError)): ?>
		echo '<span class="help-inline"><?php echo $nameError;?></span>';
		<?php endif; ?>
		echo' </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">';
		<?php if (!empty($emailError)): ?>
		echo'<span class="help-inline"><?php echo $emailError;?></span>';
		<?php endif;?>
		echo' </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">';
		<?php if (!empty($mobileError)): ?>
		echo'<span class="help-inline"><?php echo $mobileError;?></span>';
		<?php endif;?>
		echo' </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						  <a href="logout.php" class="btn btn-success">Logout</a
						</div>
					

						
							</form>
						</div>
						
		</div> <!-- /container -->
		</body>
		/html>';
	}
	function login($empID) {
		$_SESSION['empID'] = $empID;
	}
	function delete() {
		
	}
	function update() {
		
	}
	function read() {
		
	}
	function create() {
		
	}
	
	
	}	
	$cust1 = new Customer;
	$cust1->insertFred();
	$cust1->displayDeleteFredButton();
	$cust1->displayLoginButton();
	if ($_GET['empID'] == 1) $cust1->login(1);
	if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();
	$cust1->displayRecords();
	print_r ($_SESSION);
	
?>