<?php
/* *******************************************************************
 filename     : delete.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the php for calling methods to show the form and logic to 
				 call a method to actually delete the record in context from the database.
 
Process:
1. If get is empty redirect to index.php
2. If get isn't empty check the and post is then display the prompt if the user really wants to delete
3. If get isn't empty check the and post isn't but user doesn't want to delete redirect back to index.php
3. If get isn't empty check the and post isn't and user wants to delete, instantiate object, delete, redirect back to index.php

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/delete.php?id="currentidincontext"

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************  */
show_source(__FILE__);
require 'artworks.php';
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
	
		$id = $_POST['id'];
		
		$art = new artwork();
		$art->setid($id);
		
		
		$art->delete();
		
		header("Location: index.php");
		
	} 
	
	$art = new artwork();
	$art->setid($id);
	$art->showdelete();
	
	
	?>