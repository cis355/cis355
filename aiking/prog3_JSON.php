<?php

/* ------------------------------------------------------------------------
filename  : prog3_JSON.php
author    : Alexander King
date      : 2016-08-05
email     : aiking@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~aiking/cis355/aiking/prog3_JSON.php
backup    : github.com/cis355/cis355
purpose   : This file serves as Alexander King's program #3, 
			CIS-355: Server Side Web Development, 
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
			George Corser's webService.php
program structure:
	Session start, class creation {
	declaration of variables, printJSON function }, new toursistJSON, printJSON. 
------------------------------------------------------------------------- */
 
 //Creates a new session.
 session_start();
 
 #Connection to the database
$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');

//Class holds all content of database and object.
 class touristJSON {
	 
	 //Declaration of table variables.
	 private static $id;
	 private static $name;
	 private static $email;
	 private static $mobile;
	 private static $originCountry;
	 
	public function printJSON () {
	//***************************************************
	//Purpose: This function prints the table as JSON object.
	//
	//Input: None.
	//
	//Pre: Connection to db is ok.
	//
	//Output: html
	//
	//Post: The table is printed as a JSON object in browser html.
	//
	//Note: Connects with mysqli to db and gathers data.
	//***************************************************


		echo '{'; // begin the object
		echo '"tourists":';
		echo '['; // begin the array
	
		//Connection to database.
		$con = mysqli_connect('localhost', 'aiking', '541799', 'aiking');
		//MySQL statement to retrieve from table.
		$sql = 'SELECT * FROM tourists ORDER BY id DESC';
		
		$str = '';
		//Prints all the content of the table, uses MySQLi instead of PDO.
		foreach (mysqli_query($con, $sql) as $row) {
			$str .= '{';
			$str .=  '"id":"'. $row['id'] . '", ';
			$str .=  '"name":"'. $row['name'] . '",';
			$str .=  '"email":"'. $row['email'] . '",';
			$str .=  '"mobile":"'. $row['mobile']. '"';
			$str .=  '"originCountry":"' . $row['originCountry']. '"';
			$str .=  '},';
		}
		$str = substr($str, 0, -1); // remove last comma
		echo $str;
		
		//Close connection to database.
		mysqli_close($con);
		echo ']'; // close the array
		echo '}'; // close the object
	}
}

//Create new object and print.
$tour = new touristJSON;
$tour->printJSON();

//Adds link to UML class diagram.
echo '</br></br></br>';
echo 'Click <a style="font-size: 20px;" href="prog2.pdf" target="_blank">HERE</a> for UML class diagram.';
echo '</br></br></br>';
 
 show_source(__FILE__);
?>