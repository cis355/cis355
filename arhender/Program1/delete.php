<?php 

/* *******************************************************************
 filename     : delete.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the error checking, processing and HTML
				required in order to delete a customer from the 
				database
				
Process:
1. get the id from the $_GET array
2. make sure post isn't empty
3. instantiate an object
4. set the id in that object
5. use the delete method of the object
6. redirect
*********************************************************************  */
	require 'customer.php';
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		$Cust = new customer();
		$Cust->setid($id);
		$Cust->delete();
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
		    			<h3>Delete a Customer</h3>
		    		</div>
		    		
					<?php #prompt if they wish to actually delete or not ?>
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-warning" href="index.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>