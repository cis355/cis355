<?php 
	//includes the class file 
	include 'musician.php';
	$id = null;
	//get the id of the musician deleted from the url
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		//if the get had no id go back to index
		header("Location: index.php");
	} else {
		//object to call functions from
		$musician = new Musician;
		
		//shows the yes/no prompt for delete
		$musician->showDeleteChoice($id);
		if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		//method call to the function that deletes the record with id $id
		$musician->deleteMusician($id);
		}	
	}
show_source(__FILE__);	
?>
