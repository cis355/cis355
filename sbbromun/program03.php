<?php
/* *******************************************************************
* filename : program03.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This program returns the contents of a database table
* 				as a json object.

* input : none
* processing : The program steps are as follows.
* 1. Create new response object
* 2. call outputJSON() to print json object
*
* precondition : A response table exists on the specified database.
* postcondition: Contents of JSON retrieved from database printed.
* *******************************************************************
*/
require ("crud/database.php");
class Response {
	private static $id;
	private static $questionID;
	private static $responseID;
	private static $correctResponse;

	
	public function outputJSON () { 
	//Function prints out JSON object holding contents of table
	/* *******************************************************************
	* input : N/A
	* processing : The method prints out a stirng retrieved from database in
	* JSON form. 
	* output : JSON formatted object printed to screen
	*
	* precondition : a response table exists on the database
	* postcondition: JSON object printed to screen.
	* *******************************************************************
	*/
        echo '{'; //begin object
		echo '"Responses":'; //Title
		echo'['; //open array
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM responses ORDER BY id DESC'; 
		$str = ''; //building JSON string on this.
		//for every record returned print out the field name and value.
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"ID":"'. $row['id'] . '", '; 
            $str .=  '"Question Number":"'. $row['questionID'] . '",'; 
            $str .=  '"Response Number":"'. $row['responseID'] . '",'; 
            $str .=  '"Correct Response":"'. $row['correctResponse'] . '"'; 
            $str .=  '},'; 
        } 
        $str = substr($str, 0, -1); // remove last comma 
        echo $str; //Print JSON object
         
        Database::disconnect(); 
		echo ']';//end array
		echo '}'; //end object
    } 
}

$resp = new Response; 
$resp->outputJSON(); 
echo '<br /> <br /> <br />';
echo '<img src="program03.png"><br />';
show_source(__FILE__);


?>