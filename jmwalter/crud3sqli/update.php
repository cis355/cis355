<?php 
	//includes the class file
	include 'musician.php';

	$id = null;
	//gets the id from the url 
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	
	if ( null==$id ) {
		//if there was no id go back to index.php
		header("Location: index.php");
	}
	//object to call methods from 
	$musician = new Musician;
	
	if ( !empty($_POST)) {

		// get the data from the post form made by fill musician fields 
		$name = $_POST['name'];
		$instrument = $_POST['instrument'];
		$email = $_POST['email'];
		
		//updates the musician info with the parameter data
		$musician->updateMusician($name,$instrument,$email,$id);

	}
	else {
		//prints the existing data to the fields  
		$musician->fillMusicianFields($id);
	}
	show_source(__FILE__);
?>
