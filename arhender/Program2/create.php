<?php
/* *******************************************************************
 filename     : create.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the php for calling methods to show the form and logic to error check
				 and call a method to actually perform the insert into the database.
 
Process:
1. If post is empty instantiate the class and use the method to display the create page
2. If post isn't empty check the values if they aren't blank use the create method to insert into artworks

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/create.php

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************  */
show_source(__FILE__);
require 'artworks.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) 
	{
		// keep track validation errors
		$titleError = null;
		$artistError = null;
		$styleError = null;
		
		// keep track post values
		
		$art = new artwork($_POST['title'],$_POST['artist'],$_POST['style']);
		
		
		// validate input
		$valid = true;
		if (empty($art->gettitle())) 
		{
			$titleError = 'Please enter a title';
			$valid = false;
		}
		
		if (empty($art->getartist())) 
		{
			$artistError = 'Please enter an artist';
			$valid = false;
		
		}
		
		if (empty($art->getstyle())) 
		{
			$styleError = 'Please enter a style';
			$valid = false;
		}
		
		// insert data
		if ($valid) 
		{
			$art->create();
			header("Location: index.php");
		}
	} # end if ( !empty($_POST))
		
	$art = new artwork();
	
	$art->showcreate();
		

?>