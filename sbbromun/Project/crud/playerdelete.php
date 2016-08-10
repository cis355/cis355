<?php 
/* *******************************************************************
* filename : playerdelete.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file prompts the user to ensure they want to delete
* a record from the database table(Players).

* input : user input
*
* precondition : database with tables: Players
*	User clicked Delete on the index.php page.
* postcondition: Record deleted to Players table.
* *******************************************************************
*/
	require 'database.php';
	$learnerID = 0;
	
	if ( !empty($_GET['learnerID'])) {
		$learnerID = $_REQUEST['learnerID'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$learnerID = $_POST['learnerID'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Players  WHERE learnerID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($learnerID));
		Database::disconnect();
		header("Location: index.php");
		
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
		    			<h3>Delete a Learner</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="playerdelete.php" method="post">
	    			  <input type="hidden" name="learnerID" value="<?php echo $learnerID;?>"/>
					  <p class="alert alert-error">Are you sure you want to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-primary" href="index.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>