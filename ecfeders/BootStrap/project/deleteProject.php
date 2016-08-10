<?php
/* *******************************************************************  
* filename     : deleteProject.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php asks the user if they really want to delete
				 the sheet if yes delete in no then dont delete
 *  
 * processing   : The program steps are as follows.   
 *          1. display page
 *          2. wait for button click
 *          3. after button click go to correct form 
 *          4. based on button click do operations  
 
 * output       : deleted sheet
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: deletes the sheet from the sheets table
 * *******************************************************************   */ 
 ?>
 
<?php
	session_start();
	if(empty($_SESSION['name'])){
		header("Location: loginProject.php"); // redirect 
    }
?>

<?php 
	require 'databaseProject.php';
	$id = 0;
	
	//Get IF
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM sheet  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: project.php");
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<link href="css/delete.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Delete a Sheet</h3>
		    		</div>
		    		
					<!-- Form That asks user if they really want to delete the record
					-->
	    			<form class="form-horizontal" action="deleteProject.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="project.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>