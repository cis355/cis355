<?php
//uml diagram is at https://www.lucidchart.com/documents/edit/036fc9fb-7f85-4f81-a378-23202c915be2#?=undefined
//includes the class file 
include 'musician.php';

//creates the object used to call methods
$musician = new Musician;

//lists all musicians in a table
$musician->listMusicians();
show_source(__FILE__);

?>