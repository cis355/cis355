<?php

require ('crud/database.php');
session_start();


# CREATE FUNCTIONS
if ( !empty($_POST)) {
	// keep track validation errors
	$nameError = null;
	$emailError = null;
	$mobileError = null;
	
	// keep track post values
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	
	// validate input
	$valid = true;
	if (empty($name)) {
		$nameError = 'Please enter Name';
		$valid = false;
	}
	
	if (empty($email)) {
		$emailError = 'Please enter Email Address';
		$valid = false;
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$emailError = 'Please enter a valid Email Address';
		$valid = false;
	}
	
	if (empty($mobile)) {
		$mobileError = 'Please enter Mobile Number';
		$valid = false;
	}
	
	// insert data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
		// header("Location: index.php");
	}
}

# END CREATE FUNCTIONS




class Customer {
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	private static $deleteFreds;
	
	public function insertFred(){
		
		$name = "Fred";
		$email = "fred@fred.com";
		$mobile = "123.456.7890";
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
		// header("Location: tdg.php");
	}
	
	public function displayRecords() {
		
		echo '<table class="table table-striped table-bordered">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Name</th>';
		echo '<th>Email Address</th>';
		echo '<th>Mobile Number</th>';
		echo '<th>Action</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		foreach ($pdo->query($sql) as $row) {
			
				echo '<tr>';
				echo '<td>'. $row['name'] . '</td>';
				echo '<td>'. $row['email'] . '</td>';
				echo '<td>'. $row['mobile'] . '</td>';
				echo '<td width=250>';
				echo '<a class="btn btn-info" href="read.php?id='.
				   $row['id'].'">Read</a>';
				echo '&nbsp;';
				#if($_SESSION['empl_id'] == $row['empl_id']){
					echo '<a class="btn btn-success" 
					   href="update.php?id='.$row['id'].'">Update</a>';
					echo '&nbsp;';
					echo '<a class="btn btn-danger" 
					href="tdg.php?deleteId='.$row['id'].'">Delete</a>';
				#}
				echo '</td>';
				echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
		Database::disconnect();
	}
	
	
	
	# DELETE-RELATED FUNCTIONS
	function deleteAllFreds() {
		$name = "Fred";
		$pdo = Database::connect();
		$sql = "DELETE FROM customers WHERE name = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		Database::disconnect();
	}
	
	function displayDeleteFredButton() {
		echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>Delete All Freds!!</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	
	function __construct () {
		$deleteFreds = $_GET ['deleteFreds'];
		$deleteId = $_GET ['deleteId'];
	}
	# END DELETE RELATED FUNCTIONS
	
	
	
	
	# LOGIN - RELATED FUNCTIONS
	function login($empl_id){
		$_SESSION['empl_id'] = $empl_id;
	}
	
	function displayLoginButton() {
			echo "<a href='tdg.php?empl_id=1' class='btn btn-success'>Set EMP_ID to One</a>&nbsp;&nbsp;&nbsp;&nbsp;<br /> <br />";
		}
	# END LOGIN - RELATED FUNCTIONS
	
	
	function displayCreateScreen(){
			echo "<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal'>Create New Record</button>";
	}
	
	
}




# BEGIN DELETE FUNCTIONS
function deleteEntry() {
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: index.php");
		
	} 
}
# END DELETE FUNCTIONS
	
	
	
	
echo '&nbsp;&nbsp;&nbsp;&nbsp;<br /> <br />';

$cust1= new Customer;
$cust1->insertFred();
$cust1->displayCreateScreen();
$cust1->displayLoginButton();
#if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();
$cust1->displayRecords();

?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</head>


<body style="padding:20px">

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		
		<!-- Modal content -->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
			  <div class="span10 offset1" style="margin-left:30px">
    				<div class="row">
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="tdg.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type='submit' class="btn btn-success">Create</button>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	</div>
	<br/>

	
</body>