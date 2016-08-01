<?php
//includes the class file 
include 'musician.php';

//creates the object used to call methods
$musician = new Musician;

//lists all musicians in a table
$musician->listMusicians();
show_source(__FILE__);

?>