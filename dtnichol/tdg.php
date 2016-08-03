<?php
require ("crud/database.php");
session_start();

class Customer {
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	private static $deleteFreds;
	
	
	public function insertFred () {
		
		$name = "Fred";
		$email = "fred@fred.com";
		$mobile = "867.5309";
		
		
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
						echo '<td width=350>';
						echo '<a class="btn" href="read.php?id='.
						$row['id'].'">Read</a>';
						echo '&nbsp;';
						if ($_SESSION['id'] == $row['id']) {
							echo '<a class="btn btn-success" 
							href="update.php?id='.$row['id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" 
							href="delete.php?id='.$row['id'].'">Delete</a>';
						}
						echo '&nbsp;';
						echo '<a class="btn" href="ratingsList.php?id='.$row['id'].'">Rate</a>';
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
	
	function displayDeleteFredButton () {
		echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>Delete All Freds</a><br />";
		
	}
	
	function displayLoginButton () {
		echo "<a href='tdg.php?empl_id=1' class='btn btn-success'>SET Empl ID to One</a><br />";
		
	}
	
	function __construct () {
		
		$deleteFreds = $_GET['deleteFreds'];
	}

	function login ($empl_id){
		$_SESSION['empl_id'] = $empl_id;
		
	}
	
	function displayCreateScreen(){
		echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="tdg.php" method="post">
						<input name="create" value="create" type="hidden"/>
					
					  <div class="control-group ">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" ">
					      	
					    </div>
					  </div>
					  
					  <div class="control-group ">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" ">
					      	
					    </div>
					  </div>
					  <div class="control-group ">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" ">
					      	
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="tdg.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
		';
		
	}
	
	function createRecord($name, $email, $mobile){
		
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile));
			Database::disconnect();
			header("Location: tdg.php");
	}
	
	
}
$cust1 = new Customer;

if(!empty($_POST['create'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$cust1->createRecord($name, $email, $mobile);
	
}

//$cust1->insertFred();
$cust1->displayDeleteFredButton();
$cust1->displayLoginButton();
if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();
$cust1->displayRecords();
echo "<br />";
print_r($_SESSION);

$cust1->displayCreateScreen();

?>




