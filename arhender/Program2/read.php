<?php
/* *******************************************************************
 filename     : read.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the php for calling methods to show the form and logic to error check
				 and call a method to actually perform the read from the database.
 
Process:
1. If post is empty instantiate an object of artwork
2. use the display read method

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/read.php?id="currentidincontext"

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************/
show_source(__FILE__);

     require 'artworks.php';
	
     $art = new artwork();

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$art->setid($id);
		$art->read();
		
		$art->showread();
	}


?>