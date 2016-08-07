<?php
/* *******************************************************************
 filename     : index.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains a method to display the main form to move to each area of processing
				 displaying the table of customers who currently exist in the database.
 
Process:
1. instantiate an object of type artwork
2. perform the showindex method to display the page via the class

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/index.php

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************  */
show_source(__FILE__);

require 'artworks.php';

$art = new artwork();

$art->showindex();



?>