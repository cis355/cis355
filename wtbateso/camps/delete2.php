<!-- ------------------------------------------------------------------------
* filename : delete2.php
* author : William Bateson
* username : wtbateso
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : this file deletes information from the basketball camps
*
* input : N/A
* processing : The program steps are as follows.
* 1. initialize session
* 2. display buttons
* 3. delete from table using id
*
* output : buttons
*
* precondition : check for login
* postcondition: information printed to the screen, and delete information from tables
* 
*              
------------------------------------------------------------------------- -->
<?php 	
	require 'database.php';
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM camps WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: camps2.php");
		
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
		    			<h3>Delete a Camp</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete2.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="camps2.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>