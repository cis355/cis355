<?php 
	//includes the class file 
	include 'musician.php';

	$id = null;
	
	//gets the musician id from the url
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		//if there was no id in the url go back to index.php
		header("Location: index.php"); 
	} else {
		//object to call methods from 
		$musician = new Musician;
		
		//read method for musician data with id $id
		$musician->readMusician($id);
	}
	show_source(__FILE__);
?>
