<!--/* *******************************************************************
* filename : readCustomer.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : displays the customer info from table on separate page.                
*               
*
* input : none
* processing : The program steps are as follows.
* 		1. when read is clicked it displays the customer info from table on separate page.
* 		
* 		
* 		
* output : displays the customer info from table on separate 
*
* precondition : none
* postcondition: displays the customer info from table on separate page.
* 				 
* *******************************************************************
*/-->

<?php
//keeps track of users session who are logged in
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>

<?php 
	//populates the read section for customers to read their info
	require 'database.php';//connects to database
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index1.php");
	} else {//sql statement to pull info from database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers1 where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
						     	<?php echo $data['name'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Email Address</label>
						     	<?php echo $data['email'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Mobile Number</label>
						     	<?php echo $data['mobile'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="index1.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>