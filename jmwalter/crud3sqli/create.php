<?php 
	//includes the class file
	include 'musician.php';
	
	//object to call functions from 
	$musician = new Musician;
		
	//if the post had data
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		// gets the post values from the form created in musician.php
		$name = $_POST['name'];
		$email = $_POST['email'];
		$instrument = $_POST['instrument'];
		//calls the create Musician method to insert a record
		$musician->createMusician($name,$instrument,$email);
	}
	else 
		//calls the createPrompt that sets up the form but does not enter anything.
		$musician->createPrompt();
		
		show_source(__FILE__);
?>
