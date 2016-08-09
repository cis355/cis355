<!-- 
filename  : program03.php
author    : Erika McLean
date      : 2016-05-10
email     : elmclean@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~elmclean/cis355/elmclean/program03/program03.html
backup    : github.com/cis355/cis355
purpose   : This file serves as a menu template for the course, 
			CIS-255: Client Side Web Development, 
			at Saginaw Valley State University (SVSU)
copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
external code used in this file: 
			Based off various bootstrap templates 

program structure : 
	php: start session, require database file
	class Visits: private variables, public print() function
    main: new Visits class object and call to print() function
    final: show php source function
-->

<?php 
    session_start();  // create session 
    require ("database.php");  // database connection file

    /**
     *  Visit class creates an instance of a park tourist visit
     */
    class Visit {  
        // create static fields 
        private static $park_id;  
        private static $tourist_id;  
        private static $visit_date;

		/**
	     *  Display link for UML class diagram
	     */
        function umlDiagram() {
        	echo '<p><a href="http://csis.svsu.edu/~elmclean/cis355/elmclean/program03/McLean_Program03Diagram.png">Click here for UML class diagram</a></p>';
        }

        /**
	     *  Select data from the table into an array, then a JSON object
	     */
        function printTable() {
        	$connection = mysqli_connect('localhost', 'elmclean', '604577', 'elmclean');
        	$sql = 'SELECT * FROM visits ORDER BY park_id DESC';  // select statement
        	
        	$dataArray = [];  // initialize empty array
        	foreach (mysqli_query($connection, $sql) as $row) {  // loop through each record
            	array_push($dataArray, $row);  // push record into array
        	} 
        	echo json_encode($dataArray);  // convert array into JSON object and print to screen
        }
    }


    // create new object and print
	$visit = new Visit;
	$visit->umlDiagram();
	$visit->printTable();

	echo '<br /><br />';
    show_source(__FILE__);  // show source code
?>