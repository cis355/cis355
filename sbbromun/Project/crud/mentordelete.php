<?php 
/* *******************************************************************
* filename : mentordelete.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file prompts the user to ensure they want to delete
* a record from the database table(Mentors).

* input : user input
*
* precondition : database with tables: Mentors
*	User clicked Delete on the mentorindex.php page.
* postcondition: Record deleted to Mentors table.
* *******************************************************************
*/
	require 'database.php';
	$mentorID = 0;
	
	if ( !empty($_GET['mentorID'])) {
		$mentorID = $_REQUEST['mentorID'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$mentorID = $_POST['mentorID'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Teachers  WHERE mentorID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($mentorID));
		Database::disconnect();
		header("Location: mentorindex.php");
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
		    			<h3>Delete a Mentor</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="mentordelete.php" method="post">
	    			  <input type="hidden" name="mentorID" value="<?php echo $mentorID;?>"/>
					  <p class="alert alert-error">Are you sure you want to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-primary" href="mentorindex.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>