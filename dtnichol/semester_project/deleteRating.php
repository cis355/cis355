<!--/* *******************************************************************
* filename : deleteRating.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : deletes rating from the database.                
*               
*
* input : none
* processing : The program steps are as follows.
* 		1. admin clicks delete button for rating
* 		2. submits delete form that follows
* 		3. rating is deleted from database table
* 		
* output : none
*
* precondition : none
* postcondition: rating deleted from database
* 				 
* *******************************************************************
*/-->


<?php 
	//delete customer rating
	//keeps track of users session who are logged in
	session_start();
	//if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect
	
	require 'database.php';
	$id = null;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'DELETE FROM `ratings1` WHERE id = ?';
		
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		var_dump($sql);
		Database::disconnect();
		header("Location: restaurant.php");
		
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
		    			<h3>Delete this Rating</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="deleteRating.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="restaurant.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>