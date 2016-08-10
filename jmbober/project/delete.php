<?php 
/* *******************************************************************
* filename : delete.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : Deletes a song from the songs database
*
* Structure: 
             PHP:
                Start session and check username
                if $_POST is not empty
                  -find $id
                  -Delete record from database
*            HTML:
                Head -- contains links for bootstrap 
                Body -- contains form for user to choose whether to delete song
*

* precondition : $id is sent in $_GET 
                 database.php must exist with a valid connection to the database
                 songs table must exist in the database
                 a record in songs must have an id that matches the id sent
* postcondition: The record is deleted from the table
*
* Code adapted from George Corser
* *******************************************************************/
  session_start();
  if (empty($_SESSION['username'])) header("Location: login.php"); // redirect
  
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
		$sql = "DELETE FROM songs WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
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
          <h3>Delete a Song</h3>
        </div>
        <!-- FORM -->
        <form class="form-horizontal" action="delete.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id;?>"/>
          <p class="alert alert-error">Are you sure you want to delete?</p>
          <div class="form-actions">
            <button type="submit" class="btn btn-danger">Yes</button>
            <a class="btn" href="index.php">No</a>
          </div>
        </form>
      </div>
		</div> <!-- /container -->
  </body>
</html>